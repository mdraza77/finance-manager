@extends('layouts.main')
@section('title', 'Transaction Details - Finance Admin')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">

        {{-- Page Header --}}
        <div class="mb-6 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Transaction Details</h1>
                    <nav class="flex text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a></li>
                            <li class="flex items-center space-x-2">
                                <span class="text-gray-400">/</span>
                                <a href="{{ route('transactions.index') }}" class="hover:text-blue-600 transition">Financial
                                    Records</a>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-gray-400">/</span>
                                <span class="font-medium text-gray-700">Details</span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        {{-- Details Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column: Transaction Information --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
                    <div class="bg-gray-50 border-b border-gray-100 p-4">
                        <h5 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-wallet text-blue-600 mr-2"></i> Transaction Information
                        </h5>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Transaction Type --}}
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Type</label>
                                <div
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-800 font-medium">
                                    @if ($transaction->type === 'income')
                                        <span
                                            class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full border border-green-200">
                                            <i class="fas fa-arrow-up mr-1.5"></i> Income
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-sm font-semibold rounded-full border border-red-200">
                                            <i class="fas fa-arrow-down mr-1.5"></i> Expense
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Category --}}
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                                <div
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-800 font-medium">
                                    <span
                                        class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 text-sm font-semibold rounded-md border border-blue-200">
                                        {{ $transaction->category }}
                                    </span>
                                </div>
                            </div>

                            {{-- Amount --}}
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Amount</label>
                                <div
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-800 font-bold text-lg flex items-center">
                                    <i class="fas fa-dollar-sign text-gray-400 mr-1"></i>
                                    ${{ number_format($transaction->amount, 2) }}
                                </div>
                            </div>

                            {{-- Transaction Date --}}
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Transaction
                                    Date</label>
                                <div
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-800 font-medium flex items-center">
                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                    {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('F d, Y') }}
                                </div>
                            </div>

                            {{-- Description (Full Width) --}}
                            @if ($transaction->description)
                                <div class="md:col-span-2">
                                    <label
                                        class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Description</label>
                                    <div
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-800 font-medium">
                                        {{ $transaction->description }}
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Meta Information & Actions --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- User Information Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-100 p-4">
                        <h5 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-user text-blue-600 mr-2"></i> Created By
                        </h5>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($transaction->user->name) }}&background=dbeafe&color=1d4ed8&bold=true"
                                class="w-9 h-9 rounded-full border border-blue-200 shadow-sm" alt="Avatar">
                            <div class="ml-3">
                                <p class="font-semibold text-gray-800">{{ $transaction->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $transaction->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timestamps Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-100 p-4">
                        <h5 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-clock text-blue-600 mr-2"></i> Timestamps
                        </h5>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Created:</span>
                            <span
                                class="font-semibold text-gray-700">{{ $transaction->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Updated:</span>
                            <span
                                class="font-semibold text-gray-700">{{ $transaction->updated_at->format('M d, Y h:i A') }}</span>
                        </div>
                        @if ($transaction->deleted_at)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Deleted:</span>
                                <span
                                    class="font-semibold text-red-600">{{ $transaction->deleted_at->format('M d, Y h:i A') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Actions Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
                    <div class="flex flex-col space-y-3">
                        <a href="{{ route('transactions.index') }}"
                            class="w-full inline-flex justify-center items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Records
                        </a>

                        @can('Transaction-Edit')
                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-lg transition border border-blue-200">
                                <i class="fas fa-pencil mr-2"></i> Edit this Transaction
                            </a>
                        @endcan

                        @can('Transaction-Delete')
                            <form method="POST" action="{{ route('transactions.destroy', $transaction->id) }}"
                                onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-6 py-3 bg-red-50 hover:bg-red-100 text-red-700 font-bold rounded-lg transition border border-red-200">
                                    <i class="fas fa-trash mr-2"></i> Delete this Transaction
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

            </div>
        </div>

    </main>
@endsection
