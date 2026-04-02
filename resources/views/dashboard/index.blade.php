@extends('layouts.main')
@section('title', 'Dashboard - Finance Admin')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">

        {{-- Page Header --}}
        <div class="mb-6 mt-20 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Financial Dashboard</h1>
                    <nav class="flex text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">Home</a></li>
                            <li class="flex items-center space-x-2">
                                <span class="text-gray-400">/</span>
                                <span class="font-medium text-gray-700">Dashboard</span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 flex items-center p-4 text-green-800 bg-green-50 rounded-lg border border-green-200 shadow-sm"
                role="alert">
                <i class="fas fa-check-circle text-lg mr-3"></i>
                <div class="text-sm font-medium">
                    <span class="font-bold">Success!</span> {{ $message }}
                </div>
                <button type="button" class="ml-auto text-green-500 hover:text-green-700"
                    onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <section class="dashboard">

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                {{-- Total Income --}}
                <div class="bg-white rounded-xl shadow-sm border-l-4 border-green-500 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Total Income</p>
                            <h3 class="text-2xl font-bold text-green-600 mt-1">${{ number_format($totalIncome, 2) }}</h3>
                        </div>
                        <div class="h-12 w-12 bg-green-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-arrow-up text-2xl text-green-600"></i>
                        </div>
                    </div>
                </div>

                {{-- Total Expenses --}}
                <div class="bg-white rounded-xl shadow-sm border-l-4 border-red-500 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Total Expenses</p>
                            <h3 class="text-2xl font-bold text-red-600 mt-1">${{ number_format($totalExpenses, 2) }}</h3>
                        </div>
                        <div class="h-12 w-12 bg-red-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-arrow-down text-2xl text-red-600"></i>
                        </div>
                    </div>
                </div>

                {{-- Net Balance --}}
                <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Net Balance</p>
                            <h3
                                class="text-2xl font-bold @if ($netBalance >= 0) text-blue-600 @else text-red-600 @endif mt-1">
                                ${{ number_format($netBalance, 2) }}
                            </h3>
                        </div>
                        <div class="h-12 w-12 bg-blue-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-wallet text-2xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                {{-- System Users --}}
                <a href="{{ route('users.index') }}">
                    <div class="bg-white rounded-xl shadow-sm border-l-4 border-orange-500 p-6 hover:shadow-md transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-500 uppercase">System Users</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $Totalusers ?? 0 }}</h3>
                            </div>
                            <div class="h-12 w-12 bg-orange-50 rounded-full flex items-center justify-center">
                                <i class="fas fa-users text-2xl text-orange-600"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Charts and Tables Row --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                {{-- Monthly Trends Chart --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-100 p-4">
                        <h5 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-chart-line text-blue-600 mr-2"></i> Monthly Trends (Last 6 Months)
                        </h5>
                    </div>
                    <div class="p-4">
                        <canvas id="monthlyTrendsChart" height="200"></canvas>
                    </div>
                </div>

                {{-- Category Wise Totals --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-100 p-4">
                        <h5 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-chart-pie text-purple-600 mr-2"></i> Category Wise Totals
                        </h5>
                    </div>
                    <div class="p-4">
                        @if ($categoryTotals->count() > 0)
                            <div class="space-y-3">
                                @foreach ($categoryTotals->take(8) as $category => $amount)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                            <span class="text-sm font-medium text-gray-700">{{ $category }}</span>
                                        </div>
                                        <span
                                            class="text-sm font-bold text-gray-800">${{ number_format($amount, 2) }}</span>
                                    </div>
                                @endforeach
                                @if ($categoryTotals->count() > 8)
                                    <p class="text-xs text-gray-500 text-center mt-2">+ {{ $categoryTotals->count() - 8 }}
                                        more categories</p>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 text-sm text-center py-4">No transactions recorded yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gray-50 border-b border-gray-100 p-4">
                    <h5 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class="fas fa-history text-green-600 mr-2"></i> Recent Activity
                    </h5>
                </div>
                <div class="p-0">
                    @if ($recentActivity->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Date</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Type</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Category</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Description</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700 text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($recentActivity as $transaction)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3 font-medium text-gray-700">
                                                {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($transaction->type === 'income')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full border border-green-200">
                                                        <i class="fas fa-arrow-up mr-1"></i> Income
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full border border-red-200">
                                                        <i class="fas fa-arrow-down mr-1"></i> Expense
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-md border border-blue-200">
                                                    {{ $transaction->category }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600">
                                                {{ Str::limit($transaction->description, 30) ?? '-' }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-right font-bold @if ($transaction->type === 'income') text-green-600 @else text-red-600 @endif">
                                                ${{ number_format($transaction->amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm text-center py-8">No recent transactions found.</p>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl shadow-sm border-l-4 border-yellow-500 p-6">
                <h5 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i> Quick Actions
                </h5>
                <div class="flex flex-wrap gap-3">
                    @can('Transaction-Create')
                        <a href="{{ route('transactions.create') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm transition inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Add Transaction
                        </a>
                    @endcan

                    @can('Transaction-Index')
                        <a href="{{ route('transactions.index') }}"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            View All Records
                        </a>
                    @endcan
                </div>
            </div>

        </section>
    </main>

    {{-- Chart.js for Monthly Trends --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('monthlyTrendsChart').getContext('2d');

            const monthlyData = @json($monthlyTrends);

            const labels = monthlyData.map(item => {
                const date = new Date(item.month);
                return date.toLocaleString('default', {
                    month: 'short',
                    year: 'numeric'
                });
            });

            const incomeData = monthlyData.map(item => parseFloat(item.income));
            const expenseData = monthlyData.map(item => parseFloat(item.expense));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Income',
                            data: incomeData,
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Expenses',
                            data: expenseData,
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': $' + context.parsed.y
                                        .toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
