@extends('layouts.main')

@section('title', 'Reservation Confirmed - Mini Market')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Success Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-8 py-12 text-center">
                <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Reservation Confirmed!</h1>
                <p class="text-green-100 text-lg">
                    @if($reservation->payment_method === 'cash')
                        Your order has been confirmed. Please prepare cash for delivery.
                    @else
                        Payment successful! Your order is being processed.
                    @endif
                </p>
            </div>

            <!-- Reservation Details -->
            <div class="px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Order Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Details</h2>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Reservation ID:</span>
                                <span class="font-medium">#{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Product:</span>
                                <span class="font-medium">{{ $reservation->product->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">{{ $reservation->quantity }} units</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit Price:</span>
                                <span class="font-medium">{{ App\Models\Setting::formatPrice($reservation->product->price) }}</span>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-900 font-semibold">Total Amount:</span>
                                    <span class="text-xl font-bold text-primary-600">{{ App\Models\Setting::formatPrice($reservation->total_price) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment & Delivery Info -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment & Delivery</h2>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="font-medium">
                                    @if($reservation->payment_method === 'cash')
                                        Cash on Delivery
                                    @else
                                        Credit/Debit Card
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $reservation->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($reservation->payment_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </div>
                            @if($reservation->stripe_payment_id)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Transaction ID:</span>
                                <span class="font-medium text-sm">{{ substr($reservation->stripe_payment_id, 0, 20) }}...</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Customer Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-2">Contact Details</h3>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p><strong>Name:</strong> {{ $reservation->customer_name }}</p>
                                <p><strong>Email:</strong> {{ $reservation->customer_email }}</p>
                                <p><strong>Phone:</strong> {{ $reservation->customer_phone }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-2">Delivery Address</h3>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p>{{ $reservation->shipping_address }}</p>
                                <p><strong>Contact:</strong> {{ $reservation->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($reservation->notes)
                <!-- Notes -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Additional Notes</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700">{{ $reservation->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Next Steps -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">What's Next?</h2>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-medium text-blue-900">Delivery Information</h4>
                                <div class="mt-2 text-sm text-blue-800">
                                    @if($reservation->payment_method === 'cash')
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Your order has been confirmed and stock has been reserved</li>
                                            <li>We will contact you within 24 hours to arrange delivery</li>
                                            <li>Please have the exact amount ready: {{ App\Models\Setting::formatPrice($reservation->total_price) }}</li>
                                            <li>Delivery will be made to: {{ $reservation->shipping_address }}</li>
                                        </ul>
                                    @else
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Payment has been processed successfully</li>
                                            <li>Your order is being prepared for delivery</li>
                                            <li>We will contact you within 24 hours to arrange delivery</li>
                                            <li>Delivery will be made to: {{ $reservation->shipping_address }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.index') }}" 
                       class="flex-1 bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition duration-200 font-semibold text-center">
                        Continue Shopping
                    </a>
                    <button onclick="window.print()" 
                            class="flex-1 bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-200 font-semibold">
                        Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-gradient-to-r {
        background: #10b981 !important;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endsection
