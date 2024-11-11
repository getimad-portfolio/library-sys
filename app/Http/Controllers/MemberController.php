<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'asc');

        $members = DB::table('members')
            ->select()

            ->when($search, function ($query, $search) {
                if ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('members.full_name', 'like', "%{$search}%")
                            ->orWhere('members.email', 'like', "%{$search}%")
                            ->orWhere('members.cnie', 'like', "%{$search}%");
                    });
                }
            })

            ->orderBy('full_name', $sort)  // sorting by default "full name"

            ->get();

        
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $createdBy = Auth::user()->full_name;

        return view('members.create', compact('createdBy'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validationData = $request->validate([
            'full_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u', // Allows letters, spaces, and hyphens only
            'email' => 'required|string|email|max:255|unique:members,email', // Valid email format and unique in members table
            'adress' => 'required|string|max:1000', // Typo corrected: 'address'
            'cnie' => 'required|string|size:10|unique:members,cnie', // Exact size or specific length for CNIE and unique
            'phone_number' => 'required|string|regex:/^\+?[0-9]{10,15}$/', // Allows an optional "+" and 10-15 digits
        ]);
        
        $validationData['user_id'] = Auth::id();

        Member::create($validationData);

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = Member::findOrFail($id);
        $createdBy = Auth::user()->full_name;

        return view('members.edit', compact('member', 'createdBy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:255|unique:members,email,' . $member->id,
            'adress' => 'required|string|max:1000',
            'cnie' => 'required|string|size:10|unique:members,cnie,' . $member->id,
            'phone_number' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Book deleted successfully.');
    }
}
