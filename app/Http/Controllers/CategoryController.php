<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'icon' => 'required|string',
            'type' => 'required|in:default,income,spent',
            //'user_id' => 'nullable|exists:users,id',
        ]);

        // Obtener el ID del usuario actualmente autenticado
        $userId = Auth::user()->id;

        // Crear la categoría con el user_id del usuario autenticado
        $category = new Category([
            'name' => $request->name,
            'icon' => $request->icon,
            'type' => $request->type,
            'user_id' => $userId,
        ]);

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string',
            'icon' => 'required|string',
            'type' => 'required|in:default,income,spent',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}