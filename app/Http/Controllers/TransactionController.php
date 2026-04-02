<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TransactionController extends Controller implements HasMiddleware
{
    // Permissions middleware for transaction management
    public static function middleware()
    {
        return [
            new Middleware('permission:Transaction-Index', only: ['index']),
            new Middleware('permission:Transaction-Create', only: ['create', 'store']),
            new Middleware('permission:Transaction-Edit', only: ['edit', 'update']),
            new Middleware('permission:Transaction-View', only: ['show']),
            new Middleware('permission:Transaction-Delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('Admin')) {
            $transactions = Transaction::with('user')->latest('transaction_date')->get();
        } else {
            $transactions = Transaction::with('user')->where('user_id', Auth::id())->latest('transaction_date')->get();
        }

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Common categories for dropdown
        $categories = [
            'income' => ['Salary', 'Freelance', 'Business', 'Investment', 'Other'],
            'expense' => ['Rent', 'Food', 'Transport', 'Utilities', 'Entertainment', 'Healthcare', 'Other']
        ];

        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Security check: Only Admin or the owner can view this
        if (!Auth::user()->hasRole('Admin') && $transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Security check
        if (!Auth::user()->hasRole('Admin') && $transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = [
            'income' => ['Salary', 'Freelance', 'Business', 'Investment', 'Other'],
            'expense' => ['Rent', 'Food', 'Transport', 'Utilities', 'Entertainment', 'Healthcare', 'Other']
        ];

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Security check
        if (!Auth::user()->hasRole('Admin') && $transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Security check
        if (!Auth::user()->hasRole('Admin') && $transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
