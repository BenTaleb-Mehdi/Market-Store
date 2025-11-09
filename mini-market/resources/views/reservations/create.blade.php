@extends('layouts.main')

@section('title', 'Reserve ' . $product->name . ' - Mini Market')

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
                <!-- Product Info -->
                <div class="p-8 bg-gradient-to-br from-primary-50 to-primary-100">
                    <div class="mb-6">
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-full h-64 bg-gradient-to-br from-primary-200 to-primary-300 rounded-lg flex items-center justify-center">
                                <svg class="w-16 h-16 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    @if($product->description)
                        <p class="text-gray-700 mb-6 leading-relaxed">{{ $product->description }}</p>
                    @endif
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-white rounded-lg shadow-sm">
                            <span class="text-gray-600 font-medium">Price:</span>
                            <span class="text-2xl font-bold text-primary-600">{{ App\Models\Setting::formatPrice($product->price) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-4 bg-white rounded-lg shadow-sm">
                            <span class="text-gray-600 font-medium">Available Stock:</span>
                            <span class="text-lg font-semibold text-green-600">{{ $product->stock }} units</span>
                        </div>
                        
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-medium text-yellow-800">Reservation Info</h4>
                                    <p class="text-sm text-yellow-700 mt-1">Your reservation will be held for 24 hours. We'll contact you to confirm pickup details.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservation Form -->
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Reserve This Product</h2>
                    
                    <form action="{{ route('reservations.store', $product) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Customer Name -->
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="customer_name" 
                                   name="customer_name" 
                                   value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('customer_name') border-red-500 @enderror"
                                   placeholder="Enter your full name"
                                   required>
                            @error('customer_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Customer Email -->
                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="customer_email" 
                                   name="customer_email" 
                                   value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('customer_email') border-red-500 @enderror"
                                   placeholder="Enter your email address"
                                   required>
                            @error('customer_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Customer Phone -->
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   id="customer_phone" 
                                   name="customer_phone" 
                                   value="{{ old('customer_phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('customer_phone') border-red-500 @enderror"
                                   placeholder="Enter your phone number"
                                   required>
                            @error('customer_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity <span class="text-red-500">*</span>
                            </label>
                            <select id="quantity" 
                                    name="quantity" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('quantity') border-red-500 @enderror"
                                    required>
                                @for($i = 1; $i <= min(10, $product->stock); $i++)
                                    <option value="{{ $i }}" {{ old('quantity') == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ $i == 1 ? 'unit' : 'units' }}
                                        @if($i > 1)
                                            (Total: {{ App\Models\Setting::formatPrice($product->price * $i) }})
                                        @endif
                                    </option>
                                @endfor
                            </select>
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Shipping Address -->
                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Shipping Address <span class="text-red-500">*</span>
                            </label>
                            <textarea id="shipping_address" 
                                      name="shipping_address" 
                                      rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('shipping_address') border-red-500 @enderror"
                                      placeholder="Enter your complete shipping address..."
                                      required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone for Delivery -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Delivery Contact Phone <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror"
                                   placeholder="Phone number for delivery coordination"
                                   required>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Additional Notes (Optional)
                            </label>
                            <textarea id="notes" 
                                      name="notes" 
                                      rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('notes') border-red-500 @enderror"
                                      placeholder="Any special requests or notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Price Display -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium text-gray-700">Estimated Total:</span>
                                <span id="total-price" class="text-2xl font-bold text-primary-600">{{ App\Models\Setting::formatPrice($product->price) }}</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Final price will be confirmed upon pickup</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex space-x-4">
                            <button type="submit" 
                                    class="flex-1 bg-primary-600 text-white px-6 py-4 rounded-lg hover:bg-primary-700 transition duration-200 font-semibold text-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Submit Reservation
                                </span>
                            </button>
                            
                            <a href="{{ route('products.index') }}" 
                               class="px-6 py-4 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update total price when quantity changes
    document.getElementById('quantity').addEventListener('change', function() {
        const quantity = parseInt(this.value);
        const price = {{ $product->price }};
        const total = quantity * price;
        const currency = '{{ App\Models\Setting::get('currency', 'USD') }}';
        const formattedPrice = currency === 'MAD' ? total.toFixed(2) + ' MAD' : '{{ App\Models\Setting::getCurrencySymbol() }}' + total.toFixed(2);
        document.getElementById('total-price').textContent = formattedPrice;
    });
</script>
@endsection
