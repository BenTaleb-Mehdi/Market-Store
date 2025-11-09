@extends('layouts.main')

@section('title', $product->name . ' - Mini Market')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 md:py-12">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6 md:mb-8">
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 transition duration-200 px-4 py-2 md:px-6 md:py-3 rounded-xl hover:shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                <!-- Product Image -->
                <div class="p-4 md:p-6 lg:p-8">
                    @if($product->image)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-64 md:h-80 lg:h-96 object-cover rounded-xl shadow-md">
                    @else
                        <div class="w-full h-64 md:h-80 lg:h-96 bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl flex items-center justify-center">
                            <svg class="w-24 h-24 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="p-8">
                    <div class="mb-6">
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                        
                        @if($product->description)
                            <p class="text-lg text-gray-700 leading-relaxed mb-6">{{ $product->description }}</p>
                        @endif
                    </div>

                    <!-- Product Info Cards -->
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Price:</span>
                            <span class="text-3xl font-bold text-primary-600">{{ App\Models\Setting::formatPrice($product->price) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Available Stock:</span>
                            <span class="text-xl font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stock }} units
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Status:</span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        @if($product->is_active)
                            @if($product->stock > 0)
                                @auth
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="w-full">
                                        @csrf
                                        <div class="flex items-center space-x-4 mb-4">
                                            <label for="quantity" class="text-sm font-medium text-gray-700">Quantity:</label>
                                            <select name="quantity" id="quantity" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                                @for($i = 1; $i <= min(10, $product->stock); $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <button type="submit" class="w-full bg-primary-600 text-white px-8 py-4 rounded-lg hover:bg-primary-700 transition duration-200 font-semibold text-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                            <span class="flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                                                </svg>
                                                Add to Cart
                                            </span>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="w-full bg-primary-600 text-white px-8 py-4 rounded-lg hover:bg-primary-700 transition duration-200 text-center block font-semibold text-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                            </svg>
                                            Login to Purchase
                                        </span>
                                    </a>
                                @endauth
                            @else
                                <div class="w-full bg-orange-500 text-white px-8 py-4 rounded-lg text-center font-semibold text-lg">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        Currently Out of Stock
                                    </span>
                                    <p class="text-sm mt-2 text-orange-100">This product will be restocked soon</p>
                                </div>
                            @endif
                        @else
                            <div class="w-full bg-gray-400 text-white px-8 py-4 rounded-lg text-center font-semibold text-lg cursor-not-allowed">
                                Product Unavailable
                            </div>
                        @endif
                        
                        <a href="{{ route('products.index') }}" 
                           class="w-full border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-lg hover:bg-gray-50 transition duration-200 text-center block font-medium">
                            Continue Shopping
                        </a>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-medium text-blue-800">Reservation Information</h4>
                                <ul class="text-sm text-blue-700 mt-1 space-y-1">
                                    <li>• Reservations are held for 24 hours</li>
                                    <li>• We'll contact you to confirm pickup details</li>
                                    <li>• Payment is made upon pickup</li>
                                    <li>• Free cancellation anytime</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @php
            $relatedProducts = App\Models\Product::where('stock', '>', 0)
                ->where('id', '!=', $product->id)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        @endphp

        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">You Might Also Like</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                            <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                                @if($relatedProduct->image)
                                    <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $relatedProduct->name }}</h3>
                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-xl font-bold text-primary-600">{{ App\Models\Setting::formatPrice($relatedProduct->price) }}</p>
                                    <span class="text-sm text-gray-500">Stock: {{ $relatedProduct->stock }}</span>
                                </div>
                                <a href="{{ route('products.show', $relatedProduct) }}" class="w-full bg-gray-100 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-center block font-medium text-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
