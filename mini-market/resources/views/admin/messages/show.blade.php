@extends('admin.layouts.app')

@section('content')
<div class="p-4 lg:p-6 xl:p-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl xl:text-3xl font-bold text-gray-900 mb-2">Message Details</h1>
                <p class="text-gray-600">View and reply to customer message</p>
            </div>
            <a href="{{ route('admin.messages.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Messages
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Message Details -->
        <div class="lg:col-span-2">
            <!-- Message Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <!-- Message Header -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ substr($message->name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $message->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $message->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $message->status_color }}">
                                {{ ucfirst($message->status) }}
                            </span>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $message->created_at->format('M d, Y \a\t g:i A') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Original Message -->
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Customer Message:</h4>
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                    </div>

                    <!-- Admin Reply -->
                    @if($message->reply)
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Your Reply:</h4>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg mb-6">
                            <p class="text-blue-700 whitespace-pre-wrap">{{ $message->reply }}</p>
                            <p class="text-xs text-blue-600 mt-2">
                                Replied on {{ $message->updated_at->format('F d, Y \a\t g:i A') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reply Form -->
            @if(!$message->reply)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Send Reply</h3>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.messages.reply', $message) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="reply" class="block text-sm font-medium text-gray-700 mb-2">
                                    Your Reply
                                </label>
                                <textarea id="reply" 
                                          name="reply" 
                                          rows="6" 
                                          required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('reply') border-red-500 @enderror"
                                          placeholder="Type your reply here...">{{ old('reply') }}</textarea>
                                @error('reply')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-500">
                                    This reply will be sent to {{ $message->email }}
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
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Message Info -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Message Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $message->status_color }}">
                                {{ ucfirst($message->status) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Received</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $message->created_at->format('F d, Y') }}</dd>
                        <dd class="text-xs text-gray-500">{{ $message->created_at->format('g:i A') }}</dd>
                    </div>
                    @if($message->reply)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Replied</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $message->updated_at->format('F d, Y') }}</dd>
                            <dd class="text-xs text-gray-500">{{ $message->updated_at->format('g:i A') }}</dd>
                        </div>
                    @endif
                    @if($message->user)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">User Account</dt>
                            <dd class="mt-1 text-sm text-gray-900">Registered User</dd>
                        </div>
                    @else
                        <div>
                            <dt class="text-sm font-medium text-gray-500">User Account</dt>
                            <dd class="mt-1 text-sm text-gray-900">Guest</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-3">
                    @if($message->reply)
                        <div class="flex items-center text-sm text-green-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Reply sent successfully
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.messages.delete', $message) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this message? This action cannot be undone.')" 
                          class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
