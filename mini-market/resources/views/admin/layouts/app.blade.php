<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Mini Market')</title>
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
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Mobile menu overlay -->
        <div id="mobile-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 lg:hidden hidden"></div>
        
        <!-- Sidebar -->
        <div id="admin-sidebar" class="bg-white shadow-lg w-64 xl:w-72 min-h-screen fixed left-0 top-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Logo -->
            <div class="p-6 xl:p-8 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="bg-primary-600 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl xl:text-2xl font-bold text-gray-900">Mini Market</h1>
                        <p class="text-sm xl:text-base text-gray-600">Admin Dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6">
                <div class="px-6 mb-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Main Menu</p>
                </div>
                
                <div class="space-y-1 px-3">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Products -->
                    <a href="{{ route('admin.products.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Products
                    </a>

                    <!-- Orders -->
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Orders
                    </a>

                    <!-- Messages -->
                    <a href="{{ route('admin.messages.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition duration-200 {{ request()->routeIs('admin.messages.*') ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Messages
                    </a>

                    <!-- Contact Messages -->
                    <a href="{{ route('admin.contact-messages.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition duration-200 {{ request()->routeIs('admin.contact-messages.*') ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Contact Messages
                        @php
                            $unreadCount = App\Models\ContactMessage::unread()->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="ml-auto bg-orange-500 text-white text-xs rounded-full px-2 py-1">{{ $unreadCount }}</span>
                        @endif
                    </a>


                    <!-- Settings -->
                    <a href="{{ route('admin.settings') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition duration-200 {{ request()->routeIs('admin.settings*') ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>
                </div>

                <div class="px-6 mt-8 mb-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Website</p>
                </div>
                
                <div class="space-y-1 px-3">
                    <!-- View Website -->
                    <a href="{{ route('products.index') }}" target="_blank" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Website
                        <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-200 bg-white">
                <div class="flex items-center">
                    <div class="bg-primary-600 w-10 h-10 rounded-full flex items-center justify-center mr-3">
                        <span class="text-white font-medium text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-600 transition duration-200" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64 xl:ml-72">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-white shadow-sm border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                <button id="mobile-menu-btn" class="p-2 text-gray-600 hover:text-gray-900 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                <div class="relative">
                    <a href="{{ route('admin.messages.index') }}" class="p-2 text-gray-600 hover:text-gray-900 transition duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        @php
                            $unreadMessages = App\Models\Message::where('status', 'unread')->count();
                        @endphp
                        @if($unreadMessages > 0)
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $unreadMessages }}
                            </span>
                        @endif
                    </a>
                </div>
            </header>
            
            <!-- Desktop Header -->
            <header class="hidden lg:block bg-white shadow-sm border-b border-gray-200 px-6 xl:px-8 py-5 xl:py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl xl:text-3xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm xl:text-base text-gray-600">@yield('page-description', 'Manage your mini market efficiently')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Messages Notifications -->
                        <div class="relative">
                            <a href="{{ route('admin.messages.index') }}" class="p-2 text-gray-400 hover:text-gray-600 transition duration-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                @php
                                    $unreadMessages = App\Models\Message::where('status', 'unread')->count();
                                @endphp
                                @if($unreadMessages > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ $unreadMessages }}
                                    </span>
                                @endif
                            </a>
                        </div>
                        
                        <!-- Current Time -->
                        <div class="text-sm text-gray-600">
                            <span id="current-time"></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mx-4 lg:mx-6 mt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
                                <title>Close</title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-4 lg:mx-6 mt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
                                <title>Close</title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="p-4 lg:p-6 xl:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: true, 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            const dateString = now.toLocaleDateString('en-US', { 
                weekday: 'short', 
                month: 'short', 
                day: 'numeric' 
            });
            document.getElementById('current-time').textContent = `${dateString}, ${timeString}`;
        }
        
        updateTime();
        setInterval(updateTime, 1000);

        // Auto-hide flash messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const adminSidebar = document.getElementById('admin-sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');

        if (mobileMenuBtn && adminSidebar && mobileOverlay) {
            mobileMenuBtn.addEventListener('click', function() {
                adminSidebar.classList.toggle('-translate-x-full');
                mobileOverlay.classList.toggle('hidden');
            });

            mobileOverlay.addEventListener('click', function() {
                adminSidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('hidden');
            });

            // Close mobile menu when window is resized to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    adminSidebar.classList.remove('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
