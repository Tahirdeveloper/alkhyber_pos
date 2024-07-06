<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $expenses = Expense::all(); // Fetch all expenses from the database
        return view('expenses.index', compact('expenses','user'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'expenseFor' => 'required',
            'paymentType' => 'required',
            'amount' => 'required|numeric',
            'paymentNote' => 'nullable|string',
            'expenseDate' => 'required|date',
        ]);
        $validatedData['user_id'] = Auth::user()->id;
        Expense::create($validatedData);

        return redirect()->route('expense.index')->with('success', 'Expense added successfully.');
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id); // Find the expense by ID
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'expenseFor' => 'required',
            'paymentType' => 'required',
            'amount' => 'required|numeric',
            'purchaseNote' => 'nullable|string',
            'expenseDate' => 'required|date',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->update($validatedData);

        return redirect()->route('expense.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Expense deleted successfully.');
    }
}
