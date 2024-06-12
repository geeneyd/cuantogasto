<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::with('user', 'category')->orderBy('created_at', 'desc')->get();

        // Obtener las categorías según los criterios especificados
        $categoryIncome = Category::where('type', 'income')->whereNull('user_id')->get();

        $categorySpent = Category::where('type', 'spent')->whereNull('user_id')->get();

        $categoryIncomeUser = Category::where('type', 'income')->where('user_id', auth()->id())->get();

        $categorySpentUser = Category::where('type', 'spent')->where('user_id', auth()->id())->get();

        // Combinar los resultados en una sola colección
        $userCategories = $categoryIncome->concat($categorySpent)->concat($categoryIncomeUser)->concat($categorySpentUser);
        // Pasar las transacciones y las categorías del usuario a la vista
        return view('transactions.index', compact('transactions', 'userCategories'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
        ]);

        // Determinar el prefijo de los nombres de los campos
        $prefix = $request->type === 'income' ? 'income_' : 'expense_';

        if ($request->type === 'income') {
            $request->validate([
                'income_description' => 'required|string', 
                'income_amount' => 'required|numeric',     
                'type' => 'required|in:income,expense',
                'income_category_id' => 'required|exists:categories,id', 
            ]);            
        } else {
            $request->validate([
                'expense_description' => 'required|string', 
                'expense_amount' => 'required|numeric',     
                'type' => 'required|in:income,expense',
                'expense_category_id' => 'required|exists:categories,id',
            ]);            
        }

        // Asignar el user_id del usuario autenticado
        $request->merge(['user_id' => auth()->id()]);

        // Crear un arreglo de datos con los nombres de los campos ajustados
        $data = [
            'description' => $request->input($prefix . 'description'),
            'amount' => $request->input($prefix . 'amount'),
            'type' => $request->type,
            'category_id' => $request->input($prefix . 'category_id'),
            'user_id' => $request->user_id,
        ];

        Transaction::create($data);

        return redirect()->route('transactions.index')->with('success', __('Transaction created successfully.'));
    }


    public function edit(Transaction $transaction)
    {
        // Obtener las categorías según los criterios especificados
        $categoryIncome = Category::where('type', 'income')->whereNull('user_id')->get();

        $categorySpent = Category::where('type', 'spent')->whereNull('user_id')->get();

        $categoryIncomeUser = Category::where('type', 'income')->where('user_id', auth()->id())->get();

        $categorySpentUser = Category::where('type', 'spent')->where('user_id', auth()->id())->get();
        
        // Combinar los resultados en una sola colección
        $userCategories = $categoryIncome->concat($categorySpent)->concat($categoryIncomeUser)->concat($categorySpentUser);
        
        return view('transactions.edit', compact('transaction', 'userCategories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
        ]);

        // Determinar el prefijo de los nombres de los campos
        $prefix = $request->type === 'income' ? 'income_' : 'expense_';

        if ($request->type === 'income') {
            $request->validate([
                'income_description' => 'required|string', 
                'income_amount' => 'required|numeric',     
                'type' => 'required|in:income,expense',
                'income_category_id' => 'required|exists:categories,id', 
            ]);            
        } else {
            $request->validate([
                'expense_description' => 'required|string', 
                'expense_amount' => 'required|numeric',     
                'type' => 'required|in:income,expense',
                'expense_category_id' => 'required|exists:categories,id',
            ]);            
        }

        // Asignar el user_id del usuario autenticado
        $request->merge(['user_id' => auth()->id()]);

        // Crear un arreglo de datos con los nombres de los campos ajustados
        $data = [
            'description' => $request->input($prefix . 'description'),
            'amount' => $request->input($prefix . 'amount'),
            'type' => $request->type,
            'category_id' => $request->input($prefix . 'category_id'),
            'user_id' => $request->user_id,
        ];

        $transaction->update($data);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transacción actualizada exitosamente.');
    }

}
