<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-blue-600">Finance<span class="text-gray-800">PRO</span></h2>
        <p class="text-sm text-gray-500 mt-2 italic text-sm">Forgot your password? No problem, we'll help you reset it.</p>
    </div>

    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
            <p class="text-sm text-gray-700">
                {{ __('Enter your email address and we will send you a password reset link.') }}
            </p>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400 text-sm"></i>
                </div>
                <x-text-input id="email"
                    class="block w-full pl-1 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    placeholder="admin@financepro.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                <i class="fas fa-paper-plane mr-2 mt-0.5"></i> {{ __('Send Password Reset Link') }}
            </button>
        </div>

        {{-- Login Link --}}
        <p class="text-center text-sm text-gray-600 mt-6">
            Remember your password?
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition">
                Back to Login
            </a>
        </p>
    </form>
</x-guest-layout>
