@extends('layouts.main')
@section('title', 'User Details - Finance Admin')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">

        {{-- Page Header --}}
        <div class="mb-6 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">User Details</h1>
                    <nav class="flex text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a></li>
                            <li class="flex items-center space-x-2">
                                <span class="text-gray-400">/</span>
                                <a href="{{ route('users.index') }}" class="hover:text-blue-600 transition">User
                                    Management</a>
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

            {{-- Left Column: User Information --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
                    <div class="bg-gray-50 border-b border-gray-100 p-4">
                        <h5 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-user text-blue-600 mr-2"></i> Personal Information
                        </h5>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Full Name --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Full
                                    Name</label>
                                <div
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-800 font-medium">
                                    {{ $user->name ?? 'N/A' }}
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Email
                                    Address</label>
                                <div
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-800 font-medium flex items-center">
                                    <i class="bi bi-envelope text-gray-400 mr-2"></i> {{ $user->email ?? 'N/A' }}
                                </div>
                            </div>

                            {{-- Mobile --}}
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Mobile
                                    Number</label>
                                <div
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-800 font-medium flex items-center">
                                    <i class="bi bi-phone text-gray-400 mr-2"></i> {{ $user->mobile ?? 'N/A' }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Role Information & Actions --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Role Assignment Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-100 p-4">
                        <h5 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-user-shield text-blue-600 mr-2"></i> Assigned Roles
                        </h5>
                    </div>
                    <div class="p-6">
                        @if (!empty($user->getRoleNames()) && count($user->getRoleNames()) > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($user->getRoleNames() as $v)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 border border-green-200 rounded-md text-sm font-semibold shadow-sm">
                                        <i class="bi bi-check2-circle mr-1.5 text-green-500"></i> {{ $v }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="p-3 bg-gray-50 border border-gray-200 text-gray-500 text-sm italic rounded-lg">
                                No roles currently assigned.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Actions Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
                    <div class="flex flex-col space-y-3">
                        <a href="{{ route('users.index') }}"
                            class="w-full inline-flex justify-center items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Users
                        </a>

                        {{-- Optional: Quick link to Edit if they have permission --}}
                        @can('UserManagement-Edit')
                            @if ($user->id != 1 && !$user->hasAnyRole(['Super Admin']))
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-lg transition border border-blue-200">
                                    <i class="fas fa-pencil mr-2"></i> Edit this User
                                </a>
                            @endif
                        @endcan
                    </div>
                </div>

            </div>
        </div>

    </main>
@endsection
