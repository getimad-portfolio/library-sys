<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Member;
use App\Models\Book;

class BorrowController extends Controller
{
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
    public function store(Request $request)
    {
        $validationData = $request->validate([
            'member_id' => 'required|exists:members,id',        // Ensures the member exists in the members table
            'book_id' => 'required|exists:books,id',            // Ensures the book exists in the books table
            'borrowed_at' => 'required|date|before_or_equal:today', // Ensures it's a valid date not in the future
            'due_date' => 'required|date|after:borrow_date',    // Ensures it's a valid date and after the borrow_date
        ]);

        Borrow::create($validationData);

        return redirect()->route('borrows.index')->with('success', 'Borrow created successfully.');
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

        if ($request->status == 'returned') {
            $borrow->update(['status' => $request->status, 'returned_at' => date('Y-m-d')]);
        } else {
            $borrow->update(['status' => $request->status, 'returned_at' => null]);
        }

        return redirect()->route('borrows.index')->with('success', 'Borrow updated successfully.');
    }
}
