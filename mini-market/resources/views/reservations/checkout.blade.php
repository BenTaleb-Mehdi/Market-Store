@extends('layouts.main')

@section('title', 'Complete Payment - Mini Market')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Order Summary -->
                <div class="p-8 bg-gradient-to-br from-primary-50 to-primary-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>
                    
                    <div class="space-y-4">
                        <!-- Product Info -->
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <div class="flex items-center space-x-4">
                                @if($reservation->product->image)
                                    <img src="{{ $reservation->product->image_url }}" alt="{{ $reservation->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $reservation->product->name }}</h3>
                                    <p class="text-sm text-gray-600">Quantity: {{ $reservation->quantity }}</p>
                                    <p class="text-sm text-gray-600">Unit Price: {{ App\Models\Setting::formatPrice($reservation->product->price) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-gray-900 mb-2">Customer Information</h4>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p><strong>Name:</strong> {{ $reservation->customer_name }}</p>
                                <p><strong>Email:</strong> {{ $reservation->customer_email }}</p>
                                <p><strong>Phone:</strong> {{ $reservation->customer_phone }}</p>
                            </div>
                        </div>

                        <!-- Shipping Info -->
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-gray-900 mb-2">Delivery Information</h4>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p><strong>Address:</strong> {{ $reservation->shipping_address }}</p>
                                <p><strong>Contact:</strong> {{ $reservation->phone }}</p>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="bg-primary-600 text-white p-4 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium">Total Amount:</span>
                                <span class="text-2xl font-bold">{{ App\Models\Setting::formatPrice($reservation->total_price) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Options -->
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Choose Payment Method</h2>
                    
                    <div class="space-y-4">
                        <!-- Card Payment -->
                        <div class="border border-gray-200 rounded-lg p-6 hover:border-primary-300 transition duration-200 cursor-pointer" onclick="selectPaymentMethod('card')">
                            <div class="flex items-center space-x-4">
                                <input type="radio" id="card" name="payment_method" value="card" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                <div class="flex-1">
                                    <label for="card" class="block text-lg font-medium text-gray-900 cursor-pointer">
                                        Credit/Debit Card
                                    </label>
                                    <p class="text-sm text-gray-600">Pay securely with your card. Payment processed immediately.</p>
                                </div>
                                <div class="flex space-x-2">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor" stroke-width="2"/>
                                        <path d="M2 10h20" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Cash Payment -->
                        <div class="border border-gray-200 rounded-lg p-6 hover:border-primary-300 transition duration-200 cursor-pointer" onclick="selectPaymentMethod('cash')">
                            <div class="flex items-center space-x-4">
                                <input type="radio" id="cash" name="payment_method" value="cash" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                <div class="flex-1">
                                    <label for="cash" class="block text-lg font-medium text-gray-900 cursor-pointer">
                                        Cash on Delivery
                                    </label>
                                    <p class="text-sm text-gray-600">Pay with cash when your order is delivered. Stock reserved immediately.</p>
                                </div>
                                <div class="flex space-x-2">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <div class="mt-8">
                        <button id="payment-button" 
                                onclick="processPayment()" 
                                class="w-full bg-primary-600 text-white px-6 py-4 rounded-lg hover:bg-primary-700 transition duration-200 font-semibold text-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Complete Payment
                            </span>
                        </button>
                    </div>

                    <!-- Card Payment Form (Hidden by default) -->
                    <div id="card-payment-form" class="mt-6 hidden">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div id="card-element" class="p-3 border border-gray-300 rounded-lg bg-white">
                                <!-- Stripe Elements will create form elements here -->
                            </div>
                            <div id="card-errors" role="alert" class="text-red-600 text-sm mt-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>

<script>
let selectedPaymentMethod = null;
let stripe = null;
let elements = null;
let cardElement = null;

// Initialize Stripe
if (typeof Stripe !== 'undefined') {
    stripe = Stripe('{{ env('STRIPE_KEY') }}');
    elements = stripe.elements();
    cardElement = elements.create('card');
}

function selectPaymentMethod(method) {
    selectedPaymentMethod = method;
    
    // Update radio buttons
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.checked = radio.value === method;
    });
    
    // Show/hide card form
    const cardForm = document.getElementById('card-payment-form');
    const paymentButton = document.getElementById('payment-button');
    
    if (method === 'card') {
        cardForm.classList.remove('hidden');
        if (cardElement && !cardElement._mounted) {
            cardElement.mount('#card-element');
        }
    } else {
        cardForm.classList.add('hidden');
    }
    
    // Enable payment button
    paymentButton.disabled = false;
    paymentButton.textContent = method === 'card' ? 'Pay with Card' : 'Confirm Cash on Delivery';
}

async function processPayment() {
    if (!selectedPaymentMethod) {
        alert('Please select a payment method');
        return;
    }

    const paymentButton = document.getElementById('payment-button');
    paymentButton.disabled = true;
    paymentButton.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...</span>';

    try {
        if (selectedPaymentMethod === 'cash') {
            // Process cash payment
            const response = await fetch('{{ route('reservations.payment', $reservation) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_method: 'cash'
                })
            });

            if (response.ok) {
                window.location.href = '{{ route('reservations.success', $reservation) }}';
            } else {
                throw new Error('Payment processing failed');
            }
        } else if (selectedPaymentMethod === 'card') {
            // Process card payment
            const {token, error} = await stripe.createToken(cardElement);
            
            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                paymentButton.disabled = false;
                paymentButton.innerHTML = '<span class="flex items-center justify-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Pay with Card</span>';
                return;
            }

            // Create payment intent
            const response = await fetch('{{ route('reservations.payment', $reservation) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_method: 'card'
                })
            });

            const data = await response.json();
            
            if (data.client_secret) {
                const {error: confirmError} = await stripe.confirmCardPayment(data.client_secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: '{{ $reservation->customer_name }}',
                            email: '{{ $reservation->customer_email }}'
                        }
                    }
                });

                if (confirmError) {
                    document.getElementById('card-errors').textContent = confirmError.message;
                    paymentButton.disabled = false;
                    paymentButton.innerHTML = '<span class="flex items-center justify-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Pay with Card</span>';
                } else {
                    // Payment succeeded, confirm with server
                    const confirmResponse = await fetch('{{ route('reservations.confirm-payment', $reservation) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            payment_intent_id: data.client_secret.split('_secret_')[0]
                        })
                    });

                    if (confirmResponse.ok) {
                        window.location.href = '{{ route('reservations.success', $reservation) }}';
                    } else {
                        throw new Error('Payment confirmation failed');
                    }
                }
            }
        }
    } catch (error) {
        console.error('Payment error:', error);
        alert('Payment processing failed. Please try again.');
        paymentButton.disabled = false;
        paymentButton.innerHTML = '<span class="flex items-center justify-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Complete Payment</span>';
    }
}
</script>
@endsection
