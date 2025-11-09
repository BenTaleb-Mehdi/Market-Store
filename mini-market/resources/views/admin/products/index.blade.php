@extends('admin.layouts.app')

@section('title', 'Products Management - Admin Dashboard')
@section('page-title', 'Products Management')
@section('page-description', 'Manage your product inventory and pricing')

@section('content')
<div class="space-y-6">
    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="space-y-4" id="productsFilterForm">
            <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                <!-- Search Bar -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ $search ?? '' }}"
                           placeholder="Search by product name..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <!-- Category Filter -->
                <div class="w-full lg:w-48">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="category" 
                            name="category" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ ($category ?? '') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Price Range -->
                <div class="w-full lg:w-32">
                    <label for="min_price" class="block text-sm font-medium text-gray-700 mb-2">Min Price</label>
                    <input type="number" 
                           id="min_price" 
                           name="min_price" 
                           value="{{ $minPrice ?? '' }}"
                           placeholder="0"
                           step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <div class="w-full lg:w-32">
                    <label for="max_price" class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                    <input type="number" 
                           id="max_price" 
                           name="max_price" 
                           value="{{ $maxPrice ?? '' }}"
                           placeholder="999"
                           step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <!-- Availability Filter -->
                <div class="w-full lg:w-48">
                    <label for="availability" class="block text-sm font-medium text-gray-700 mb-2">Availability</label>
                    <select id="availability" 
                            name="availability" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">All Products</option>
                        <option value="in_stock" {{ ($availability ?? '') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="out_of_stock" {{ ($availability ?? '') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
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
                    <a href="{{ route('admin.products.index') }}" 
                       class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </a>
                </div>
            </div>
            
            <!-- Hidden field to preserve show_deleted state -->
            @if($showDeleted)
                <input type="hidden" name="show_deleted" value="1">
            @endif
        </form>
    </div>

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h3 class="text-lg lg:text-xl font-semibold text-gray-900">
                @if($search || $category || $minPrice || $maxPrice || $availability)
                    Filtered Products
                @else
                    {{ $showDeleted ? 'All Products (Including Deleted)' : 'Active Products' }}
                @endif
            </h3>
            <p class="text-sm text-gray-600">{{ $products->total() }} total products</p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
            <div class="flex items-center">
                <label class="inline-flex items-center">
                    <input type="checkbox" 
                           class="form-checkbox h-4 w-4 text-primary-600" 
                           {{ $showDeleted ? 'checked' : '' }}
                           onchange="toggleDeletedProducts(this.checked)">
                    <span class="ml-2 text-sm text-gray-700">Show deleted products</span>
                </label>
            </div>
            <a href="{{ route('admin.products.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition duration-200 flex items-center justify-center w-full sm:w-auto">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="hidden sm:inline">Add New Product</span>
                <span class="sm:hidden">Add Product</span>
            </a>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="hidden sm:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="hidden xl:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50 {{ $product->trashed() ? 'bg-red-50' : '' }}">
                                <td class="px-3 sm:px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 sm:h-12 sm:w-12">
                                            @if($product->image)
                                                <img class="h-10 w-10 sm:h-12 sm:w-12 rounded-lg object-cover {{ $product->trashed() ? 'opacity-50' : '' }}" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                            @else
                                                <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-lg bg-gray-200 flex items-center justify-center {{ $product->trashed() ? 'opacity-50' : '' }}">
                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                                            <div class="text-sm font-medium {{ $product->trashed() ? 'text-gray-500 line-through' : 'text-gray-900' }} truncate">
                                                {{ $product->name }}
                                                @if($product->trashed())
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Deleted
                                                    </span>
                                                @endif
                                            </div>
                                            <!-- Mobile info -->
                                            <div class="sm:hidden text-xs text-gray-500 mt-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="font-medium">${{ number_format($product->price, 2) }}</span>
                                                    <span>•</span>
                                                    <span class="{{ $product->stock == 0 ? 'text-red-600' : ($product->stock <= 5 ? 'text-orange-600' : 'text-gray-500') }}">
                                                        {{ $product->stock }} units
                                                    </span>
                                                </div>
                                            </div>
                                            @if($product->description)
                                                <div class="hidden sm:block text-sm text-gray-500 truncate">{{ Str::limit($product->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</div>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <span class="font-medium {{ $product->stock == 0 ? 'text-red-600' : ($product->stock <= 5 ? 'text-orange-600' : 'text-gray-900') }}">
                                            {{ $product->stock }}
                                        </span>
                                        units
                                        @if($product->stock == 0)
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Out of Stock
                                            </span>
                                        @elseif($product->stock <= 5)
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                Low Stock
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col space-y-1">
                                        @if($product->trashed())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Deleted
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="hidden xl:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $product->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        @if($product->trashed())
                                            <!-- Edit Button for deleted products -->
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900 transition duration-200" title="Edit Product">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <!-- Restore Button -->
                                            <form method="POST" action="{{ route('admin.products.restore', $product->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to restore this product?')">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 transition duration-200" title="Restore Product">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-primary-600 hover:text-primary-900 transition duration-200" title="Edit Product">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <!-- Quick Add Stock Button -->
                                            <button onclick="openAddStockModal('{{ $product->id }}', '{{ $product->name }}', {{ $product->stock }})" class="text-green-600 hover:text-green-900 transition duration-200" title="Add Stock">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </button>
                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition duration-200" title="Delete Product">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                <p class="mt-2 text-gray-500">Get started by adding your first product to the inventory.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.products.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition duration-200 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Your First Product
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Add Stock Modal -->
    <div id="addStockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add Stock</h3>
                <form id="addStockForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                        <p id="modalProductName" class="text-sm text-gray-600 bg-gray-50 p-2 rounded"></p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Stock</label>
                        <p id="modalCurrentStock" class="text-sm text-gray-600 bg-gray-50 p-2 rounded"></p>
                    </div>
                    <div class="mb-4">
                        <label for="add_quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity to Add</label>
                        <input type="number" id="add_quantity" name="add_quantity" min="1" max="1000" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" 
                               placeholder="Enter quantity to add" required>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeAddStockModal()" 
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Add Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openAddStockModal(productId, productName, currentStock) {
    document.getElementById('modalProductName').textContent = productName;
    document.getElementById('modalCurrentStock').textContent = currentStock + ' units';
    document.getElementById('addStockForm').action = `/admin/products/${productId}/add-stock`;
    document.getElementById('add_quantity').value = '';
    document.getElementById('addStockModal').classList.remove('hidden');
}

function closeAddStockModal() {
    document.getElementById('addStockModal').classList.add('hidden');
}

function toggleDeletedProducts(checked) {
    const currentUrl = new URL(window.location);
    if (checked) {
        currentUrl.searchParams.set('show_deleted', '1');
    } else {
        currentUrl.searchParams.delete('show_deleted');
    }
    window.location.href = currentUrl.toString();
}

// Close modal when clicking outside
document.getElementById('addStockModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddStockModal();
    }
});

// AJAX Search and Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productsFilterForm');
    const searchInput = document.getElementById('search');
    const categorySelect = document.getElementById('category');
    const minPriceInput = document.getElementById('min_price');
    const maxPriceInput = document.getElementById('max_price');
    const availabilitySelect = document.getElementById('availability');
    
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
            
            // Update header info
            const newHeader = doc.querySelector('.flex.flex-col.sm\\:flex-row.sm\\:justify-between.sm\\:items-center.gap-4');
            const currentHeader = document.querySelector('.flex.flex-col.sm\\:flex-row.sm\\:justify-between.sm\\:items-center.gap-4');
            
            if (newHeader && currentHeader) {
                currentHeader.innerHTML = newHeader.innerHTML;
                
                // Re-attach event listener for the show deleted checkbox
                const deletedCheckbox = currentHeader.querySelector('input[type="checkbox"]');
                if (deletedCheckbox) {
                    deletedCheckbox.addEventListener('change', function() {
                        toggleDeletedProducts(this.checked);
                    });
                }
            }
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
    
    // Immediate search on select/input changes
    categorySelect.addEventListener('change', performSearch);
    availabilitySelect.addEventListener('change', performSearch);
    
    // Debounced search for price inputs
    minPriceInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 800);
    });
    
    maxPriceInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 800);
    });
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch();
    });
});
</script>
@endsection
