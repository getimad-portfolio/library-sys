<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

        $borrow->update(['status' => $request->status]);

        return redirect()->route('borrows.index')->with('success', 'Borrow updated successfully.');
    }
}
