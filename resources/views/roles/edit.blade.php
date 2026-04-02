@extends('layouts.main')
@section('title', 'Role Update - Finance Admin')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">

        {{-- Page Header --}}
        <div class="mb-6 mt-20 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Update Role</h1>
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
                                <span class="font-medium text-gray-700">Edit</span>
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

        {{-- Main Form Section --}}
        <section class="section">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-8">

                    <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Role Permissions</h2>

                    {{-- Warning Note --}}
                    <div class="mb-8 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mr-3 text-lg"></i>
                            <p class="text-sm text-yellow-700">
                                <span class="font-bold">Note:</span> Give the <span
                                    class="underline font-semibold">Index</span> permission first, then Create, View, and
                                Edit.
                            </p>
                        </div>
                    </div>

                    {{-- Form Start --}}
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Role Name Input (Readonly) --}}
                        <div class="mb-8 max-w-xl">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Role Name <span class="text-red-500">*</span>
                            </label>
                            {{-- Readonly styling: gray background, disabled cursor, slightly muted text --}}
                            <input type="text" name="name" id="name" value="{{ $role->name }}" readonly
                                class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed shadow-sm focus:outline-none">
                            <p class="text-xs text-gray-400 mt-1.5"><i class="bi bi-info-circle mr-1"></i> Core role names
                                cannot be changed once created.</p>
                        </div>

                        {{-- Permissions Section --}}
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-4">
                                Update Permissions <span class="text-red-500">*</span>
                            </label>

                            {{-- Permissions Grid --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($permission as $value)
                                    <label
                                        class="flex items-start space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 cursor-pointer transition shadow-sm bg-white {{ in_array($value->id, $rolePermissions) ? 'border-blue-500 bg-blue-50/30' : '' }}">
                                        <div class="flex items-center h-5 mt-0.5">
                                            <input type="checkbox" name="permission[]" value="{{ $value->name }}"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-medium {{ in_array($value->id, $rolePermissions) ? 'text-blue-700' : 'text-gray-700' }}">
                                                {{ $value->name }}
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Form Action Buttons --}}
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('roles.index') }}"
                                class="inline-flex items-center px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                                Cancel
                            </a>
                            @can('AccessManagement-Edit')
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition">
                                    <i class="bi bi-check-lg mr-2"></i> Update Role
                                </button>
                            @endcan
                        </div>

                    </form>
                    {{-- Form End --}}

                </div>
            </div>
        </section>

    </main>
@endsection
