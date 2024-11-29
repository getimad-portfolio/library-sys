<?php

namespace App\Http\Controllers;

use App\Classes\TelegramMessage;
use App\Http\Requests\BorrowRequest;
use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Member;
use App\Models\Book;
use App\Models\Review;
use App\Services\TelegramNotificationService;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
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
        $status = $request->input('status');
        $search = $request->input('search');

        $borrows = Borrow::with(['book', 'member'])
            ->when($search, function ($query, $search) {
                if ($search) {
                    $query->whereHas('book', function ($query) use ($search) {
                        $query->where('isbn', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('member', function ($query) use ($search) {
                        $query->where('cnie', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%");
                    });
                }
            })
            ->when($status, function ($query, $status) {
                if ($status) {
                    $query->where('status', $status);
                }
            })
            ->get();

        return view('borrows.index', compact('borrows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::all();
        $books = Book::all();

        return view('borrows.create', compact('members', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BorrowRequest $request)
    {
        $validationData = $request->validated();

        $book = Book::findOrFail($request->book_id);

        if ($book->stock == 0) {
            return redirect()->back()->withErrors([
                'book_id' => 'This book is out of stock and cannot be borrowed.',
            ]);
        }
        
        $book->decrement('stock');

        Borrow::create($validationData);

        $telegramMessage = new TelegramMessage('Borrow', $book->title, 'Borrow', Auth::user()->full_name);
        $this->telegramService->sendMessage($telegramMessage);
        
        return redirect()->route('borrows.index')->with('success', 'Borrow has been created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $borrow = Borrow::findOrFail($id);
        $book = $borrow->book;

        if ($borrow->status != 'borrowed' && $request->status == 'borrowed') {
            if ($book->stock > 0) {
                $borrow->update(['status' => $request->status, 'returned_at' => null]);
                $book->decrement('stock');
            }
        } else if ($borrow->status == 'borrowed' && $request->status != 'borrowed') {
            $borrow->update(['status' => $request->status, 'returned_at' => date('Y-m-d')]);
            $book->increment('stock');
            
            $telegramMessage = new TelegramMessage('Borrow', $book->title, ucfirst($request->status), Auth::user()->full_name);
            $this->telegramService->sendMessage($telegramMessage);
        } else {
            $borrow->update(['status' => $request->status, 'returned_at' => date('Y-m-d')]);
            
            $telegramMessage = new TelegramMessage('Borrow', $book->title, ucfirst($request->status), Auth::user()->full_name);
            $this->telegramService->sendMessage($telegramMessage);
        }

        if ($request->isConfirmed) {            
            $request->validate([
                'description' => 'nullable|string|max:1000',
                'rating' => 'nullable|numeric|min:0|max:5',
            ]);

            Review::create([
                'description' => $request->description,
                'rating' => $request->rating,
                'book_id' => $borrow->book_id,
                'member_id' => $borrow->member_id
            ]);
        }

        return redirect()->route('borrows.index')->with('success', 'Borrow has been updated successfully.');
    }
}
