@extends('layouts.main')

@section('title', 'Contact Us - Mini Market')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16 md:py-24">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Contact Us</h1>
                <p class="text-xl md:text-2xl text-primary-100 max-w-3xl mx-auto">
                    Get in touch with us. We're here to help with any questions or concerns.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-16 md:py-24">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
                <!-- Contact Information -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            {{ App\Models\Setting::get('contact_get_in_touch_title', 'Get in Touch') }}
                        </h2>
                        <p class="text-lg text-gray-600 mb-8">
                            {{ App\Models\Setting::get('contact_get_in_touch_description', "We'd love to hear from you! Whether you have questions about our products, need help with an order, or want to provide feedback, we're here to help.") }}
                        </p>
                    </div>

                    <!-- Contact Details -->
                    <div class="space-y-6">
                        @php
                            $storeAddress = App\Models\Setting::get('store_address', '123 Market Street, City, State 12345');
                            $contactPhone = App\Models\Setting::get('contact_phone', '+1 (555) 123-4567');
                            $contactEmail = App\Models\Setting::get('contact_email', 'info@minimarket.com');
                            $storeHours = App\Models\Setting::get('store_hours', 'Mon-Fri: 9AM-8PM, Sat-Sun: 10AM-6PM');
                        @endphp

                        <div class="flex items-start space-x-4">
                            <div class="bg-primary-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Address</h3>
                                <p class="text-gray-600">{{ $storeAddress }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-primary-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Phone</h3>
                                <p class="text-gray-600">{{ $contactPhone }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-primary-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Email</h3>
                                <p class="text-gray-600">{{ $contactEmail }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-primary-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Store Hours</h3>
                                <p class="text-gray-600">{{ $storeHours }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                        <div class="space-y-3">
                            <a href="{{ route('products.list') }}" class="flex items-center text-primary-600 hover:text-primary-700 transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Browse Our Products
                            </a>
                            @auth
                                <a href="{{ route('orders.index') }}" class="flex items-center text-primary-600 hover:text-primary-700 transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    View Your Orders
                                </a>
                                <a href="{{ route('cart.view') }}" class="flex items-center text-primary-600 hover:text-primary-700 transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    View Your Cart
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="flex items-center text-primary-600 hover:text-primary-700 transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Create an Account
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h3>
                    
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       placeholder="Enter your full name"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       placeholder="Enter your email address"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <select id="subject" 
                                    name="subject" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('subject') border-red-500 @enderror">
                                <option value="">Select a subject</option>
                                <option value="General Inquiry" {{ old('subject') === 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Product Question" {{ old('subject') === 'Product Question' ? 'selected' : '' }}>Product Question</option>
                                <option value="Order Support" {{ old('subject') === 'Order Support' ? 'selected' : '' }}>Order Support</option>
                                <option value="Technical Issue" {{ old('subject') === 'Technical Issue' ? 'selected' : '' }}>Technical Issue</option>
                                <option value="Feedback" {{ old('subject') === 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                <option value="Other" {{ old('subject') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="6" 
                                      required
                                      placeholder="Please provide details about your inquiry..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">
                                <span class="text-red-500">*</span> Required fields
                            </p>
                            <button type="submit" 
                                    class="bg-primary-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200 shadow-md hover:shadow-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Quick answers to common questions</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">What are your delivery hours?</h3>
                    <p class="text-gray-600">We offer delivery during our regular store hours. You can place orders online and choose your preferred delivery time during checkout.</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Do you accept returns?</h3>
                    <p class="text-gray-600">Yes, we accept returns for non-perishable items within 7 days of purchase. Please contact us for specific return policies.</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">What payment methods do you accept?</h3>
                    <p class="text-gray-600">We accept all major credit cards, debit cards, and cash on delivery for your convenience.</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">How can I track my order?</h3>
                    <p class="text-gray-600">Once you place an order, you can track its status by logging into your account and viewing your order history.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
