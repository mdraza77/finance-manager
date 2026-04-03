@extends('layouts.main')
@section('title', 'FinancePRO | My Account')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">

        {{-- Page Header --}}
        <div class="mb-6 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Profile Settings</h1>
                    <nav class="flex text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">Home</a></li>
                            <li class="flex items-center space-x-2">
                                <span class="text-gray-400">/</span>
                                <span class="font-medium text-gray-700">Profile</span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if ($message = Session::get('update'))
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

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="mb-4 flex items-start p-4 text-red-800 bg-red-50 rounded-lg border border-red-200 shadow-sm"
                role="alert" id="error-alert">
                <i class="fas fa-exclamation-circle text-lg mr-3 mt-0.5"></i>
                <div class="text-sm font-medium">
                    <span class="font-bold">Error!</span> Please fix the following issues:
                    <ul class="mt-2 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="ml-auto text-red-500 hover:text-red-700"
                    onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <script>
                setTimeout(function() {
                    let alert = document.getElementById('error-alert');
                    if (alert) {
                        alert.style.display = 'none';
                    }
                }, 10000);
            </script>
        @endif

        <section class="profile">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Profile Card --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-center">
                            <h2 class="text-xl font-bold text-white">Profile Information</h2>
                            <p class="text-blue-100 text-sm mt-1">Update your personal details</p>
                        </div>
                        <div class="p-6">
                            {{-- Profile Information Update (No Image Upload) --}}
                            <form action="{{ route('profile_update', $user->id) }}" method="POST" class="space-y-6">
                                @csrf

                                <div class="space-y-4">
                                    {{-- Full Name Field --}}
                                    <div>
                                        <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">
                                            Full Name
                                        </label>
                                        <input name="name" type="text"
                                            class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                            id="fullName" value="{{ $user->name }}" required>
                                    </div>

                                    {{-- Email Field --}}
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                            Email Address
                                        </label>
                                        <input name="email" type="email"
                                            class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                            id="email" value="{{ $user->email }}" required>
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-sm transition flex items-center justify-center mt-2">
                                    <i class="fas fa-save mr-2"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Password Change Card --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6">
                            <h2 class="text-xl font-bold text-white">Security Settings</h2>
                            <p class="text-purple-100 text-sm mt-1">Update your password to keep your account secure</p>
                        </div>
                        <div class="p-6">
                            {{-- Change Password Form --}}
                            <form action="{{ route('pass_update', $user->id) }}" method="POST" class="space-y-5">
                                @csrf
                                <div>
                                    <label for="currentPassword" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-lock mr-1 text-gray-400"></i> Current Password
                                    </label>
                                    <input name="old_password" type="password"
                                        class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                        id="currentPassword" placeholder="Enter your current password">
                                    @error('old_password')
                                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-key mr-1 text-gray-400"></i> New Password
                                    </label>
                                    <input name="password" type="password"
                                        class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                        id="newPassword" placeholder="Enter new password">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="renewPassword" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-key mr-1 text-gray-400"></i> Confirm New Password
                                    </label>
                                    <input name="password_confirmation" type="password"
                                        class="form-control w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                        id="renewPassword" placeholder="Re-enter new password">
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <button type="submit"
                                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 px-6 rounded-lg shadow-sm transition flex items-center">
                                        <i class="fas fa-shield-alt mr-2"></i> Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Account Info Card --}}
                    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-500 to-gray-600 p-6">
                            <h2 class="text-xl font-bold text-white">Account Information</h2>
                            <p class="text-gray-100 text-sm mt-1">Details about your account</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="bg-blue-100 p-2 rounded-full">
                                        <i class="fas fa-shield-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Designation / Role</p>
                                        <p class="text-sm font-semibold text-gray-800">
                                            @if (!empty($user->getRoleNames()))
                                                {{ $user->getRoleNames()->implode(', ') }}
                                            @else
                                                No Role Assigned
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="bg-green-100 p-2 rounded-full">
                                        <i class="fas fa-envelope text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Email Status</p>
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="bg-purple-100 p-2 rounded-full">
                                        <i class="fas fa-calendar-alt text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Member Since</p>
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="bg-orange-100 p-2 rounded-full">
                                        <i class="fas fa-clock text-orange-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Last Updated</p>
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $user->updated_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection
