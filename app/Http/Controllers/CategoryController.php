<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }
    
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'favcolor' => 'required|regex:/^#[0-9A-Fa-f]{3,6}$/',
            'favcolor' => 'required|string'
        ]);

        $category->update(['color' => $request->favcolor]);

        return redirect()->route('categories.index')->with('Success', 'Category updated successfully.');
    }
}
