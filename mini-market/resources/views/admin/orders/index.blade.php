@extends('admin.layouts.app')

@section('title', 'Orders Management - Admin Dashboard')
@section('page-title', 'Orders Management')
@section('page-description', 'Manage customer orders and purchases')

@section('content')
<div class="space-y-6">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending Payment</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $orders->where('payment_status', 'pending')->count() }}</p>
                </div>
                <div class="bg-yellow-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Paid</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $orders->where('payment_status', 'paid')->count() }}</p>
                </div>
                <div class="bg-green-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Failed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $orders->where('payment_status', 'failed')->count() }}</p>
                </div>
                <div class="bg-red-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $orders->total() }}</p>
                </div>
                <div class="bg-blue-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4" id="ordersFilterForm">
            <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                <!-- Search Bar -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Orders</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ $search ?? '' }}"
                           placeholder="Search by order ID or customer name..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <!-- Status Filter -->
                <div class="w-full lg:w-48">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" 
                            name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ ($status ?? '') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ ($status ?? '') === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                
                <!-- Date From -->
                <div class="w-full lg:w-48">
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                    <input type="date" 
                           id="date_from" 
                           name="date_from" 
                           value="{{ $dateFrom ?? '' }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <!-- Date To -->
                <div class="w-full lg:w-48">
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                    <input type="date" 
                           id="date_to" 
                           name="date_to" 
                           value="{{ $dateTo ?? '' }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button type="submit" 
                            class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h3 class="text-lg lg:text-xl font-semibold text-gray-900">
                    @if($search || $status || $dateFrom || $dateTo)
                        Filtered Orders
                    @else
                        All Orders
                    @endif
                </h3>
                <p class="text-sm text-gray-600">{{ $orders->total() }} total orders</p>
            </div>
        </div>

        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="hidden sm:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                            <th class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                            <th class="hidden xl:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                                        <!-- Mobile info -->
                                        <div class="sm:hidden text-xs text-gray-500 mt-1 space-y-1">
                                            <div>{{ $order->user->name ?? 'Guest' }}</div>
                                            <div class="flex items-center space-x-2">
                                                <span class="font-medium">{{ App\Models\Setting::formatPrice($order->total_amount) }}</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                    @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                                    @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </div>
                                            <div>{{ $order->created_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                                        @if($order->user)
                                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @foreach($order->orderItems->take(2) as $item)
                                            <div class="flex items-center space-x-2 mb-1">
                                                @if($item->product)
                                                    <span class="truncate max-w-32">{{ $item->product->name }}</span>
                                                @else
                                                    <span class="text-red-500">Product Deleted</span>
                                                @endif
                                                <span class="text-gray-500">x{{ $item->quantity }}</span>
                                            </div>
                                        @endforeach
                                        @if($order->orderItems->count() > 2)
                                            <div class="text-xs text-gray-500">+{{ $order->orderItems->count() - 2 }} more</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ App\Models\Setting::formatPrice($order->total_amount) }}</div>
                                    <div class="text-sm text-gray-500">
                                        @if($order->payment_type === 'cod')
                                            Cash on Delivery
                                        @else
                                            Card Payment
                                        @endif
                                    </div>
                                </td>
                                <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                        @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="hidden xl:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                    <div class="text-xs text-gray-400">{{ $order->created_at->format('g:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- Update Payment Status -->
                                        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="payment_status" onchange="this.form.submit()" 
                                                    class="text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-primary-500">
                                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                            </select>
                                        </form>
                                        
                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition duration-200" title="Delete Order">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Orders Found</h3>
                <p class="text-gray-600">No customer orders have been placed yet.</p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('ordersFilterForm');
    const searchInput = document.getElementById('search');
    const statusSelect = document.getElementById('status');
    const dateFromInput = document.getElementById('date_from');
    const dateToInput = document.getElementById('date_to');
    
    let searchTimeout;
    
    // Function to perform AJAX search
    function performSearch() {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        
        // Update URL without page reload
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        history.pushState(null, '', newUrl);
        
        // Show loading state
        const tableContainer = document.querySelector('.overflow-x-auto');
        if (tableContainer) {
            tableContainer.style.opacity = '0.6';
            tableContainer.style.pointerEvents = 'none';
        }
        
        // Perform AJAX request
        fetch(newUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Parse the response and update the table
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.querySelector('.bg-white.rounded-lg.shadow-md.overflow-hidden');
            const currentTable = document.querySelector('.bg-white.rounded-lg.shadow-md.overflow-hidden');
            
            if (newTable && currentTable) {
                currentTable.innerHTML = newTable.innerHTML;
            }
            
            // Update stats cards
            const newStats = doc.querySelectorAll('.grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-4.gap-4 .bg-white');
            const currentStats = document.querySelectorAll('.grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-4.gap-4 .bg-white');
            
            newStats.forEach((newStat, index) => {
                if (currentStats[index]) {
                    currentStats[index].innerHTML = newStat.innerHTML;
                }
            });
        })
        .catch(error => {
            console.error('Search error:', error);
        })
        .finally(() => {
            // Remove loading state
            if (tableContainer) {
                tableContainer.style.opacity = '1';
                tableContainer.style.pointerEvents = 'auto';
            }
        });
    }
    
    // Real-time search on input
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 500); // Debounce for 500ms
    });
    
    // Immediate search on select changes
    statusSelect.addEventListener('change', performSearch);
    dateFromInput.addEventListener('change', performSearch);
    dateToInput.addEventListener('change', performSearch);
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch();
    });
});
</script>
@endsection
