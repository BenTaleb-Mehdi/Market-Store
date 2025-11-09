<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $siteName = App\Models\Setting::get('site_name', 'Mini Market');
        $siteDescription = App\Models\Setting::get('site_description', 'Fresh Products & Easy Reservations');
    @endphp
    <title>@yield('title', $siteName . ' - ' . $siteDescription)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
        
        /* Scroll Animations */
        .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        
        .scroll-animate.animate {
            opacity: 1;
            transform: translateY(0);
        }
        
        .scroll-animate-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease-out;
        }
        
        .scroll-animate-left.animate {
            opacity: 1;
            transform: translateX(0);
        }
        
        .scroll-animate-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s ease-out;
        }
        
        .scroll-animate-right.animate {
            opacity: 1;
            transform: translateX(0);
        }
        
        .scroll-animate-scale {
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.7s ease-out;
        }
        
        .scroll-animate-scale.animate {
            opacity: 1;
            transform: scale(1);
        }
        
        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
        .stagger-4 { transition-delay: 0.4s; }
        
        .pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }
        
        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Dropdown hover effect */
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white shadow-md border-b sticky top-0 z-50">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 lg:h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('products.index') }}" class="flex items-center space-x-2 sm:space-x-3">
                        @php
                            $siteLogo = App\Models\Setting::get('site_logo');
                            $siteName = App\Models\Setting::get('site_name', 'Mini Market');
                        @endphp
                        
                        @if($siteLogo)
                            <img src="{{ asset('storage/' . $siteLogo) }}" 
                                 alt="{{ $siteName }}" 
                                 class="h-8 sm:h-10 lg:h-12 w-auto object-contain">
                        @endif
                        
                        <span class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900">{{ $siteName }}</span>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center space-x-2">
                    @auth
                        <!-- Mobile Messages Icon -->
                        <a href="{{ route('messages.inbox') }}" class="relative text-gray-700 hover:text-primary-600 p-2 rounded-md transition duration-200" onclick="clearMessageCounter(this, event)">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            @php
                                $userMessages = App\Models\Message::where('user_id', Auth::id())
                                    ->orWhere('email', Auth::user()->email)
                                    ->where('status', 'replied')
                                    ->where('updated_at', '>', Auth::user()->last_message_check ?? '1970-01-01')
                                    ->count();
                            @endphp
                            @if($userMessages > 0)
                                <span class="message-counter absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $userMessages }}
                                </span>
                            @endif
                        </a>

                        <!-- Mobile Cart Icon -->
                        <a href="{{ route('cart.view') }}" class="relative text-gray-700 hover:text-primary-600 p-2 rounded-md transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                            </svg>
                            @php
                                $cartCount = session('cart') ? array_sum(session('cart')) : 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-primary-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endauth
                    
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-primary-600 p-2 rounded-md transition duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-primary-600 px-4 py-2 md:px-6 md:py-3 rounded-xl text-sm md:text-base font-medium transition duration-200 hover:shadow-md">
                        Home
                    </a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary-600 px-4 py-2 md:px-6 md:py-3 rounded-xl text-sm md:text-base font-medium transition duration-200 hover:shadow-md">
                        About
                    </a>
                    <a href="{{ route('products.list') }}" class="text-gray-700 hover:text-primary-600 px-4 py-2 md:px-6 md:py-3 rounded-xl text-sm md:text-base font-medium transition duration-200 hover:shadow-md">
                        Products
                    </a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary-600 px-4 py-2 md:px-6 md:py-3 rounded-xl text-sm md:text-base font-medium transition duration-200 hover:shadow-md">
                        Contact
                    </a>
                    
                    @auth
                        <!-- Desktop Messages Icon -->
                        <a href="{{ route('messages.inbox') }}" class="relative text-gray-700 hover:text-primary-600 p-3 rounded-md transition duration-200" onclick="clearMessageCounter(this, event)">
                            <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            @php
                                $userMessages = App\Models\Message::where('user_id', Auth::id())
                                    ->orWhere('email', Auth::user()->email)
                                    ->where('status', 'replied')
                                    ->where('updated_at', '>', Auth::user()->last_message_check ?? '1970-01-01')
                                    ->count();
                            @endphp
                            @if($userMessages > 0)
                                <span class="message-counter absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $userMessages }}
                                </span>
                            @endif
                        </a>

                        <!-- Desktop Cart Icon -->
                        <a href="{{ route('cart.view') }}" class="relative text-gray-700 hover:text-primary-600 p-3 rounded-md transition duration-200">
                            <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                            </svg>
                            @php
                                $cartCount = session('cart') ? array_sum(session('cart')) : 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-primary-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- User Dropdown -->
                        <div class="relative dropdown">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 px-4 py-3 rounded-md text-sm lg:text-base font-medium transition duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="hidden lg:block">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile
                                </a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    My Orders
                                </a>
                                <a href="{{ route('messages.inbox') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    My Messages
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        Admin Dashboard
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest Links -->
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600 px-4 py-2 md:px-6 md:py-3 rounded-xl text-sm md:text-base font-medium transition duration-200 hover:shadow-md">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-primary-600 text-white px-4 py-2 md:px-6 md:py-3 rounded-xl text-sm md:text-base font-medium hover:bg-primary-700 transition duration-200 shadow-md hover:shadow-lg">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200">
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="{{ route('products.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md transition duration-200">
                    Home
                </a>
                <a href="{{ route('about') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md transition duration-200">
                    About
                </a>
                <a href="{{ route('products.list') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md transition duration-200">
                    Products
                </a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md transition duration-200">
                    Contact
                </a>
                
                @auth
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md transition duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                        <a href="{{ route('orders.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md transition duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            My Orders
                        </a>
                        <a href="{{ route('messages.inbox') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md transition duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            My Messages
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md transition duration-200">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Admin Dashboard
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md transition duration-200">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-gray-200 pt-3 mt-3 space-y-2">
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md transition duration-200">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium bg-primary-600 text-white hover:bg-primary-700 rounded-md transition duration-200 text-center">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl shadow-md" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl shadow-md" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-auto">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    @php
                        $footerSiteName = App\Models\Setting::get('site_name', 'Mini Market');
                        $footerSiteDescription = App\Models\Setting::get('site_description', 'Your neighborhood mini market offering fresh, quality products with the convenience of online reservations.');
                    @endphp
                    <h3 class="text-2xl font-bold mb-4">{{ $footerSiteName }}</h3>
                    <p class="text-gray-300 mb-4 max-w-md">
                        {{ $footerSiteDescription }}
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition duration-200">About Us</a></li>
                        <li><a href="{{ route('products.list') }}" class="text-gray-300 hover:text-white transition duration-200">Products</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition duration-200">Contact</a></li>
                        @auth
                            <li><a href="{{ route('orders.index') }}" class="text-gray-300 hover:text-white transition duration-200">My Orders</a></li>
                        @endauth
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                    @php
                        $storeAddress = App\Models\Setting::get('store_address', '123 Market Street, City, State 12345');
                        $contactPhone = App\Models\Setting::get('contact_phone', '+1 (555) 123-4567');
                        $contactEmail = App\Models\Setting::get('contact_email', 'info@minimarket.com');
                    @endphp
                    <div class="space-y-2 text-gray-300">
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $storeAddress }}
                        </p>
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $contactPhone }}
                        </p>
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $contactEmail }}
                        </p>
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ App\Models\Setting::get('store_hours', 'Mon-Fri: 9AM-8PM, Sat-Sun: 10AM-6PM') }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Footer -->
            <div class="border-t border-gray-700 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-300 text-sm">
                    © {{ date('Y') }} {{ App\Models\Setting::get('site_name', 'Mini Market') }}. All rights reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-300 hover:text-white text-sm transition duration-200">Privacy Policy</a>
                    <a href="#" class="text-gray-300 hover:text-white text-sm transition duration-200">Terms of Service</a>
                    <a href="#" class="text-gray-300 hover:text-white text-sm transition duration-200">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll Animation JavaScript -->
    <script>
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, observerOptions);

        // Observe all elements with scroll animation classes
        document.addEventListener('DOMContentLoaded', () => {
            const animateElements = document.querySelectorAll('.scroll-animate, .scroll-animate-left, .scroll-animate-right, .scroll-animate-scale');
            animateElements.forEach(el => observer.observe(el));
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll progress indicator
        window.addEventListener('scroll', () => {
            const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            document.documentElement.style.setProperty('--scroll-progress', scrolled + '%');
        });

        // Auto-hide flash messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

    <!-- Add scroll progress bar -->
    <div class="fixed top-0 left-0 w-full h-1 bg-gray-200 z-50">
        <div class="h-full bg-primary-600 transition-all duration-300 ease-out" style="width: var(--scroll-progress, 0%)"></div>
    </div>

    <!-- Mobile Menu JavaScript -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
            
            // Close mobile menu when window is resized to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }

        // Clear message counter function
        function clearMessageCounter(element, event) {
            const counter = element.querySelector('.message-counter');
            if (counter) {
                // Prevent default navigation temporarily
                event.preventDefault();
                
                // Store in localStorage that messages have been checked
                localStorage.setItem('messagesCleared', Date.now().toString());
                
                // Animate counter removal
                counter.style.transition = 'opacity 0.3s, transform 0.3s';
                counter.style.opacity = '0';
                counter.style.transform = 'scale(0)';
                
                // Remove counter and then navigate
                setTimeout(() => {
                    counter.remove();
                    // Navigate to inbox after counter is cleared
                    window.location.href = element.href;
                }, 300);
                
                // Also send AJAX request to update server-side timestamp
                fetch('{{ route("messages.clear-notifications") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).catch(error => {
                    console.log('Failed to update server timestamp:', error);
                });
            } else {
                // No counter to clear, navigate immediately
                return true;
            }
        }

        // Hide message counters on page load if recently cleared
        document.addEventListener('DOMContentLoaded', function() {
            const clearedTime = localStorage.getItem('messagesCleared');
            if (clearedTime) {
                const timeDiff = Date.now() - parseInt(clearedTime);
                // Hide counters if cleared within last 5 minutes
                if (timeDiff < 300000) {
                    const counters = document.querySelectorAll('.message-counter');
                    counters.forEach(counter => {
                        counter.style.display = 'none';
                    });
                }
            }
        });
    </script>
</body>
</html>
