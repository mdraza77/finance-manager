@extends('layouts.main')
@section('title', 'FinancePRO | Edit Transaction')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">

        {{-- Page Header --}}
        <div class="mb-6 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Transaction</h1>
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
                                <span class="font-medium text-gray-700">Edit</span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if ($message = Session::get('success'))
            <div
                class="mb-6 flex items-center p-4 text-green-800 bg-green-50 rounded-lg border border-green-200 shadow-sm relative">
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

        @if ($errors->any())
            <div
                class="mb-6 flex items-center p-4 text-red-800 bg-red-50 rounded-lg border border-red-200 shadow-sm relative">
                <i class="fas fa-exclamation-circle text-lg mr-3"></i>
                <div>
                    <span class="font-bold">Error!</span> <span class="text-sm font-medium">Transaction Update Unsuccessful. Please
                        check the form below.</span>
                </div>
                <button type="button" class="ml-auto text-red-500 hover:text-red-700"
                    onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- Form Section --}}
        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Left Column: Transaction Details --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-100 p-4">
                            <h5 class="text-lg font-bold text-gray-800 flex items-center">
                                <i class="fas fa-wallet text-blue-600 mr-2"></i> Transaction Details
                            </h5>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- Transaction Type --}}
                                <div>
                                    <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Transaction Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="type" id="type" required onchange="updateCategories()"
                                        class="w-full px-4 py-2.5 bg-white border {{ $errors->has('type') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
                                        <option value="" disabled>Select Type</option>
                                        <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>Income</option>
                                        <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>Expense</option>
                                    </select>
                                    @error('type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Transaction Date --}}
                                <div>
                                    <label for="transaction_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="transaction_date" id="transaction_date"
                                        value="{{ old('transaction_date', $transaction->transaction_date) }}" required
                                        class="w-full px-4 py-2.5 bg-white border {{ $errors->has('transaction_date') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
                                    @error('transaction_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Amount --}}
                                <div>
                                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Amount ($) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" name="amount" id="amount" step="0.01" min="0.01"
                                            value="{{ old('amount', $transaction->amount) }}" required
                                            class="w-full pl-8 px-4 py-2.5 bg-white border {{ $errors->has('amount') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                            placeholder="0.00">
                                    </div>
                                    @error('amount')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Category --}}
                                <div>
                                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <select name="category" id="category" required
                                        class="w-full px-4 py-2.5 bg-white border {{ $errors->has('category') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm disabled:bg-gray-100 disabled:text-gray-400">
                                        <option value="" disabled selected>Select Category</option>
                                    </select>
                                    @error('category')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Description (Full Width) --}}
                                <div class="md:col-span-2">
                                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Description (Optional)
                                    </label>
                                    <textarea name="description" id="description" rows="3"
                                        class="w-full px-4 py-2.5 bg-white border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                        placeholder="Add notes about this transaction...">{{ old('description', $transaction->description) }}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Actions --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- Transaction Info Card --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-100 p-4">
                            <h5 class="text-lg font-bold text-gray-800 flex items-center">
                                <i class="fas fa-info-circle text-blue-600 mr-2"></i> Transaction Info
                            </h5>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Created By:</span>
                                <span class="font-semibold text-gray-700">{{ $transaction->user->name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Created:</span>
                                <span class="font-semibold text-gray-700">{{ $transaction->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Updated:</span>
                                <span class="font-semibold text-gray-700">{{ $transaction->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Card --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
                        <div class="flex flex-col space-y-3">
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm transition">
                                <i class="fas fa-save mr-2"></i> Update Transaction
                            </button>
                            <a href="{{ route('transactions.index') }}"
                                class="w-full inline-flex justify-center items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Records
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </main>

    {{-- Script for Dynamic Categories --}}
    <script>
        const categories = @json($categories);
        const oldCategory = "{{ old('category', $transaction->category) }}";

        function updateCategories() {
            const typeSelect = document.getElementById('type');
            const categorySelect = document.getElementById('category');
            const selectedType = typeSelect.value;

            categorySelect.innerHTML = '<option value="" disabled selected>Select Category</option>';

            if (selectedType && categories[selectedType]) {
                categorySelect.disabled = false;

                categories[selectedType].forEach(function(category) {
                    const option = document.createElement('option');
                    option.value = category;
                    option.text = category;

                    if (oldCategory === category) {
                        option.selected = true;
                    }

                    categorySelect.appendChild(option);
                });
            } else {
                categorySelect.disabled = true;
                categorySelect.innerHTML = '<option value="" disabled selected>Please select a type first</option>';
            }
        }

        window.onload = function() {
            updateCategories();
        };
    </script>

@endsection
