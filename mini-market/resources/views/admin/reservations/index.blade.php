@extends('admin.layouts.app')

@section('title', 'Reservations Management - Admin Dashboard')
@section('page-title', 'Reservations Management')
@section('page-description', 'Manage customer reservations and orders')

@section('content')
<div class="space-y-6">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reservations->where('status', 'pending')->count() }}</p>
                </div>
                <div class="bg-yellow-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Confirmed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reservations->where('status', 'confirmed')->count() }}</p>
                </div>
                <div class="bg-blue-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reservations->where('status', 'completed')->count() }}</p>
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
                    <p class="text-sm font-medium text-gray-600">Cancelled</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reservations->where('status', 'cancelled')->count() }}</p>
                </div>
                <div class="bg-red-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservations Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">All Reservations</h3>
                <p class="text-sm text-gray-600">{{ $reservations->total() }} total reservations</p>
            </div>
        </div>

        @if($reservations->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reservations as $reservation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $reservation->customer_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $reservation->customer_email }}</div>
                                        <div class="text-sm text-gray-500">{{ $reservation->customer_phone }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($reservation->product && $reservation->product->image)
                                                <img class="h-10 w-10 rounded-lg object-cover" src="{{ $reservation->product->image_url }}" alt="{{ $reservation->product->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            @if($reservation->product)
                                                @if($reservation->product->trashed())
                                                    <div class="text-sm font-medium text-orange-600">{{ $reservation->product->name }} (Deleted)</div>
                                                    <div class="text-sm text-gray-500">{{ App\Models\Setting::formatPrice($reservation->product->price) }} each</div>
                                                @else
                                                    <div class="text-sm font-medium text-gray-900">{{ $reservation->product->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ App\Models\Setting::formatPrice($reservation->product->price) }} each</div>
                                                @endif
                                            @else
                                                <div class="text-sm font-medium text-red-600">Product Not Found</div>
                                                <div class="text-sm text-gray-500">Product was removed</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $reservation->quantity }} units</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ App\Models\Setting::formatPrice($reservation->total_price) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($reservation->status === 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($reservation->status === 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $reservation->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs">{{ $reservation->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- Status Update Dropdown -->
                                        <div class="relative inline-block text-left">
                                            <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" onclick="toggleDropdown('dropdown-{{ $reservation->id }}')">
                                                Update Status
                                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <div id="dropdown-{{ $reservation->id }}" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                <div class="py-1">
                                                    @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                                                        @if($status !== $reservation->status)
                                                            <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="block">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="{{ $status }}">
                                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                                                    Mark as {{ ucfirst($status) }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('admin.reservations.destroy', $reservation) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this reservation?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Notes Row (if exists) -->
                            @if($reservation->notes)
                                <tr class="bg-gray-50">
                                    <td colspan="7" class="px-6 py-3">
                                        <div class="text-sm text-gray-600">
                                            <strong>Notes:</strong> {{ $reservation->notes }}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reservations->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $reservations->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No reservations found</h3>
                <p class="mt-2 text-gray-500">Reservations will appear here when customers make bookings.</p>
            </div>
        @endif
    </div>
</div>

<script>
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
        
        // Close all other dropdowns
        allDropdowns.forEach(d => {
            if (d.id !== dropdownId) {
                d.classList.add('hidden');
            }
        });
        
        // Toggle current dropdown
        dropdown.classList.toggle('hidden');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
        const buttons = document.querySelectorAll('button[onclick^="toggleDropdown"]');
        
        let clickedButton = false;
        buttons.forEach(button => {
            if (button.contains(event.target)) {
                clickedButton = true;
            }
        });
        
        if (!clickedButton) {
            dropdowns.forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
        }
    });
</script>
@endsection
