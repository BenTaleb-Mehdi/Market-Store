@extends('layouts.main')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-center">
                <!-- Success Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Success Message -->
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h2>
                <p class="text-gray-600 mb-6">Thank you for your order. We've received your request and will process it shortly.</p>

                <!-- Order Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Order Number:</p>
                            <p class="font-semibold text-gray-900">#{{ $order->id }}</p>
                        </div>
                        
                        <div>
                            <p class="text-gray-600">Order Date:</p>
                            <p class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-gray-600">Total Amount:</p>
                            <p class="font-semibold text-blue-600 text-lg">{{ App\Models\Setting::formatPrice($order->total_amount) }}</p>
                        </div>
                        
                        <div>
                            <p class="text-gray-600">Payment Method:</p>
                            <p class="font-semibold text-gray-900">
                                {{ $order->payment_type === 'cod' ? 'Cash on Delivery' : 'Card Payment' }}
                            </p>
                        </div>
                    </div>

                    @if($order->payment_type === 'cod')
                        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="text-left">
                                    <h4 class="font-medium text-yellow-800">Cash on Delivery</h4>
                                    <p class="text-sm text-yellow-700 mt-1">Please have the exact amount ready when our delivery person arrives.</p>
                                </div>
                            </div>
                        </div>
                    @elseif($order->payment_type === 'card')
                        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div class="text-left">
                                    <h4 class="font-medium text-green-800">Payment Confirmed</h4>
                                    <p class="text-sm text-green-700 mt-1">Your card payment has been processed successfully.</p>
                                    @if($order->stripe_payment_id)
                                        <p class="text-xs text-green-600 mt-1">Payment ID: {{ $order->stripe_payment_id }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Next Steps -->
                <div class="text-left bg-blue-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">What happens next?</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            We'll send you an order confirmation email shortly
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Our team will prepare your order for delivery
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            You'll receive updates on your order status
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Expected delivery within 1-2 business days
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('orders.show', $order) }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        View Order Details
                    </a>
                    
                    <a href="{{ route('products.list') }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition duration-200 font-medium">
                        Continue Shopping
                    </a>
                </div>

                <!-- Contact Info -->
                <div class="mt-8 pt-6 border-t text-sm text-gray-600">
                    <p>Need help with your order? Contact us at <a href="mailto:info@minimarket.com" class="text-blue-600 hover:text-blue-700">info@minimarket.com</a> or call <a href="tel:+15551234567" class="text-blue-600 hover:text-blue-700">+1 (555) 123-4567</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
