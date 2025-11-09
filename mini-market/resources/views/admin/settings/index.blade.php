@extends('admin.layouts.app')

@section('title', 'Settings - Admin Dashboard')
@section('page-title', 'Settings')
@section('page-description', 'Manage your store settings and configuration')

@section('content')
<div class="space-y-6">
    <!-- Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        @foreach($settings as $group => $groupSettings)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Group Header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 capitalize">
                        {{ str_replace('_', ' ', $group) }} Settings
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @switch($group)
                            @case('general')
                                Basic information about your store
                                @break
                            @case('store')
                                Store operations and inventory settings
                                @break
                            @case('payment')
                                Payment methods and financial settings
                                @break
                            @case('notification')
                                Email and alert preferences
                                @break
                            @default
                                Configuration options for {{ $group }}
                        @endswitch
                    </p>
                </div>

                <!-- Group Settings -->
                <div class="p-6 space-y-6">
                    @foreach($groupSettings as $key => $setting)
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
                            <!-- Label and Description -->
                            <div class="lg:col-span-1">
                                <label for="{{ $key }}" class="block text-sm font-medium text-gray-700">
                                    {{ $setting['label'] }}
                                </label>
                                @if($setting['description'])
                                    <p class="text-sm text-gray-500 mt-1">{{ $setting['description'] }}</p>
                                @endif
                            </div>

                            <!-- Input Field -->
                            <div class="lg:col-span-2">
                                @switch($setting['type'])
                                    @case('boolean')
                                        <div class="flex items-center">
                                            <input type="hidden" name="settings[{{ $key }}]" value="0">
                                            <input type="checkbox" 
                                                   id="{{ $key }}" 
                                                   name="settings[{{ $key }}]" 
                                                   value="1"
                                                   {{ $setting['value'] ? 'checked' : '' }}
                                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                            <label for="{{ $key }}" class="ml-2 block text-sm text-gray-700">
                                                Enable this option
                                            </label>
                                        </div>
                                        @break

                                    @case('integer')
                                        <input type="number" 
                                               id="{{ $key }}" 
                                               name="settings[{{ $key }}]" 
                                               value="{{ $setting['value'] }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('settings.'.$key) border-red-500 @enderror">
                                        @break

                                    @case('float')
                                        <input type="number" 
                                               id="{{ $key }}" 
                                               name="settings[{{ $key }}]" 
                                               value="{{ $setting['value'] }}"
                                               step="0.01"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('settings.'.$key) border-red-500 @enderror">
                                        @break

                                    @case('string')
                                        @if($key === 'site_logo')
                                            <!-- Logo Upload -->
                                            <div class="space-y-4">
                                                @if($setting['value'])
                                                    <div class="flex items-center space-x-4">
                                                        <img src="{{ asset('storage/' . $setting['value']) }}" 
                                                             alt="Current Logo" 
                                                             class="h-16 w-16 object-contain rounded-lg border border-gray-300">
                                                        <div>
                                                            <p class="text-sm text-gray-600">Current Logo</p>
                                                            <p class="text-xs text-gray-500">Upload a new image to replace</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="flex items-center justify-center w-full">
                                                    <label for="logo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                            <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                            </svg>
                                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                            <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG (MAX. 2MB)</p>
                                                        </div>
                                                        <input id="logo" name="logo" type="file" class="hidden" accept="image/*" onchange="previewLogo(this)">
                                                    </label>
                                                </div>
                                                <div id="logo-preview" class="hidden">
                                                    <img id="logo-preview-img" src="" alt="Logo Preview" class="h-16 w-16 object-contain rounded-lg border border-gray-300">
                                                    <p class="text-sm text-gray-600 mt-2">New logo preview</p>
                                                </div>
                                            </div>
                                            @error('logo')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        @elseif(in_array($key, ['site_description', 'store_address', 'store_hours']))
                                            <textarea id="{{ $key }}" 
                                                      name="settings[{{ $key }}]" 
                                                      rows="3"
                                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('settings.'.$key) border-red-500 @enderror">{{ $setting['value'] }}</textarea>
                                        @else
                                            <input type="text" 
                                                   id="{{ $key }}" 
                                                   name="settings[{{ $key }}]" 
                                                   value="{{ $setting['value'] }}"
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('settings.'.$key) border-red-500 @enderror">
                                        @endif
                                        @break

                                    @default
                                        <input type="text" 
                                               id="{{ $key }}" 
                                               name="settings[{{ $key }}]" 
                                               value="{{ $setting['value'] }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('settings.'.$key) border-red-500 @enderror">
                                @endswitch

                                @error('settings.'.$key)
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        @if(!$loop->last)
                            <hr class="border-gray-200">
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Account Settings Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Account Settings
                </h3>
                <p class="text-sm text-gray-600 mt-1">
                    Update your admin account information
                </p>
            </div>

            <!-- Account Fields -->
            <div class="p-6 space-y-6">
                <!-- Email Address -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
                    <div class="lg:col-span-1">
                        <label for="admin_email" class="block text-sm font-medium text-gray-700">
                            Email Address
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Your admin account email address</p>
                    </div>
                    <div class="lg:col-span-2">
                        <input type="email" 
                               id="admin_email" 
                               name="admin_email" 
                               value="{{ Auth::user()->email }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('admin_email') border-red-500 @enderror"
                               placeholder="Enter your email address">
                        @error('admin_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Name -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
                    <div class="lg:col-span-1">
                        <label for="admin_name" class="block text-sm font-medium text-gray-700">
                            Full Name
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Your display name</p>
                    </div>
                    <div class="lg:col-span-2">
                        <input type="text" 
                               id="admin_name" 
                               name="admin_name" 
                               value="{{ Auth::user()->name }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('admin_name') border-red-500 @enderror"
                               placeholder="Enter your full name">
                        @error('admin_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="border-gray-200">
            </div>
        </div>

        <!-- Password Change Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Change Password
                </h3>
                <p class="text-sm text-gray-600 mt-1">
                    Update your admin account password
                </p>
            </div>

            <!-- Password Fields -->
            <div class="p-6 space-y-6">
                <!-- Current Password -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
                    <div class="lg:col-span-1">
                        <label for="current_password" class="block text-sm font-medium text-gray-700">
                            Current Password
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Enter your current password to confirm changes</p>
                    </div>
                    <div class="lg:col-span-2">
                        <div class="relative">
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('current_password') border-red-500 @enderror"
                                   placeholder="Enter current password">
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePassword('current_password')">
                                <i id="current_password-eye" class="fa fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- New Password -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
                    <div class="lg:col-span-1">
                        <label for="new_password" class="block text-sm font-medium text-gray-700">
                            New Password
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Must be at least 8 characters long</p>
                    </div>
                    <div class="lg:col-span-2">
                        <div class="relative">
                            <input type="password" 
                                   id="new_password" 
                                   name="new_password" 
                                   class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('new_password') border-red-500 @enderror"
                                   placeholder="Enter new password">
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePassword('new_password')">
                                <i id="new_password-eye" class="fa fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
                    <div class="lg:col-span-1">
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">
                            Confirm New Password
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Re-enter your new password</p>
                    </div>
                    <div class="lg:col-span-2">
                        <div class="relative">
                            <input type="password" 
                                   id="new_password_confirmation" 
                                   name="new_password_confirmation" 
                                   class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('new_password_confirmation') border-red-500 @enderror"
                                   placeholder="Confirm new password">
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePassword('new_password_confirmation')">
                                <i id="new_password_confirmation-eye" class="fa fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                            </button>
                        </div>
                        @error('new_password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end space-x-4">
            <button type="button" 
                    onclick="window.location.reload()" 
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium">
                Reset Changes
            </button>
            <button type="submit" 
                    class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition duration-200 font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Settings
            </button>
        </div>
    </form>

    <!-- Settings Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-medium text-blue-900">Settings Information</h4>
                <div class="mt-2 text-sm text-blue-800">
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>General Settings:</strong> Basic store information displayed to customers</li>
                        <li><strong>Store Settings:</strong> Operational settings like stock thresholds and features</li>
                        <li><strong>Payment Settings:</strong> Configure payment methods and financial options</li>
                        <li><strong>Notification Settings:</strong> Control email alerts and notifications</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Logo preview function
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const preview = document.getElementById('logo-preview');
        const previewImg = document.getElementById('logo-preview-img');
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto-save indication
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = document.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Saving...';
    
    // Re-enable after 3 seconds if form doesn't submit
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }, 3000);
});

// Password strength indicator
document.getElementById('new_password').addEventListener('input', function() {
    const password = this.value;
    const strengthIndicator = document.getElementById('password-strength');
    
    if (password.length === 0) {
        if (strengthIndicator) strengthIndicator.remove();
        return;
    }
    
    let strength = 0;
    let strengthText = '';
    let strengthColor = '';
    
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    switch (strength) {
        case 0:
        case 1:
            strengthText = 'Very Weak';
            strengthColor = 'text-red-600';
            break;
        case 2:
            strengthText = 'Weak';
            strengthColor = 'text-orange-600';
            break;
        case 3:
            strengthText = 'Fair';
            strengthColor = 'text-yellow-600';
            break;
        case 4:
            strengthText = 'Good';
            strengthColor = 'text-blue-600';
            break;
        case 5:
            strengthText = 'Strong';
            strengthColor = 'text-green-600';
            break;
    }
    
    let indicator = document.getElementById('password-strength');
    if (!indicator) {
        indicator = document.createElement('p');
        indicator.id = 'password-strength';
        indicator.className = 'mt-1 text-sm';
        this.parentNode.appendChild(indicator);
    }
    
    indicator.className = `mt-1 text-sm ${strengthColor}`;
    indicator.textContent = `Password strength: ${strengthText}`;
});

// Password visibility toggle
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
