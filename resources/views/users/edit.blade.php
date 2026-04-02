@extends('layouts.main')
@section('title', 'Update User - Finance Admin')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">

        {{-- Page Header --}}
        <div class="mb-6 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Update User</h1>
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
                                <span class="font-medium text-gray-700">Update</span>
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
                    <span class="font-bold">Error!</span> <span class="text-sm font-medium">User Update Unsuccessful. Please
                        check the form below.</span>
                </div>
                <button type="button" class="ml-auto text-red-500 hover:text-red-700"
                    onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- Form Section --}}
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Left Column: User Information --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-100 p-4">
                            <h5 class="text-lg font-bold text-gray-800 flex items-center">
                                <i class="fas fa-user text-blue-600 mr-2"></i> User Information
                            </h5>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- Full Name --}}
                                <div class="md:col-span-2">
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ $user->name }}" required
                                        class="w-full px-4 py-2.5 bg-white border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                        placeholder="Enter Full Name">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ $user->email }}" required
                                        class="w-full px-4 py-2.5 bg-white border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                        placeholder="Enter Email Address">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Mobile --}}
                                <div>
                                    <label for="mobile" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Mobile <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="mobile" id="mobile" value="{{ $user->mobile }}"
                                        required
                                        class="w-full px-4 py-2.5 bg-white border {{ $errors->has('mobile') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                        placeholder="Enter Mobile Number"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);">
                                    @error('mobile')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Password
                                    </label>
                                    <input type="password" name="password" id="password"
                                        class="w-full px-4 py-2.5 bg-white border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                        placeholder="Enter New Password">
                                    <p class="text-xs text-yellow-600 mt-1 font-medium">Leave blank to keep current
                                        password.</p>
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div>
                                    <label for="confirm-password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirm Password
                                    </label>
                                    <input type="password" name="confirm-password" id="confirm-password"
                                        class="w-full px-4 py-2.5 bg-white border {{ $errors->has('confirm-password') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                        placeholder="Confirm New Password">
                                    @error('confirm-password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
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
                                <i class="fas fa-user-shield text-blue-600 mr-2"></i> Role Assignment
                            </h5>
                        </div>
                        <div class="p-6">
                            <label for="role__" class="block text-sm font-semibold text-gray-700 mb-2">
                                Select Role <span class="text-red-500">*</span>
                            </label>

                            <select name="roles[]" id="role__" required
                                class="w-full px-4 py-2.5 bg-white border {{ $errors->has('roles') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
                                <option value="" disabled>Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ in_array($role->id, $userRoles) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('roles')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Actions Card --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
                        <div class="flex flex-col space-y-3">

                            {{-- Admin Protection Logic --}}
                            @if ($user->id != 1 && !$user->hasAnyRole(['Super Admin']))
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm transition">
                                    <i class="fas fa-save mr-2"></i> Update User
                                </button>
                            @else
                                <div
                                    class="p-3 bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm font-medium rounded-lg text-center">
                                    <i class="fas fa-lock mr-1"></i> Admin profiles cannot be updated from here.
                                </div>
                            @endif

                            <a href="{{ route('users.index') }}"
                                class="w-full inline-flex justify-center items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Users
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </main>

    {{-- Select2 Initialization --}}
    <script>
        $(document).ready(function() {
            $('#role__').select2({
                width: '100%',
                placeholder: "Select Role"
            });
        });
    </script>
@endsection
