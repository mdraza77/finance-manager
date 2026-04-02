<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Permission middleware for dashboard access
    public static function middleware()
    {
        return [
            new Middleware('permission:Dashboard-View', ['index']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Get transactions based on user role
        if ($user->hasRole('Admin')) {
            $transactions = Transaction::with('user')->latest('transaction_date')->get();
        } else {
            $transactions = Transaction::where('user_id', $user->id)->latest('transaction_date')->get();
        }

        // Total Income
        $totalIncome = $transactions->where('type', 'income')->sum('amount');

        // Total Expenses
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');

        // Net Balance
        $netBalance = $totalIncome - $totalExpenses;

        // Category wise totals
        $categoryTotals = $transactions->groupBy('category')->map(function ($items) {
            return $items->sum('amount');
        })->sortDesc();

        // Recent activity (last 5 transactions)
        $recentActivity = $transactions->take(5);

        // Monthly trends (last 6 months)
        $monthlyTrends = collect();

        // Loop through the previous 5 months and the current month (Total 6 months)
        for ($i = 5; $i >= 0; $i--) {
            // Go back $i months from the current date
            $date = Carbon::now()->subMonths($i);

            // Get the first and last day of that specific month
            $monthStart = $date->copy()->startOfMonth()->toDateString();
            $monthEnd = $date->copy()->endOfMonth()->toDateString();

            // Calculate the total income for that month
            $income = Transaction::where('type', 'income')
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');

            // Calculate the total expense for that month
            $expense = Transaction::where('type', 'expense')
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');

            // Push the calculated data into the collection
            $monthlyTrends->push([
                'month' => $date->format('Y-m-01'), // Set the date to the 1st of that month
                'income' => $income,
                'expense' => $expense
            ]);
        }

        $Totalusers = User::count();

        return view('dashboard.index', compact(
            'Totalusers',
            'totalIncome',
            'totalExpenses',
            'netBalance',
            'categoryTotals',
            'recentActivity',
            'monthlyTrends'
        ));
    }
}
