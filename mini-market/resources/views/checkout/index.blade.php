@extends('layouts.main')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Checkout</h2>

                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    @if($item['product']->image)
                                        <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="w-12 h-12 rounded object-cover mr-4">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center mr-4">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $item['product']->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $item['quantity'] }} × ${{ number_format($item['product']->price, 2) }}</p>
                                    </div>
                                </div>
                                <p class="font-medium text-gray-900">${{ number_format($item['subtotal'], 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span>Total:</span>
                            <span class="text-blue-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form id="payment-form" class="space-y-6">
                    @csrf
                    
                    <!-- Customer Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Customer Information</h3>
                        
                        <div>
                            <label for="cardholder_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="cardholder_name" 
                                   name="cardholder_name" 
                                   value="{{ Auth::user()->name }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter your full name"
                                   required>
                        </div>

                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Shipping Address <span class="text-red-500">*</span>
                            </label>
                            <textarea id="shipping_address" 
                                      name="shipping_address" 
                                      rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Enter your full shipping address..."
                                      required>{{ Auth::user()->address }}</textarea>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ Auth::user()->phone }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter your phone number"
                                   required>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Order Notes (Optional)
                            </label>
                            <textarea id="notes" 
                                      name="notes" 
                                      rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Any special instructions..."></textarea>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Payment Method</h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-center space-x-3 p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-200 payment-method-option">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="card" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                       checked>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    <div>
                                        <span class="font-medium">Card Payment</span>
                                        <p class="text-sm text-gray-600">Pay securely with your credit/debit card</p>
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center space-x-3 p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-200 payment-method-option">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="cod" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <div>
                                        <span class="font-medium">Cash on Delivery</span>
                                        <p class="text-sm text-gray-600">Pay when you receive your order</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Stripe Card Element Container -->
                    <div id="card-container" class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900">Card Details</h4>
                        <div id="card-element" class="p-4 border border-gray-300 rounded-lg bg-white">
                            <!-- Stripe Elements will create form elements here -->
                        </div>
                        <div id="card-errors" class="text-red-600 text-sm" role="alert"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-6 border-t">
                        <a href="{{ route('cart.view') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                            ← Back to Cart
                        </a>
                        
                        <button type="submit" id="submit-button" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg id="loading-spinner" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span id="button-text">Complete Payment</span>
                        </button>
                    </div>
                </form>

                <!-- Payment Messages -->
                <div id="payment-message" class="mt-4 p-4 rounded-lg hidden">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium" id="message-text"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stripe JavaScript -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Initialize Stripe
    const stripe = Stripe('{{ env('STRIPE_KEY', 'pk_test_demo') }}');
    const elements = stripe.elements();
    
    // Create card element
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
        },
    });
    
    cardElement.mount('#card-element');
    
    // Handle real-time validation errors from the card Element
    cardElement.on('change', ({error}) => {
        const displayError = document.getElementById('card-errors');
        if (error) {
            displayError.textContent = error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    // Get form elements
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const loadingSpinner = document.getElementById('loading-spinner');
    const paymentMessage = document.getElementById('payment-message');
    const messageText = document.getElementById('message-text');
    const cardContainer = document.getElementById('card-container');
    
    // Handle payment method selection
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'card') {
                cardContainer.style.display = 'block';
                buttonText.textContent = 'Complete Payment';
            } else {
                cardContainer.style.display = 'none';
                buttonText.textContent = 'Place Order';
            }
        });
    });
    
    // Show loading state
    function showLoading() {
        submitButton.disabled = true;
        loadingSpinner.classList.remove('hidden');
        buttonText.textContent = 'Processing...';
    }
    
    // Hide loading state
    function hideLoading() {
        submitButton.disabled = false;
        loadingSpinner.classList.add('hidden');
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        buttonText.textContent = paymentMethod === 'card' ? 'Complete Payment' : 'Place Order';
    }
    
    // Show message
    function showMessage(message, isError = true) {
        paymentMessage.classList.remove('hidden');
        paymentMessage.className = `mt-4 p-4 rounded-lg ${isError ? 'bg-red-50 text-red-800' : 'bg-green-50 text-green-800'}`;
        messageText.textContent = message;
    }
    
    // Handle form submission
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const shippingAddress = document.getElementById('shipping_address').value;
        const phone = document.getElementById('phone').value;
        const notes = document.getElementById('notes').value;
        const cardholderName = document.getElementById('cardholder_name').value;
        
        if (!shippingAddress || !phone || !cardholderName) {
            showMessage('Please fill in all required fields.');
            return;
        }
        
        showLoading();
        
        try {
            if (paymentMethod === 'cod') {
                // Handle Cash on Delivery
                const response = await fetch('{{ route('payment.cod') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        shipping_address: shippingAddress,
                        phone: phone,
                        notes: notes
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    window.location.href = `{{ route('checkout.success') }}?order=${result.order_id}`;
                } else {
                    throw new Error(result.error || 'Failed to process order');
                }
            } else {
                // Handle Card Payment with Stripe
                
                // Create payment intent
                const intentResponse = await fetch('{{ route('payment.create-intent') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });
                
                const { client_secret, error: intentError } = await intentResponse.json();
                
                if (intentError) {
                    throw new Error(intentError);
                }
                
                // Confirm payment with Stripe
                const { error, paymentIntent } = await stripe.confirmCardPayment(client_secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardholderName,
                        },
                    }
                });
                
                if (error) {
                    throw new Error(error.message);
                }
                
                if (paymentIntent.status === 'succeeded') {
                    // Confirm payment on server
                    const confirmResponse = await fetch('{{ route('payment.confirm') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({
                            payment_intent_id: paymentIntent.id,
                            shipping_address: shippingAddress,
                            phone: phone,
                            notes: notes
                        })
                    });
                    
                    const confirmResult = await confirmResponse.json();
                    
                    if (confirmResult.success) {
                        window.location.href = `{{ route('checkout.success') }}?order=${confirmResult.order_id}`;
                    } else {
                        throw new Error(confirmResult.error || 'Failed to confirm payment');
                    }
                }
            }
        } catch (error) {
            console.error('Payment error:', error);
            showMessage(error.message);
        } finally {
            hideLoading();
        }
    });
</script>
@endsection
