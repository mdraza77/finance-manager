<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
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
        $monthlyTrends = Transaction::where('transaction_date', '>=', now()->subMonths(6))
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->transaction_date)->format('Y-m');
            })
            ->map(function ($group) {
                return [
                    'month' => $group->first()->transaction_date,
                    'income' => $group->where('type', 'income')->sum('amount'),
                    'expense' => $group->where('type', 'expense')->sum('amount'),
                ];
            })
            ->values();

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
