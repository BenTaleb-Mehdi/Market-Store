@extends('admin.layouts.app')

@section('content')
<div class="p-4 lg:p-6 xl:p-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl xl:text-3xl font-bold text-gray-900 mb-2">Messages</h1>
        <p class="text-gray-600">Manage customer messages and inquiries</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $messages->where('status', 'unread')->count() }}</p>
                    <p class="text-sm text-gray-600">Unread</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $messages->where('status', 'read')->count() }}</p>
                    <p class="text-sm text-gray-600">Read</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $messages->where('status', 'replied')->count() }}</p>
                    <p class="text-sm text-gray-600">Replied</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $messages->count() }}</p>
                    <p class="text-sm text-gray-600">Total</p>
                </div>
            </div>
        </div>
    </div>

    @if($messages->count() > 0)
        <!-- Messages Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sender
                            </th>
                            <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Message
                            </th>
                            <th class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="hidden xl:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($messages as $message)
                            <tr class="hover:bg-gray-50 {{ $message->status === 'unread' ? 'bg-blue-50' : '' }}">
                                <td class="px-3 sm:px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                            <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-xs sm:text-sm font-medium text-gray-700">
                                                    {{ substr($message->name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                                            <div class="text-sm font-medium text-gray-900 truncate">{{ $message->name }}</div>
                                            <div class="text-xs sm:text-sm text-gray-500 truncate">{{ $message->email }}</div>
                                            <!-- Mobile info -->
                                            <div class="md:hidden text-xs text-gray-500 mt-1 space-y-1">
                                                <div class="truncate">{{ Str::limit($message->message, 60) }}</div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $message->status_color }}">
                                                        {{ ucfirst($message->status) }}
                                                    </span>
                                                    <span>{{ $message->created_at->format('M d') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ Str::limit($message->message, 80) }}
                                    </div>
                                </td>
                                <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $message->status_color }}">
                                        {{ ucfirst($message->status) }}
                                    </span>
                                </td>
                                <td class="hidden xl:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $message->created_at->format('M d, Y') }}
                                    <br>
                                    <span class="text-xs text-gray-400">{{ $message->created_at->format('g:i A') }}</span>
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.messages.show', $message) }}" 
                                           class="text-primary-600 hover:text-primary-900 bg-primary-100 hover:bg-primary-200 px-3 py-1 rounded-lg transition duration-200">
                                            View
                                        </a>
                                        <form method="POST" action="{{ route('admin.messages.delete', $message) }}" 
                                              onsubmit="return confirm('Are you sure you want to delete this message?')" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1 rounded-lg transition duration-200">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $messages->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No messages</h3>
            <p class="mt-1 text-sm text-gray-500">No customer messages have been received yet.</p>
        </div>
    @endif
</div>
@endsection
