@extends('layouts.main')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900">Enter Reset Code</h2>
            <p class="text-gray-600 mt-2">We've sent a 6-digit code to {{ $email }}</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.verify-code') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <!-- Reset Code -->
            <div>
                <label for="code" class="block font-medium text-sm text-gray-700">Reset Code</label>
                <input id="code" 
                       class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('code') border-red-500 @enderror text-center text-2xl tracking-widest" 
                       type="text" 
                       name="code" 
                       value="{{ old('code') }}" 
                       required 
                       autofocus 
                       maxlength="6"
                       placeholder="000000" />
                @error('code')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Enter the 6-digit code sent to your email</p>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                    Request New Code
                </a>

                <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Verify Code
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-format code input
document.getElementById('code').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
    if (value.length > 6) {
        value = value.substring(0, 6);
    }
    e.target.value = value;
});

// Auto-submit when 6 digits are entered
document.getElementById('code').addEventListener('input', function(e) {
    if (e.target.value.length === 6) {
        setTimeout(() => {
            e.target.form.submit();
        }, 500);
    }
});
</script>
@endsection
