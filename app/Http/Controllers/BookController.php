<?php

namespace App\Http\Controllers;

use App\Classes\TelegramMessage;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Services\TelegramNotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    private $telegramService;

    public function __construct(TelegramNotificationService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $catId = $request->input('catId');

        $books = DB::table('books')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->leftJoin('reviews', 'books.id', '=', 'reviews.book_id')
            ->select('books.*', 'categories.name as category_name', 'categories.color as category_color', DB::raw('AVG(reviews.rating) as avg_rating'))
            ->distinct()

            // Apply search filter if provided
            ->when($search, function ($query, $search) {
                if ($search) {
                    $query->where(function($query) use ($search) {
                        $query->where('books.title', 'like', "%{$search}%")
                            ->orWhere('books.author', 'like', "%{$search}%")
                            ->orWhere('books.isbn', 'like', "%{$search}%");
                    });
                }
            })

            // Apply category filter if catId is provided
            ->when($catId, function ($query, $catId) {
                if ($catId) {
                    $query->where('books.category_id', '=', $catId);
                }
            })

            ->groupBy('books.id', 'categories.id')

            ->get();

        $categories = Category::all();

        return view('books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'isbn' => 'required|string|size:13|unique:books,isbn',
            'stock' => 'required|integer|min:0',
            'number_of_pages' => 'required|integer|min:1',
            'cover_image' => 'required|image|max:2048',
            'publication_date' => 'required|date|before_or_equal:today',
            'category_id' => 'required|integer|exists:categories,id'
        ]);

        $bookData = $request->only(['title', 'author', 'description', 'isbn', 'stock', 'number_of_pages', 'publication_date', 'category_id']);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('covers', $filename, 'public');
            $bookData['cover_image'] = $filename;
        }

        $book = Book::create($bookData);

        $telegramMessage = new TelegramMessage('Book', $book->title, 'Create', Auth::user()->full_name);
        $this->telegramService->sendMessage($telegramMessage);

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    public function show(string $id) {
        $book = Book::with('category')->FindOrFail($id);
        $reviews = Review::with('member')
            ->where('book_id', $id)
            ->get();

        return view('books.show', compact('book', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();

        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'isbn' => 'required|string|size:13|unique:books,isbn,' . $book->id,
            'stock' => 'required|integer|min:0',
            'number_of_pages' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|max:2048',
            'publication_date' => 'required|date|before_or_equal:today',
            'category_id' => 'required|integer|exists:categories,id'
        ]);


        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('covers', $filename, 'public');
            $book->cover_image = $filename;
        }

        $book = $book->update($request->except('cover_image'));

        $telegramMessage = new TelegramMessage('Book', $book->title, 'Update', Auth::user()->full_name);
        $this->telegramService->sendMessage($telegramMessage);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->cover_image) {
            Storage::disk('public')->delete('covers/' . $book->cover_image);
        }

        $book->delete();

        $telegramMessage = new TelegramMessage('Book', $book->title, 'Delete', Auth::user()->full_name);
        $this->telegramService->sendMessage($telegramMessage);

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
