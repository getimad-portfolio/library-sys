<?php

namespace App\Http\Controllers;

use App\Classes\TelegramMessage;
use App\Http\Requests\MemberRequest;
use App\Models\Borrow;
use App\Models\Member;
use App\Services\TelegramNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
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
        $sort = $request->input('sort', 'asc');

        $members = Member::when($search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('members.full_name', 'like', "%{$search}%")
                    ->orWhere('members.email', 'like', "%{$search}%")
                    ->orWhere('members.cnie', 'like', "%{$search}%");
                });
            })

            ->orderBy('full_name', $sort)

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
    public function store(MemberRequest $request)
    {
        $validationData = $request->validated();

        $member = Auth::user()->members()->create($validationData);
        
        $telegramMessage = new TelegramMessage('Member', $member->full_name, 'Create', Auth::user()->full_name);
        $this->telegramService->sendMessage($telegramMessage);

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::with('user')->findOrFail($id);
        $borrows = Borrow::where('member_id', '=', $id)->get();

        return view('members.show', compact('member',  'borrows'));
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
    public function update(MemberRequest $request, string $id)
    {
        $validationData = $request->validated();
        
        $member = Member::findOrFail($id);
        
        $member->update($validationData);

        $telegramMessage = new TelegramMessage('Member', $member->full_name, 'Update', Auth::user()->full_name);
        $this->telegramService->sendMessage($telegramMessage);

        return redirect()->route('members.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        $telegramMessage = new TelegramMessage('Member', $member->full_name, 'Delete', Auth::user()->full_name);
        $this->telegramService->sendMessage($telegramMessage);

        return redirect()->route('members.index')->with('success', 'Book deleted successfully.');
    }
}
