<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Models\Message;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Authentication methods
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Check if the authenticated user is an admin
            if (!Auth::user()->isAdmin()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Access denied. Admin privileges required.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back to the admin dashboard!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('products.index')
            ->with('success', 'You have been logged out successfully.');
    }

    // Dashboard
    public function dashboard()
    {
        // Set default currency to MAD if not set
        if (!Setting::get('currency')) {
            Setting::set('currency', 'MAD', 'string', 'general', 'Currency', 'Default currency for the application');
        }
        $stats = [
            'total_products' => Product::count(),
            'in_stock_products' => Product::where('stock', '>', 0)->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('payment_status', 'pending')->count(),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'failed_orders' => Order::where('payment_status', 'failed')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'low_stock_products' => Product::where('stock', '<=', 5)->count(),
        ];

        $recent_orders = Order::with(['user', 'orderItems.product' => function($query) {
                $query->withTrashed(); // Include soft-deleted products
            }])
            ->latest()
            ->limit(5)
            ->get();

        $low_stock_products = Product::where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'low_stock_products'));
    }

    // Product management
    public function products(Request $request)
    {
        $showDeleted = $request->get('show_deleted', false);
        $search = $request->get('search');
        $category = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $availability = $request->get('availability');
        
        $query = $showDeleted ? Product::withTrashed() : Product::query();
        
        // Apply search filter
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        // Apply category filter
        if ($category) {
            $query->where('category', $category);
        }
        
        // Apply price range filter
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        
        // Apply availability filter
        if ($availability === 'in_stock') {
            $query->where('stock', '>', 0);
        } elseif ($availability === 'out_of_stock') {
            $query->where('stock', '=', 0);
        }
        
        $products = $query->latest()->paginate(10);
        
        // Get unique categories for filter dropdown
        $categories = Product::select('category')->distinct()->pluck('category');
        
        return view('admin.products.index', compact('products', 'showDeleted', 'categories', 'search', 'category', 'minPrice', 'maxPrice', 'availability'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle checkbox - if not checked, it won't be in the request
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function editProduct($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle checkbox - if not checked, it won't be in the request
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', "✅ Product '{$product->name}' updated successfully! Stock set to {$validated['stock']} units");
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "🗑️ Product '{$product->name}' deleted successfully! (Can be restored from 'Show deleted products')");
    }

    public function restoreProduct($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product restored successfully!');
    }

    // Simple method to add stock only
    public function addStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'add_quantity' => 'required|integer|min:1|max:1000',
        ]);

        $oldStock = $product->stock;
        $newStock = $oldStock + $validated['add_quantity'];
        
        $product->update(['stock' => $newStock]);

        return redirect()->route('admin.products.index')
            ->with('success', "✅ Added {$validated['add_quantity']} units to '{$product->name}'. Stock: {$oldStock} → {$newStock} units");
    }


    // Order management
    public function orders(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        
        $query = Order::with(['user', 'orderItems.product' => function($query) {
            $query->withTrashed(); // Include soft-deleted products
        }]);
        
        // Apply search filter (order ID or customer name)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                               ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Apply status filter
        if ($status) {
            $query->where('payment_status', $status);
        }
        
        // Apply date range filter
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        
        $orders = $query->latest()->paginate(15);
        
        return view('admin.orders.index', compact('orders', 'search', 'status', 'dateFrom', 'dateTo'));
    }

    public function updateOrder(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status updated successfully!');
    }

    public function destroyOrder(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully!');
    }

    // Settings management
    public function settings()
    {
        $settings = Setting::getAllGrouped();
        
        // Initialize default settings if they don't exist
        $this->initializeDefaultSettings();
        
        // Refresh settings after initialization
        $settings = Setting::getAllGrouped();
        
        return view('admin.settings.index', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'nullable|array',
            'settings.*' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'admin_email' => 'nullable|email|unique:users,email,' . Auth::id(),
            'admin_name' => 'nullable|string|max:255',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
            'new_password_confirmation' => 'nullable|string',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            
            // Delete old logo if exists
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            // Update logo setting
            Setting::set('site_logo', $logoPath, 'string', 'general', 'Site Logo', 'Logo image for the website');
        }

        // Handle admin account updates
        $admin = Auth::user();
        $accountUpdated = false;
        
        if ($request->filled('admin_email') && $request->admin_email !== $admin->email) {
            $admin->update(['email' => $request->admin_email]);
            $accountUpdated = true;
        }
        
        if ($request->filled('admin_name') && $request->admin_name !== $admin->name) {
            $admin->update(['name' => $request->admin_name]);
            $accountUpdated = true;
        }

        // Handle password change
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return redirect()->route('admin.settings')
                    ->with('error', 'Current password is incorrect!');
            }
            
            $admin->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            return redirect()->route('admin.settings')
                ->with('success', 'Password updated successfully!');
        }

        // Handle regular settings
        if (isset($validated['settings'])) {
            foreach ($validated['settings'] as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                
                if ($setting) {
                    // Handle boolean values
                    if ($setting->type === 'boolean') {
                        $value = $request->has("settings.{$key}") ? '1' : '0';
                    }
                    
                    $setting->update(['value' => $value]);
                    
                    // Clear cache
                    \Illuminate\Support\Facades\Cache::forget("setting_{$key}");
                }
            }
        }

        // Determine success message
        $message = 'Settings updated successfully!';
        if ($accountUpdated) {
            $message = 'Account information and settings updated successfully!';
        }

        return redirect()->route('admin.settings')
            ->with('success', $message);
    }

    private function initializeDefaultSettings()
    {
        $defaultSettings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Mini Market',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'The name of your store'
            ],
            [
                'key' => 'site_description',
                'value' => 'Your friendly neighborhood mini market',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'A brief description of your store'
            ],
            [
                'key' => 'contact_email',
                'value' => 'admin@minimarket.com',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Contact Email',
                'description' => 'Main contact email address'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Contact Phone',
                'description' => 'Main contact phone number'
            ],
            [
                'key' => 'site_logo',
                'value' => '',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Logo',
                'description' => 'Logo image for the website'
            ],
            
            // Store Settings
            [
                'key' => 'store_address',
                'value' => '123 Main Street, City, State 12345',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Store Address',
                'description' => 'Physical store address'
            ],
            [
                'key' => 'store_hours',
                'value' => 'Mon-Fri: 9AM-8PM, Sat-Sun: 10AM-6PM',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Store Hours',
                'description' => 'Store operating hours'
            ],
            [
                'key' => 'low_stock_threshold',
                'value' => '5',
                'type' => 'integer',
                'group' => 'store',
                'label' => 'Low Stock Threshold',
                'description' => 'Alert when product stock falls below this number'
            ],
            [
                'key' => 'enable_reservations',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'store',
                'label' => 'Enable Reservations',
                'description' => 'Allow customers to make product reservations'
            ],
            
            // Payment Settings
            [
                'key' => 'enable_stripe',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'payment',
                'label' => 'Enable Stripe Payments',
                'description' => 'Accept credit card payments via Stripe'
            ],
            [
                'key' => 'enable_cod',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'payment',
                'label' => 'Enable Cash on Delivery',
                'description' => 'Accept cash payments on delivery'
            ],
            [
                'key' => 'currency',
                'value' => 'USD',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Currency',
                'description' => 'Default currency for prices'
            ],
            [
                'key' => 'tax_rate',
                'value' => '0.08',
                'type' => 'float',
                'group' => 'payment',
                'label' => 'Tax Rate',
                'description' => 'Tax rate as decimal (0.08 = 8%)'
            ],
            
            // Notification Settings
            [
                'key' => 'email_notifications',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notification',
                'label' => 'Email Notifications',
                'description' => 'Send email notifications for orders'
            ],
            [
                'key' => 'low_stock_alerts',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notification',
                'label' => 'Low Stock Alerts',
                'description' => 'Send alerts when products are low in stock'
            ],
            [
                'key' => 'new_order_alerts',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notification',
                'label' => 'New Order Alerts',
                'description' => 'Send alerts for new orders and reservations'
            ],
        ];

        foreach ($defaultSettings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    // Message/Inbox Management
    public function messages()
    {
        $messages = Message::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    public function showMessage(Message $message)
    {
        // Mark as read if it was unread
        if ($message->status === 'unread') {
            $message->markAsRead();
        }

        return view('admin.messages.show', compact('message'));
    }

    public function replyToMessage(Request $request, Message $message)
    {
        $request->validate([
            'reply' => 'required|string|max:2000'
        ]);

        $message->markAsReplied($request->reply);

        // Send email notification to user if they have an email
        try {
            \Mail::raw($request->reply, function ($mail) use ($message) {
                $mail->to($message->email)
                     ->subject('Reply to your message - Mini Market')
                     ->from(config('mail.from.address'), config('mail.from.name'));
            });
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send reply email: ' . $e->getMessage());
        }

        return back()->with('success', 'Reply sent successfully!');
    }

    public function deleteMessage(Message $message)
    {
        $message->delete();
        return back()->with('success', 'Message deleted successfully!');
    }

    // Contact Messages Management
    public function contactMessages(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $query = ContactMessage::query();

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('subject', 'like', '%' . $search . '%');
            });
        }

        // Apply status filter
        if ($status) {
            $query->where('status', $status);
        }

        $messages = $query->latest()->paginate(15);

        // Get counts for stats
        $totalMessages = ContactMessage::count();
        $unreadMessages = ContactMessage::unread()->count();
        $repliedMessages = ContactMessage::replied()->count();

        return view('admin.contact-messages.index', compact(
            'messages', 
            'search', 
            'status', 
            'totalMessages', 
            'unreadMessages', 
            'repliedMessages'
        ));
    }

    public function showContactMessage(ContactMessage $contactMessage)
    {
        // Mark as read if it's unread
        if ($contactMessage->status === 'unread') {
            $contactMessage->markAsRead();
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function replyContactMessage(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'reply' => 'required|string|max:2000',
        ]);

        $contactMessage->markAsReplied($request->reply);

        return redirect()->route('admin.contact-messages.show', $contactMessage)
                        ->with('success', 'Reply sent successfully!');
    }

    public function deleteContactMessage(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')
                        ->with('success', 'Contact message deleted successfully!');
    }
}
