@extends('layouts.main')

@section('title', 'About Us - Mini Market')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16 md:py-24">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">About Mini Market</h1>
                <p class="text-xl md:text-2xl text-primary-100 max-w-3xl mx-auto">
                    Your trusted neighborhood store bringing fresh, quality products right to your doorstep
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-16 md:py-24">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Content -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Our Story</h2>
                        <div class="space-y-4 text-lg text-gray-600">
                            <p>
                                Mini Market was founded with a simple mission: to provide our community with access to fresh, 
                                high-quality products while making shopping convenient and enjoyable. What started as a small 
                                neighborhood store has grown into a trusted local business that serves families across the area.
                            </p>
                            <p>
                                We believe that everyone deserves access to quality groceries and household essentials without 
                                having to travel far from home. Our carefully curated selection includes fresh produce, pantry 
                                staples, and everyday necessities, all sourced from trusted suppliers who share our commitment 
                                to quality.
                            </p>
                            <p>
                                With our online ordering system, we've made it even easier for busy families to get what they 
                                need. Whether you're planning a family dinner or just need to stock up on essentials, we're 
                                here to serve you with a smile.
                            </p>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-3">
                            <div class="bg-primary-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Quality Products</h3>
                                <p class="text-sm text-gray-600">Fresh and high-quality items sourced from trusted suppliers</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="bg-primary-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Fast Service</h3>
                                <p class="text-sm text-gray-600">Quick and efficient service for all your shopping needs</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="bg-primary-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Local Community</h3>
                                <p class="text-sm text-gray-600">Proudly serving our local neighborhood for years</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="bg-primary-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Easy Ordering</h3>
                                <p class="text-sm text-gray-600">Simple online ordering system with multiple payment options</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="order-first lg:order-last">
                    <div class="bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl p-8 lg:p-12">
                        <div class="text-center">
                            <div class="bg-white rounded-full w-32 h-32 mx-auto mb-6 flex items-center justify-center shadow-lg">
                                <svg class="w-16 h-16 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h10M7 11h10M7 15h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Serving Our Community</h3>
                            <p class="text-gray-600 text-lg">
                                Since our founding, we've been committed to providing exceptional service and building 
                                lasting relationships with our customers. Your satisfaction is our priority.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Impact</h2>
                <p class="text-xl text-gray-600">Numbers that reflect our commitment to the community</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-white rounded-xl p-8 shadow-md">
                        <div class="text-4xl font-bold text-primary-600 mb-2">500+</div>
                        <div class="text-lg font-semibold text-gray-900 mb-1">Happy Customers</div>
                        <div class="text-gray-600">Families we serve regularly</div>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="bg-white rounded-xl p-8 shadow-md">
                        <div class="text-4xl font-bold text-primary-600 mb-2">1000+</div>
                        <div class="text-lg font-semibold text-gray-900 mb-1">Products</div>
                        <div class="text-gray-600">Quality items in our inventory</div>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="bg-white rounded-xl p-8 shadow-md">
                        <div class="text-4xl font-bold text-primary-600 mb-2">5+</div>
                        <div class="text-lg font-semibold text-gray-900 mb-1">Years</div>
                        <div class="text-gray-600">Serving the community</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-primary-600 py-16">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Shop?</h2>
            <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
                Browse our selection of fresh products and place your order today. 
                Experience the convenience of shopping with Mini Market.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.list') }}" 
                   class="bg-white text-primary-600 px-8 py-3 rounded-xl font-semibold hover:bg-gray-100 transition duration-200 shadow-lg">
                    Browse Products
                </a>
                <a href="{{ route('contact') }}" 
                   class="bg-primary-700 text-white px-8 py-3 rounded-xl font-semibold hover:bg-primary-800 transition duration-200 border-2 border-primary-400">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
