@extends('layouts.main')

@section('title', 'My Reservations - Mini Market')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Reservations</h1>
                    <p class="mt-2 text-gray-600">Track and manage your product reservations</p>
                </div>
                <a href="{{ route('products.index') }}" 
                   class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition duration-200 font-medium">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        New Reservation
                    </span>
                </a>
            </div>
        </div>

        @if($reservations->count() > 0)
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $reservations->where('status', 'pending')->count() }}</p>
                        </div>
                        <div class="bg-yellow-100 p-2 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Confirmed</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $reservations->where('status', 'confirmed')->count() }}</p>
                        </div>
                        <div class="bg-blue-100 p-2 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Completed</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $reservations->where('status', 'completed')->count() }}</p>
                        </div>
                        <div class="bg-green-100 p-2 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-gray-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $reservations->total() }}</p>
                        </div>
                        <div class="bg-gray-100 p-2 rounded-full">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservations List -->
            <div class="space-y-6">
                @foreach($reservations as $reservation)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <!-- Reservation Info -->
                                <div class="flex-1">
                                    <div class="flex items-center space-x-4 mb-4">
                                        @if($reservation->product && $reservation->product->image)
                                            <img src="{{ $reservation->product->image_url }}" 
                                                 alt="{{ $reservation->product->name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                @if($reservation->product)
                                                    {{ $reservation->product->name }}
                                                @else
                                                    <span class="text-red-500">Product Deleted</span>
                                                @endif
                                            </h3>
                                            <p class="text-sm text-gray-600">Reservation #{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</p>
                                            <p class="text-sm text-gray-600">{{ $reservation->created_at->format('M d, Y \a\t g:i A') }}</p>
                                        </div>
                                    </div>

                                    <!-- Details Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Quantity:</span>
                                            <span class="font-medium ml-1">{{ $reservation->quantity }} units</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Total:</span>
                                            <span class="font-medium ml-1">{{ App\Models\Setting::formatPrice($reservation->total_price) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Payment:</span>
                                            <span class="font-medium ml-1">
                                                @if($reservation->payment_method === 'cash')
                                                    Cash on Delivery
                                                @else
                                                    Credit/Debit Card
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    @if($reservation->shipping_address)
                                        <div class="mt-3 text-sm">
                                            <span class="text-gray-600">Delivery Address:</span>
                                            <span class="ml-1">{{ Str::limit($reservation->shipping_address, 60) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Status and Actions -->
                                <div class="flex flex-col items-end space-y-3">
                                    <!-- Status Badges -->
                                    <div class="flex flex-col space-y-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($reservation->status === 'confirmed') bg-blue-100 text-blue-800
                                            @elseif($reservation->status === 'completed') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                        
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($reservation->payment_status === 'paid') bg-green-100 text-green-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ ucfirst($reservation->payment_status) }}
                                        </span>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex space-x-2">
                                        @if($reservation->payment_status === 'pending')
                                            <a href="{{ route('reservations.checkout', $reservation) }}" 
                                               class="bg-primary-600 text-white px-3 py-1 rounded text-sm hover:bg-primary-700 transition duration-200">
                                                Complete Payment
                                            </a>
                                        @endif
                                        
                                        @if($reservation->payment_status === 'paid')
                                            <a href="{{ route('reservations.success', $reservation) }}" 
                                               class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition duration-200">
                                                View Receipt
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $reservations->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Reservations Yet</h3>
                <p class="text-gray-600 mb-6">You haven't made any reservations yet. Browse our products to get started!</p>
                <a href="{{ route('products.index') }}" 
                   class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition duration-200 font-medium inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Browse Products
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
