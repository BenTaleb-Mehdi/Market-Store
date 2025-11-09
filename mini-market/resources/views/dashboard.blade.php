@extends('layouts.main')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h2>
                    <p class="text-gray-600 mt-2">Here's what's happening with your account</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Orders Card -->
                    <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">My Orders</h3>
                                <p class="text-sm text-gray-600">View your order history</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                View Orders →
                            </a>
                        </div>
                    </div>

                    <!-- Cart Card -->
                    <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Shopping Cart</h3>
                                <p class="text-sm text-gray-600">
                                    @php
                                        $cartCount = session('cart') ? array_sum(session('cart')) : 0;
                                    @endphp
                                    {{ $cartCount }} items in cart
                                </p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('cart.view') }}" class="text-green-600 hover:text-green-700 font-medium">
                                View Cart →
                            </a>
                        </div>
                    </div>

                    <!-- Messages Card -->
                    <div class="bg-orange-50 rounded-lg p-6 border border-orange-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">My Messages</h3>
                                <p class="text-sm text-gray-600">
                                    @php
                                        $userMessages = App\Models\Message::where('user_id', Auth::id())
                                            ->orWhere('email', Auth::user()->email)
                                            ->count();
                                        $newReplies = App\Models\Message::where('user_id', Auth::id())
                                            ->orWhere('email', Auth::user()->email)
                                            ->where('status', 'replied')
                                            ->where('updated_at', '>', Auth::user()->last_message_check ?? '1970-01-01')
                                            ->count();
                                    @endphp
                                    {{ $userMessages }} total messages
                                    @if($newReplies > 0)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">
                                            {{ $newReplies }} new replies
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('messages.inbox') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                                View Messages →
                            </a>
                        </div>
                    </div>

                    <!-- Profile Card -->
                    <div class="bg-purple-50 rounded-lg p-6 border border-purple-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">My Profile</h3>
                                <p class="text-sm text-gray-600">Update your information</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('profile.edit') }}" class="text-purple-600 hover:text-purple-700 font-medium">
                                Edit Profile →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('products.list') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                            Browse Products
                        </a>
                        @if(session('cart') && count(session('cart')) > 0)
                            <a href="{{ route('checkout.index') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 font-medium">
                                Checkout Now
                            </a>
                        @endif
                        <a href="{{ route('orders.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-200 font-medium">
                            Order History
                        </a>
                        <a href="{{ route('messages.inbox') }}" class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition duration-200 font-medium">
                            My Messages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
