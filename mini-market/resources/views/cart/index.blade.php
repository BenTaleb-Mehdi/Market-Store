@extends('layouts.main')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Shopping Cart</h2>
                    @if(count($cartItems) > 0)
                        <form method="POST" action="{{ route('cart.clear') }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium" onclick="return confirm('Are you sure you want to clear your cart?')">
                                Clear Cart
                            </button>
                        </form>
                    @endif
                </div>

                @if(count($cartItems) > 0)
                    <div class="space-y-6">
                        <!-- Cart Items -->
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if($item['product']->image)
                                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="w-16 h-16 rounded-lg object-cover mr-4">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $item['product']->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ ucfirst($item['product']->category) }}</p>
                                            <p class="text-sm text-gray-600">{{ App\Models\Setting::formatPrice($item['product']->price) }} each</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <!-- Quantity Controls -->
                                        <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" onclick="decrementQuantity(this)" class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded-full flex items-center justify-center transition duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            
                                            <input type="number" 
                                                   name="quantity" 
                                                   value="{{ $item['quantity'] }}" 
                                                   min="1" 
                                                   max="{{ $item['product']->stock }}"
                                                   class="w-16 text-center border border-gray-300 rounded-md py-1 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                   onchange="this.form.submit()">
                                            
                                            <button type="button" onclick="incrementQuantity(this)" class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded-full flex items-center justify-center transition duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </button>
                                        </form>

                                        <!-- Subtotal -->
                                        <div class="text-right min-w-[80px]">
                                            <p class="font-bold text-gray-900">{{ App\Models\Setting::formatPrice($item['subtotal']) }}</p>
                                        </div>

                                        <!-- Remove Button -->
                                        <form method="POST" action="{{ route('cart.remove', $item['product']) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 p-2" onclick="return confirm('Remove this item from cart?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Cart Summary -->
                        <div class="border-t pt-6">
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex justify-between items-center text-lg font-bold mb-4">
                                    <span>Total:</span>
                                    <span class="text-blue-600">{{ App\Models\Setting::formatPrice($total) }}</span>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <a href="{{ route('products.list') }}" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition duration-200 text-center font-medium">
                                        Continue Shopping
                                    </a>
                                    
                                    <a href="{{ route('checkout.index') }}" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 text-center font-medium">
                                        Proceed to Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty Cart -->
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Your cart is empty</h3>
                        <p class="mt-2 text-gray-500">Start shopping to add items to your cart.</p>
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

<script>
    function incrementQuantity(button) {
        const input = button.previousElementSibling;
        const max = parseInt(input.getAttribute('max'));
        const current = parseInt(input.value);
        
        if (current < max) {
            input.value = current + 1;
            input.form.submit();
        }
    }

    function decrementQuantity(button) {
        const input = button.nextElementSibling;
        const current = parseInt(input.value);
        
        if (current > 1) {
            input.value = current - 1;
            input.form.submit();
        }
    }
</script>
@endsection
