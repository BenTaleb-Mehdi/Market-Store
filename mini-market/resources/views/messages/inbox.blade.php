@extends('layouts.main')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-10 md:py-16">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Messages</h1>
            <p class="text-gray-600">View your messages and replies from our team</p>
        </div>

        @if($messages->count() > 0)
            <!-- Messages List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="divide-y divide-gray-200">
                    @foreach($messages as $message)
                        <div class="p-6 hover:bg-gray-50 transition duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Message from {{ $message->created_at->format('M d, Y') }}
                                        </h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $message->status_color }}">
                                            {{ ucfirst($message->status) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-600 mb-3 line-clamp-2">
                                        {{ Str::limit($message->message, 150) }}
                                    </p>
                                    
                                    @if($message->reply)
                                        <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-3">
                                            <p class="text-sm text-blue-800">
                                                <strong>Admin Reply:</strong> {{ Str::limit($message->reply, 100) }}
                                            </p>
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                
                                <div class="ml-4">
                                    <a href="{{ route('messages.show', $message) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $messages->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No messages</h3>
                <p class="mt-1 text-sm text-gray-500">You haven't sent any messages yet.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}#contact" 
                       class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Send a Message
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
