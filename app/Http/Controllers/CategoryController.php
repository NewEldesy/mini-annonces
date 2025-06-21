<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Liste des catégories
    public function index()
    {
        $categories = Category::withCount('ads')->get();
        return view('categories.index', compact('categories'));
    }

    // Stockage d'une nouvelle catégorie (admin only)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories|max:255',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return back()->with('success', 'Catégorie créée!');
    }

    // Suppression d'une catégorie (admin only)
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Catégorie supprimée!');
    }
}