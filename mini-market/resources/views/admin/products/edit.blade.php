@extends('admin.layouts.app')

@section('title', 'Edit Product - Admin Dashboard')
@section('page-title', 'Edit Product')
@section('page-description', 'Update product information and inventory')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Edit: {{ $product->name }}</h3>
                <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
            @if($product->trashed())
                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <p class="text-sm text-red-700">
                            <strong>Warning:</strong> This product is currently deleted. You can edit it and then restore it, or restore it first from the products list.
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div class="lg:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $product->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror"
                           placeholder="Enter product name"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Price ($) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="{{ old('price', $product->price) }}"
                           step="0.01"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('price') border-red-500 @enderror"
                           placeholder="0.00"
                           required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <div class="mb-2 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm text-blue-800">
                            <strong>Current Stock:</strong> {{ $product->stock }} units
                        </p>
                        <p class="text-xs text-blue-600 mt-1">
                            💡 Tip: Use the green "+" button in the products list for quick stock additions
                        </p>
                    </div>
                    <input type="number" 
                           id="stock" 
                           name="stock" 
                           value="{{ old('stock', $product->stock) }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('stock') border-red-500 @enderror"
                           placeholder="Enter new stock quantity"
                           required>
                    <p class="mt-1 text-sm text-gray-500">
                        This will set the total stock quantity (not add to existing stock)
                    </p>
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select id="category" 
                            name="category" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('category') border-red-500 @enderror"
                            required>
                        <option value="">Select Category</option>
                        <option value="fruits" {{ old('category', $product->category) === 'fruits' ? 'selected' : '' }}>Fruits</option>
                        <option value="vegetables" {{ old('category', $product->category) === 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                        <option value="dairy" {{ old('category', $product->category) === 'dairy' ? 'selected' : '' }}>Dairy</option>
                        <option value="bakery" {{ old('category', $product->category) === 'bakery' ? 'selected' : '' }}>Bakery</option>
                        <option value="beverages" {{ old('category', $product->category) === 'beverages' ? 'selected' : '' }}>Beverages</option>
                        <option value="snacks" {{ old('category', $product->category) === 'snacks' ? 'selected' : '' }}>Snacks</option>
                        <option value="general" {{ old('category', $product->category) === 'general' ? 'selected' : '' }}>General</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="lg:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                              placeholder="Enter product description...">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Image -->
                @if($product->image)
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                        <div class="flex items-center space-x-4">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-20 w-20 object-cover rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Current product image</p>
                                <p class="text-xs text-gray-500">Upload a new image to replace this one</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Product Image -->
                <div class="lg:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $product->image ? 'Replace Image' : 'Product Image' }}
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Upload a file</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Status -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Product Status
                    </label>
                    <div class="p-4 bg-gray-50 rounded-lg border">
                        <div class="flex items-start">
                            <input id="is_active" 
                                   name="is_active" 
                                   type="checkbox" 
                                   value="1"
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded mt-1">
                            <div class="ml-3">
                                <label for="is_active" class="block text-sm font-medium text-gray-900">
                                    Product is active and available for purchase
                                </label>
                                <p class="text-sm text-gray-600 mt-1">
                                    When checked, customers can view and purchase this product. When unchecked, the product is hidden from customers but remains in your inventory for restocking.
                                </p>
                            </div>
                        </div>
                    </div>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-gray-200">
                <!-- Update Actions (Primary) -->
                <div class="flex items-center justify-end space-x-4 mb-4">
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium">
                        Cancel
                    </a>
                    <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition duration-200 font-semibold flex items-center shadow-md" onclick="return confirm('Save changes to this product?\n\nThis will UPDATE the product information and stock. The product will NOT be deleted.')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Changes
                    </button>
                </div>

            </div>
        </form>

        <!-- Danger Zone - OUTSIDE the main form -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h4 class="text-sm font-medium text-red-800 mb-2">Danger Zone</h4>
                <p class="text-sm text-red-600 mb-3">
                    Permanently delete this product. This action cannot be undone and will remove the product from your inventory.
                </p>
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('⚠️ WARNING: This will permanently delete the product &quot;{{ $product->name }}&quot; from your inventory.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure you want to delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200 font-medium flex items-center text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Permanently Delete Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create preview image
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = 'mt-4 h-32 w-32 object-cover rounded-lg mx-auto';
                
                // Remove existing preview
                const existingPreview = document.querySelector('.image-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }
                
                // Add new preview
                const container = document.createElement('div');
                container.className = 'image-preview';
                container.appendChild(preview);
                
                const uploadArea = document.querySelector('.border-dashed').parentNode;
                uploadArea.appendChild(container);
            };
            reader.readAsDataURL(file);
        }
    });

</script>
@endsection
