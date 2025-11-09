@extends('layouts.main')

@section('title', 'Products - Mini Market')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 md:py-8">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Our Products</h1>
            <p class="text-sm md:text-base text-gray-600">Discover fresh, quality products available for reservation</p>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-xl shadow-md p-4 md:p-6 mb-6 md:mb-8">
            <form method="GET" action="{{ route('products.list') }}" class="space-y-4 md:space-y-0">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <!-- Search Bar -->
                    <div class="w-full md:w-1/3">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search products..." 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <!-- Category Filter -->
                    <div class="w-full md:w-auto">
                        <select name="category" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">All Categories</option>
                            <option value="fruits" {{ request('category') == 'fruits' ? 'selected' : '' }}>Fruits</option>
                            <option value="vegetables" {{ request('category') == 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                            <option value="dairy" {{ request('category') == 'dairy' ? 'selected' : '' }}>Dairy</option>
                            <option value="bakery" {{ request('category') == 'bakery' ? 'selected' : '' }}>Bakery</option>
                            <option value="beverages" {{ request('category') == 'beverages' ? 'selected' : '' }}>Beverages</option>
                            <option value="snacks" {{ request('category') == 'snacks' ? 'selected' : '' }}>Snacks</option>
                            <option value="general" {{ request('category') == 'general' ? 'selected' : '' }}>General</option>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="flex items-center space-x-2">
                        @php
                            $currency = App\Models\Setting::get('currency', 'USD');
                        @endphp
                        <input type="number" 
                               name="min_price" 
                               value="{{ request('min_price') }}"
                               placeholder="Min {{ $currency }}" 
                               step="0.01"
                               class="w-20 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <span class="text-gray-500">-</span>
                        <input type="number" 
                               name="max_price" 
                               value="{{ request('max_price') }}"
                               placeholder="Max {{ $currency }}" 
                               step="0.01"
                               class="w-20 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <!-- Sort By -->
                    <div class="w-full md:w-auto">
                        <select name="sort" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">Sort By</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low-High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High-Low</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </button>
                        <a href="{{ route('products.list') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Summary -->
        <div class="mb-6">
            <p class="text-gray-600">
                Showing {{ $products->count() }} of {{ $products->total() }} products
                @if(request('search'))
                    for "<strong>{{ request('search') }}</strong>"
                @endif
                @if(request('category'))
                    in <strong>{{ ucfirst(request('category')) }}</strong>
                @endif
            </p>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                        <!-- Product Image -->
                        <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                            @if($product->image)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 md:h-64 object-cover">
                            @else
                                <div class="w-full h-48 md:h-64 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <!-- Category Badge -->
                            <div class="mb-2">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-medium">
                                    {{ ucfirst($product->category) }}
                                </span>
                            </div>

                            <!-- Product Name -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                            
                            <!-- Description -->
                            @if($product->description)
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                            @endif
                            
                            <!-- Price and Stock -->
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-2xl font-bold text-blue-600">{{ App\Models\Setting::formatPrice($product->price) }}</p>
                                <span class="text-sm {{ $product->stock > 10 ? 'text-green-600' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                    @if($product->stock > 0)
                                        {{ $product->stock }} in stock
                                    @else
                                        Out of stock
                                    @endif
                                </span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-2">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="w-full bg-gray-100 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition duration-200 text-center block font-medium text-sm">
                                    View Details
                                </a>
                                
                                @if($product->is_active && $product->stock > 0)
                                    @auth
                                        <form method="POST" action="{{ route('cart.add', $product) }}" class="w-full">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-medium flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                                                </svg>
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 text-center block font-medium">
                                            Login to Order
                                        </a>
                                    @endauth
                                @else
                                    <div class="w-full bg-gray-400 text-white px-4 py-2 rounded-lg text-center font-medium cursor-not-allowed">
                                        @if(!$product->is_active)
                                            Unavailable
                                        @else
                                            Out of Stock
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="flex justify-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- No Products Found -->
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                <p class="mt-2 text-gray-500">
                    @if(request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                        Try adjusting your search criteria or 
                        <a href="{{ route('products.list') }}" class="text-blue-600 hover:text-blue-700">clear all filters</a>
                    @else
                        Check back soon for new products!
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
