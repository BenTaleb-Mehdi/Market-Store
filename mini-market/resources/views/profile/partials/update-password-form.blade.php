<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Update Password
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-gray-700">Current Password</label>
            <div class="relative">
                <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" autocomplete="current-password" />
                <button type="button" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                        onclick="togglePassword('update_password_current_password')">
                    <i id="update_password_current_password-eye" class="fa fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                </button>
            </div>
            @if($errors->updatePassword->has('current_password'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block font-medium text-sm text-gray-700">New Password</label>
            <div class="relative">
                <input id="update_password_password" name="password" type="password" class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" autocomplete="new-password" />
                <button type="button" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                        onclick="togglePassword('update_password_password')">
                    <i id="update_password_password-eye" class="fa fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                </button>
            </div>
            @if($errors->updatePassword->has('password'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
            <div class="relative">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" autocomplete="new-password" />
                <button type="button" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                        onclick="togglePassword('update_password_password_confirmation')">
                    <i id="update_password_password_confirmation-eye" class="fa fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                </button>
            </div>
            @if($errors->updatePassword->has('password_confirmation'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Save
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600">Saved.</p>
            @endif
        </div>
    </form>
</section>

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
