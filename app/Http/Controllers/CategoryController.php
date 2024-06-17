<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Obtener el ID del usuario autenticado
        $categories = Category::all();
        $categories = Category::where('user_id', $userId)
            ->orWhereNull('user_id')
            ->get();
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

        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
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
        $data = [
            'name' => $request->name,
            'icon' => $request->icon,
            'type' => $request->type,
            'user_id' => $userId,
        ];

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
