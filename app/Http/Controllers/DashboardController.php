<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Obtener el ID del usuario autenticado

        // Obtener el mes y año actual
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Suma total de ingresos del usuario en el mes en curso
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('amount');

        // Suma total de gastos del usuario en el mes en curso
        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('amount');

        $restaTotales = $totalIncome-$totalExpense;

        // Top 5 categorías con más ingresos
        $topIncomeCategories = Transaction::select('category_id', DB::raw('SUM(amount) as total'))
            ->where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->with('category')
            ->get();

        // Top 5 categorías con más gastos
        $topExpenseCategories = Transaction::select('category_id', DB::raw('SUM(amount) as total'))
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->with('category')
            ->get();

        // Pasar los datos a la vista
        return view('dashboard', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'restaTotales' => $restaTotales,
            'topIncomeCategories' => $topIncomeCategories,
            'topExpenseCategories' => $topExpenseCategories,
        ]);
    }
}
