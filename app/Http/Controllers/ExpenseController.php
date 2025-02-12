<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = auth()->user()->expenses()
            ->orderBy('expense_date', 'desc')
            ->paginate(15);
            
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'expense_date' => 'required|date',
            'payment_method' => 'nullable|string',
            'receipt_url' => 'nullable|url',
            'notes' => 'nullable|string'
        ]);

        auth()->user()->expenses()->create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense)
    {
        
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    { 
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);
        
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'expense_date' => 'required|date',
            'payment_method' => 'nullable|string',
            'receipt_url' => 'nullable|url',
            'notes' => 'nullable|string'
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }

    public function byCategory($category)
    {
        $expenses = auth()->user()->expenses()
            ->where('category', $category)
            ->orderBy('expense_date', 'desc')
            ->paginate(15);

        return view('expenses.index', compact('expenses'));
    }

    public function monthlyReport()
    {
        $expenses = auth()->user()->expenses()
            ->selectRaw('YEAR(expense_date) as year, MONTH(expense_date) as month, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('expenses.monthly-report', compact('expenses'));
    }
}
