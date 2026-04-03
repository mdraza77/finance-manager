@extends('layouts.main')
@section('title', 'FinancePRO | Role View')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">

        {{-- Page Header --}}
        <div class="mb-6 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Role Details</h1>
                    <nav class="flex text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a></li>
                            <li class="flex items-center space-x-2">
                                <span class="text-gray-400">/</span>
                                <a href="{{ route('roles.index') }}" class="hover:text-blue-600 transition">Role
                                    Management</a>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-gray-400">/</span>
                                <span class="font-medium text-gray-700">View</span>
                            </li>
                        </ol>
                    </nav>
                </div>

                {{-- Back Button --}}
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('roles.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                        <i class="bi bi-arrow-left mr-2"></i> Back to Roles
                    </a>
                </div>
            </div>
        </div>

        {{-- Main Content Section --}}
        <section class="section">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-8">

                    <h2 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Role Information</h2>

                    <div class="space-y-8 max-w-4xl">

                        {{-- Role Name Display --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Role Name</h3>
                            <div class="inline-flex items-center px-5 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                                <i class="bi bi-shield-lock text-blue-600 text-xl mr-3"></i>
                                <span class="text-lg font-bold text-gray-900">{{ $role->name }}</span>
                            </div>
                        </div>

                        {{-- Permissions Display --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Assigned
                                Permissions</h3>

                            @if (count($rolePermissions) > 0)
                                <div class="flex flex-wrap gap-2.5">
                                    @foreach ($rolePermissions as $value)
                                        {{-- Professional Badge Style for Permissions --}}
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100 shadow-sm">
                                            <i class="bi bi-check2-circle mr-1.5 text-blue-500"></i>
                                            {{ $value->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                {{-- Empty State if no permissions --}}
                                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-500 italic text-sm">
                                    No permissions have been assigned to this role yet.
                                </div>
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
