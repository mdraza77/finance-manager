@extends('layouts.main')
@section('title', 'Dashboard - Finance Admin')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">
        <div class="mb-6 mt-20 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Financial Dashboard</h1>
                    <nav class="flex text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li><a href="#" class="hover:text-blue-600">Home</a></li>
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Total Transactions</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">500</h3>
                        </div>
                        <div class="h-12 w-12 bg-blue-50 rounded-full flex items-center justify-center">
                            <i class="bi bi-cart-fill text-2xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border-l-4 border-green-500 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Net Balance</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">$12,400</h3>
                        </div>
                        <div class="h-12 w-12 bg-green-50 rounded-full flex items-center justify-center">
                            <i class="bi bi-currency-dollar text-2xl text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border-l-4 border-purple-500 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Active Categories</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">12</h3>
                        </div>
                        <div class="h-12 w-12 bg-purple-50 rounded-full flex items-center justify-center">
                            <i class="bi bi-tags-fill text-2xl text-purple-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border-l-4 border-orange-500 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">System Users</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $Totalusers ?? 0 }}</h3>
                        </div>
                        <div class="h-12 w-12 bg-orange-50 rounded-full flex items-center justify-center">
                            <i class="bi bi-people-fill text-2xl text-orange-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div class="bg-white rounded-xl shadow-sm border-l-4 border-yellow-500 p-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i> Quick Actions
                    </h5>
                    <div class="flex flex-wrap gap-3">
                        @can('transaction-create')
                            <a href="#"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm transition inline-flex items-center">
                                <i class="bi bi-plus-lg mr-2"></i> Add Transaction
                            </a>
                        @endcan

                        @can('transaction-index')
                            <a href="#"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                View All Records
                            </a>
                        @endcan

                        @can('view-analytics')
                            <a href="#"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                Financial Reports
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
