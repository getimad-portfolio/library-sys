<?php

namespace App\Http\Controllers;

use App\Classes\TelegramMessage;
use App\Models\Category;
use App\Services\TelegramNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private $telegramService;

    public function __construct(TelegramNotificationService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::when($search, function ($query, $search) {
                if ($search) {
                    $query->where('name', 'like', "%{$search}%");
                }
            })
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function create() {
        return view('categories.create');
    }

    public function store(Request $request) {
        $validationData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'favcolor' => 'required|regex:/^#[0-9A-Fa-f]{3,6}$/',
        ]);

        $category = Category::create([
            'name' => $validationData['name'],
            'description' => $validationData['description'],
            'color' => $validationData['favcolor'],
        ]);

        $telegramMessage = new TelegramMessage('Category', $category->name, 'Create', Auth::user()->full_name);
        $this->telegramService->sendMessage($telegramMessage);

        return redirect()->route('categories.index')->with('Success', 'Category created successfully.');
    }
    
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'favcolor' => 'required|regex:/^#[0-9A-Fa-f]{3,6}$/',
        ]);

        $category->update(['color' => $request->favcolor]);

        $telegramMessage = new TelegramMessage('Category', $category->name, 'Update', Auth::user()->full_name);
        $this->telegramService->sendMessage($telegramMessage);

        return redirect()->route('categories.index')->with('Success', 'Category updated successfully.');
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);
        $category->delete();

        $telegramMessage = new TelegramMessage('Category', $category->name, 'Delete', Auth::user()->full_name);
        $this->telegramService->sendMessage($telegramMessage);

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
