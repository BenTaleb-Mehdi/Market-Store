<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function createPaymentIntent(Request $request)
    {
        try {
            $cart = session('cart', []);
            
            if (empty($cart)) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }

            // Calculate total from cart
            $total = 0;
            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product) {
                    $total += $product->price * $quantity;
                }
            }

            $paymentIntent = PaymentIntent::create([
                'amount' => $total * 100, // Stripe expects cents
                'currency' => 'usd',
                'metadata' => [
                    'user_id' => Auth::id(),
                    'cart_items' => json_encode($cart)
                ]
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'amount' => $total
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function confirmPayment(Request $request)
    {
        $validated = $request->validate([
            'payment_intent_id' => 'required|string',
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            // Retrieve the payment intent from Stripe
            $paymentIntent = PaymentIntent::retrieve($validated['payment_intent_id']);
            
            if ($paymentIntent->status !== 'succeeded') {
                return response()->json(['error' => 'Payment not completed'], 400);
            }

            $cart = json_decode($paymentIntent->metadata->cart_items, true);
            $userId = $paymentIntent->metadata->user_id;

            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => $userId,
                'total_amount' => $paymentIntent->amount / 100, // Convert from cents
                'payment_type' => 'card',
                'payment_status' => 'paid',
            ]);

            // Create order items and update stock
            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product && $product->stock >= $quantity) {
                    $order->orderItems()->create([
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);
                    
                    $product->decrement('stock', $quantity);
                }
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function codOrder(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 400);
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
                'payment_type' => 'cod',
                'payment_status' => 'pending',
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
