@extends('layouts.main')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">My Orders</h2>
                    <a href="{{ route('products.list') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        Continue Shopping
                    </a>
                </div>

                @if($orders->count() > 0)
                    <div class="space-y-6">
                        @foreach($orders as $order)
                            <div class="bg-gray-50 rounded-lg p-6 border">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'processing') bg-purple-100 text-purple-800
                                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <p class="text-lg font-bold text-gray-900 mt-1">{{ App\Models\Setting::formatPrice($order->total_amount) }}</p>
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <h4 class="font-medium text-gray-900 mb-2">Items:</h4>
                                    <div class="space-y-2">
                                        @foreach($order->orderItems as $item)
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-10 h-10 rounded object-cover mr-3">
                                                    @else
                                                        <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center mr-3">
                                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × {{ App\Models\Setting::formatPrice($item->price) }}</p>
                                                    </div>
                                                </div>
                                                <p class="font-medium text-gray-900">{{ App\Models\Setting::formatPrice($item->total_price) }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="border-t pt-4 mt-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm text-gray-600">Payment Method: <span class="font-medium">{{ $order->payment_type === 'cod' ? 'Cash on Delivery' : 'Card Payment' }}</span></p>
                                            @if($order->shipping_address)
                                                <p class="text-sm text-gray-600">Shipping: {{ Str::limit($order->shipping_address, 50) }}</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No orders yet</h3>
                        <p class="mt-2 text-gray-500">Start shopping to see your orders here.</p>
                        <div class="mt-6">
                            <a href="{{ route('products.list') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Start Shopping
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
