<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
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

        Category::create([
            'name' => $validationData['name'],
            'description' => $validationData['description'],
            'color' => $validationData['favcolor'],
        ]);

        return redirect()->route('categories.index')->with('Success', 'Category created successfully.');
    }
    
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'favcolor' => 'required|regex:/^#[0-9A-Fa-f]{3,6}$/',
        ]);

        $category->update(['color' => $request->favcolor]);

        return redirect()->route('categories.index')->with('Success', 'Category updated successfully.');
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
