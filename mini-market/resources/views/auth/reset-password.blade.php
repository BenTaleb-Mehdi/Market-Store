@extends('layouts.main')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900">Reset Password</h2>
            <p class="text-gray-600 mt-2">Enter your new password</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="code" value="{{ $code }}">

            <!-- Password -->
            <div>
                <label for="password" class="block font-medium text-sm text-gray-700">New Password</label>
                <div class="relative">
                    <input id="password" 
                           class="block mt-1 w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                           type="password"
                           name="password"
                           required 
                           autocomplete="new-password" />
                    <button type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            onclick="togglePassword('password')">
                        <i id="password-eye" class="fa fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
                <div class="relative">
                    <input id="password_confirmation" 
                           class="block mt-1 w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('password_confirmation') border-red-500 @enderror"
                           type="password"
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password" />
                    <button type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            onclick="togglePassword('password_confirmation')">
                        <i id="password_confirmation-eye" class="fa fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('login') }}">
                    Back to Login
                </a>

                <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById(inputId + '-eye');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.className = 'fa fa-eye-slash text-gray-400 hover:text-gray-600 cursor-pointer';
    } else {
        passwordInput.type = 'password';
        eyeIcon.className = 'fa fa-eye text-gray-400 hover:text-gray-600 cursor-pointer';
    }
}
</script>
@endsection
