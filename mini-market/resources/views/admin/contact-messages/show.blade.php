@extends('admin.layouts.app')

@section('title', 'Contact Message - Admin Dashboard')
@section('page-title', 'Contact Message Details')
@section('page-description', 'View and reply to customer contact message')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.contact-messages.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Messages
        </a>
        
        <!-- Delete Button -->
        <form action="{{ route('admin.contact-messages.delete', $contactMessage) }}" 
              method="POST" 
              class="inline"
              onsubmit="return confirm('Are you sure you want to delete this message?')">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Delete Message
            </button>
        </form>
    </div>

    <!-- Message Details -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-lg font-medium text-primary-600">
                            {{ strtoupper(substr($contactMessage->name, 0, 2)) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $contactMessage->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $contactMessage->email }}</p>
                    </div>
                </div>
                <div class="text-right">
                    @if($contactMessage->status === 'unread')
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-orange-100 text-orange-800">
                            Unread
                        </span>
                    @elseif($contactMessage->status === 'read')
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            Read
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Replied
                        </span>
                    @endif
                    <p class="text-sm text-gray-500 mt-1">{{ $contactMessage->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="px-6 py-6">
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Subject:</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $contactMessage->subject }}</p>
            </div>
            
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Message:</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $contactMessage->message }}</p>
                </div>
            </div>

            @if($contactMessage->status === 'replied' && $contactMessage->admin_reply)
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Your Reply:</h4>
                    <div class="bg-primary-50 rounded-lg p-4 border-l-4 border-primary-500">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $contactMessage->admin_reply }}</p>
                        <p class="text-sm text-gray-500 mt-2">Replied on {{ $contactMessage->replied_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($contactMessage->status !== 'replied')
        <!-- Reply Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Send Reply</h3>
            
            <form action="{{ route('admin.contact-messages.reply', $contactMessage) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="reply" class="block text-sm font-medium text-gray-700 mb-2">
                        Reply Message <span class="text-red-500">*</span>
                    </label>
                    <textarea id="reply" 
                              name="reply" 
                              rows="6" 
                              required
                              placeholder="Type your reply here..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('reply') border-red-500 @enderror">{{ old('reply') }}</textarea>
                    @error('reply')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        <span class="text-red-500">*</span> This reply will be sent to {{ $contactMessage->email }}
                    </p>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Send Reply
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
