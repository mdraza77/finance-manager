@extends('layouts.main')
@section('title', 'Financial Records - Finance Admin')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">

        {{-- Alert Messages --}}
        @if ($message = Session::get('success'))
            <div
                class="mb-4 flex items-center p-4 text-green-800 bg-green-50 rounded-lg border border-green-200 shadow-sm relative">
                <i class="fas fa-check-circle text-lg mr-3"></i>
                <div>
                    <span class="font-bold">Success!</span> <span class="text-sm font-medium">{{ $message }}</span>
                </div>
                <button type="button" class="ml-auto text-green-500 hover:text-green-700"
                    onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if ($message = Session::get('update'))
            <div
                class="mb-4 flex items-center p-4 text-blue-800 bg-blue-50 rounded-lg border border-blue-200 shadow-sm relative">
                <i class="fas fa-check-circle text-lg mr-3"></i>
                <div>
                    <span class="font-bold">Updated!</span> <span class="text-sm font-medium">{{ $message }}</span>
                </div>
                <button type="button" class="ml-auto text-blue-500 hover:text-blue-700"
                    onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if ($message = Session::get('delete'))
            <div
                class="mb-4 flex items-center p-4 text-red-800 bg-red-50 rounded-lg border border-red-200 shadow-sm relative">
                <i class="fas fa-exclamation-circle text-lg mr-3"></i>
                <div>
                    <span class="font-bold">Deleted!</span> <span class="text-sm font-medium">{{ $message }}</span>
                </div>
                <button type="button" class="ml-auto text-red-500 hover:text-red-700"
                    onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- Page Header --}}
        <div class="mb-6 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Financial Records</h1>
                    <nav class="flex text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li><a href="{{ url('/dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a></li>
                            <li class="flex items-center space-x-2">
                                <span class="text-gray-400">/</span>
                                <span class="font-medium text-gray-700">Financial Records</span>
                            </li>
                        </ol>
                    </nav>
                </div>

                @can('Transaction-Create')
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('transactions.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                            <i class="fas fa-plus mr-2"></i> Add New Transaction
                        </a>
                    </div>
                @endcan
            </div>
        </div>

        {{-- Main Content Section --}}
        <section class="section">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">

                    {{-- DataTables Container --}}
                    <div class="overflow-x-auto">
                        <table id="transactions_table" class="w-full text-left text-sm text-gray-600 border-collapse">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-700">S. No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Type</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Category</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Amount</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Date</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">User</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($transactions as $key => $transaction)
                                    <tr class="hover:bg-gray-50 transition">

                                        <td class="px-4 py-4">{{ $loop->iteration }}</td>

                                        {{-- Type Badge --}}
                                        <td class="px-4 py-4">
                                            @if ($transaction->type === 'income')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full border border-green-200">
                                                    <i class="fas fa-arrow-up mr-1.5"></i>
                                                    Income
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full border border-red-200">
                                                    <i class="fas fa-arrow-down mr-1.5"></i>
                                                    Expense
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Category --}}
                                        <td class="px-4 py-4">
                                            <span
                                                class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-md border border-blue-200">
                                                {{ $transaction->category }}
                                            </span>
                                        </td>

                                        {{-- Amount --}}
                                        <td class="px-4 py-4 font-bold text-gray-800">
                                            ${{ number_format($transaction->amount, 2) }}
                                        </td>

                                        {{-- Date --}}
                                        <td class="px-4 py-4 font-medium text-gray-700">
                                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}
                                        </td>

                                        {{-- User --}}
                                        <td class="px-4 py-4">
                                            <div class="flex items-center justify-content-between gap-2">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($transaction->user->name) }}&background=dbeafe&color=1d4ed8&bold=true"
                                                    class="w-9 h-9 rounded-full border border-gray-200" alt="">
                                                <span
                                                    class="font-medium text-gray-700">{{ $transaction->user->name }}</span>
                                            </div>
                                        </td>

                                        {{-- Action Buttons --}}
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">

                                                @can('Transaction-View')
                                                    <a href="{{ route('transactions.show', $transaction->id) }}"
                                                        class="inline-flex items-center px-2.5 py-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-xs font-medium no-export"
                                                        title="View">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                @endcan

                                                @can('Transaction-Edit')
                                                    <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                        class="inline-flex items-center px-2.5 py-1.5 bg-green-50 text-green-600 rounded hover:bg-green-100 transition text-xs font-medium no-export"
                                                        title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                @endcan

                                                @can('Transaction-Delete')
                                                    <form method="POST"
                                                        action="{{ route('transactions.destroy', $transaction->id) }}"
                                                        class="inline-block no-export">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-2.5 py-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-xs font-medium"
                                                            onclick="return confirm('Are you sure you want to delete this transaction?')"
                                                            title="Delete">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
