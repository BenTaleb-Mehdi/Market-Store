@extends('layouts.main')

@section('title', 'Mini Market - Fresh Products & Easy Reservations')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary-600 to-primary-800 text-white py-10 md:py-16 lg:py-20 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-primary-600/90 to-primary-800/90"></div>
    <div class="absolute inset-0 bg-black/30"></div>
    
    <div class="relative max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <!-- Text Content -->
            <div class="text-center lg:text-left scroll-animate-left">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 md:mb-6 leading-tight">
                    Fresh Products, <span class="text-yellow-300">Easy Reservations</span>
                </h1>
                <p class="text-lg md:text-xl lg:text-2xl mb-6 md:mb-8 text-gray-100">
                    Discover premium quality products and reserve them instantly. Your neighborhood mini market with modern convenience.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#products" class="bg-yellow-400 text-gray-900 px-4 py-2 md:px-6 md:py-3 lg:px-8 lg:py-4 rounded-xl font-semibold hover:bg-yellow-300 transition duration-200 text-sm md:text-base lg:text-lg shadow-md hover:shadow-lg">
                        Browse Products
                    </a>
                    <a href="#contact" class="border-2 border-white text-white px-4 py-2 md:px-6 md:py-3 lg:px-8 lg:py-4 rounded-xl font-semibold hover:bg-white hover:text-primary-600 transition duration-200 text-sm md:text-base lg:text-lg">
                        Contact Us
                    </a>
                </div>
            </div>
            
            <!-- Hero Image -->
            <div class="relative lg:block scroll-animate-right">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                         alt="Fresh grocery products" 
                         class="rounded-2xl shadow-2xl w-full h-96 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl"></div>
                </div>
                
                <!-- Floating Cards -->
                <div class="absolute -top-4 -left-4 bg-white text-gray-900 p-4 rounded-xl shadow-lg pulse-slow">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="font-semibold text-sm">Fresh Daily</span>
                    </div>
                </div>
                
                <div class="absolute -bottom-4 -right-4 bg-yellow-400 text-gray-900 p-4 rounded-xl shadow-lg pulse-slow">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-semibold text-sm">Quick Reserve</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-10 md:py-16 bg-white">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12 scroll-animate">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">About Mini Market</h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">
                We're revolutionizing the way you shop for everyday essentials with our innovative reservation system.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 scroll-animate-scale stagger-1">
                <div class="bg-primary-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Premium Quality</h3>
                <p class="text-gray-600">We source only the finest products to ensure you get the best quality every time.</p>
            </div>
            
            <div class="text-center p-6 scroll-animate-scale stagger-2">
                <div class="bg-primary-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Quick Reservations</h3>
                <p class="text-gray-600">Reserve your products in seconds with our simple and intuitive reservation system.</p>
            </div>
            
            <div class="text-center p-6 scroll-animate-scale stagger-3">
                <div class="bg-primary-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Community Focused</h3>
                <p class="text-gray-600">Serving our local community with personalized service and competitive prices.</p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="py-10 md:py-16 bg-gray-50">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12 scroll-animate">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Our Products</h2>
            <p class="text-lg md:text-xl text-gray-600">Fresh, quality products available for instant reservation</p>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden transform hover:-translate-y-1 scroll-animate-scale stagger-{{ ($loop->index % 4) + 1 }}">
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
                        <div class="p-4 md:p-6">
                            <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                            @if($product->description)
                                <p class="text-gray-600 text-sm md:text-base mb-3 line-clamp-2">{{ $product->description }}</p>
                            @endif
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-xl md:text-2xl font-bold text-primary-600">{{ App\Models\Setting::formatPrice($product->price) }}</p>
                                <span class="text-sm md:text-base text-gray-500">Stock: {{ $product->stock }}</span>
                            </div>
                            <div class="space-y-2">
                                <a href="{{ route('products.show', $product) }}" class="w-full bg-gray-100 text-gray-800 px-4 py-2 md:px-6 md:py-3 rounded-xl hover:bg-gray-200 transition duration-200 text-center block font-medium text-sm md:text-base">
                                    View Details
                                </a>
                                @if($product->stock > 0)
                                    @auth
                                        <form action="{{ route('cart.add', $product) }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full bg-primary-600 text-white px-4 py-2 md:px-6 md:py-3 rounded-xl hover:bg-primary-700 transition duration-200 font-medium text-sm md:text-base shadow-md hover:shadow-lg">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="w-full bg-primary-600 text-white px-4 py-3 rounded-md hover:bg-primary-700 transition duration-200 text-center block font-medium">
                                            Login to Purchase
                                        </a>
                                    @endauth
                                @else
                                    <div class="w-full bg-gray-400 text-white px-4 py-3 rounded-md text-center font-medium cursor-not-allowed">
                                        Out of Stock
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 scroll-animate">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No products available</h3>
                <p class="mt-2 text-gray-500">Check back soon for new products!</p>
            </div>
        @endif
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-10 md:py-16 bg-white">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12 scroll-animate">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Get In Touch</h2>
            <p class="text-lg md:text-xl text-gray-600">Have questions? We'd love to hear from you.</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="scroll-animate-left">
                <h3 class="text-2xl font-semibold text-gray-900 mb-6">Contact Information</h3>
                <div class="space-y-6">
                    <div class="flex items-start scroll-animate stagger-1">
                        <div class="bg-primary-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Address</h4>
                            <p class="text-gray-600">123 Market Street<br>Downtown, City 12345</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start scroll-animate stagger-2">
                        <div class="bg-primary-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Phone</h4>
                            <p class="text-gray-600">+1 (555) 123-4567</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start scroll-animate stagger-3">
                        <div class="bg-primary-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Email</h4>
                            <p class="text-gray-600">info@minimarket.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start scroll-animate stagger-4">
                        <div class="bg-primary-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Hours</h4>
                            <p class="text-gray-600">Mon-Fri: 8AM-8PM<br>Sat-Sun: 9AM-6PM</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="scroll-animate-right">
                <h3 class="text-2xl font-semibold text-gray-900 mb-6">Send us a Message</h3>
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf
                    <div class="scroll-animate stagger-1">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="scroll-animate stagger-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="scroll-animate stagger-3">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea id="message" name="message" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full bg-primary-600 text-white px-6 py-3 rounded-md hover:bg-primary-700 transition duration-200 font-medium scroll-animate stagger-4">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
