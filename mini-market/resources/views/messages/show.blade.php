@extends('layouts.main')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-10 md:py-16">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Message Details</h1>
                    <p class="text-gray-600">Sent on {{ $message->created_at->format('F d, Y \a\t g:i A') }}</p>
                </div>
                <a href="{{ route('messages.inbox') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Inbox
                </a>
            </div>
        </div>

        <!-- Message Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Message Status -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $message->status_color }}">
                            {{ ucfirst($message->status) }}
                        </span>
                        <span class="text-sm text-gray-500">
                            From: {{ $message->name }} ({{ $message->email }})
                        </span>
                    </div>
                    <span class="text-sm text-gray-500">
                        {{ $message->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            <!-- Original Message -->
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Message:</h3>
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                </div>

                <!-- Admin Reply -->
                @if($message->reply)
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Our Reply:</h3>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-800">Admin Team</p>
                                <p class="text-blue-700 mt-2 whitespace-pre-wrap">{{ $message->reply }}</p>
                                <p class="text-xs text-blue-600 mt-2">
                                    Replied on {{ $message->updated_at->format('F d, Y \a\t g:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Waiting for Reply</strong>
                                </p>
                                <p class="text-yellow-600 mt-1">
                                    We've received your message and will respond as soon as possible.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- User Reply Form -->
        @if($message->reply)
            <div class="bg-white rounded-xl shadow-md overflow-hidden mt-6">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Continue Conversation</h3>
                    <p class="text-sm text-gray-600 mt-1">Reply to the admin's response</p>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <input type="hidden" name="name" value="{{ $message->name }}">
                        <input type="hidden" name="email" value="{{ $message->email }}">
                        
                        <div class="mb-4">
                            <label for="reply_message" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Reply
                            </label>
                            <textarea id="reply_message" 
                                      name="message" 
                                      rows="4" 
                                      required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('message') border-red-500 @enderror"
                                      placeholder="Type your reply here...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">
                                This will create a new message thread
                            </p>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Send Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('products.index') }}#contact" 
               class="inline-flex items-center px-6 py-3 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Send Another Message
            </a>
        </div>
    </div>
</div>
@endsection
