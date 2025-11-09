<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // For now, we'll use session-based cart
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('products.list')->with('error', 'Your cart is empty.');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:stripe,cod',
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('products.list')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();
        
        try {
            $total = 0;
            $orderItems = [];

            // Calculate total and prepare order items
            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product && $product->stock >= $quantity) {
                    $subtotal = $product->price * $quantity;
                    $total += $subtotal;
                    
                    $orderItems[] = [
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ];
                    
                    // Reduce stock
                    $product->decrement('stock', $quantity);
                } else {
                    throw new \Exception("Product {$product->name} is out of stock or insufficient quantity.");
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'payment_type' => $validated['payment_method'],
                'payment_status' => 'pending',
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            // Handle payment method
            if ($validated['payment_method'] === 'stripe') {
                // For demo purposes, we'll simulate Stripe payment
                // In production, integrate with actual Stripe API
                $order->update([
                    'stripe_payment_id' => 'demo_' . uniqid(),
                    'status' => 'confirmed'
                ]);
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('checkout.success', ['order' => $order->id]);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $orderId = $request->query('order');
        $order = Order::where('user_id', Auth::id())->find($orderId);
        
        if (!$order) {
            return redirect()->route('products.list');
        }

        return view('checkout.success', compact('order'));
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }

    // Cart Management Methods
    public function addToCart(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        
        if ($quantity > $product->stock) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = session('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id] += $quantity;
        } else {
            $cart[$product->id] = $quantity;
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function viewCart()
    {
        $cart = session('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function updateCart(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        
        if ($quantity > $product->stock) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = session('cart', []);
        
        if ($quantity > 0) {
            $cart[$product->id] = $quantity;
        } else {
            unset($cart[$product->id]);
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Cart updated successfully!');
    }

    public function removeFromCart(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Product removed from cart!');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared successfully!');
    }
}
