<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class ReservationController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function index()
    {
        $reservations = Reservation::with(['product' => function($query) {
                $query->withTrashed(); // Include soft-deleted products
            }])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        
        return view('reservations.index', compact('reservations'));
    }

    public function create(Product $product)
    {
        // Check if product is active and available
        if (!$product->is_active || $product->trashed() || $product->stock <= 0) {
            return redirect()->route('products.index')
                ->with('error', 'This product is not available for reservation.');
        }
        
        return view('reservations.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        // Check if product is still available
        if (!$product->is_active || $product->trashed() || $product->stock <= 0) {
            return redirect()->route('products.index')
                ->with('error', 'This product is no longer available for reservation.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
            'notes' => 'nullable|string|max:1000',
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
        ]);

        $validated['product_id'] = $product->id;
        $validated['reservation_date'] = now()->addDay();
        $validated['total_price'] = $product->price * $validated['quantity'];
        $validated['status'] = 'pending';
        $validated['payment_status'] = 'pending';
        
        // Add user_id if user is authenticated
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        $reservation = Reservation::create($validated);

        return redirect()->route('reservations.checkout', $reservation)
            ->with('success', 'Reservation created! Please complete payment to confirm.');
    }

    public function checkout(Reservation $reservation)
    {
        if ($reservation->payment_status === 'paid') {
            return redirect()->route('reservations.success', $reservation)
                ->with('info', 'This reservation has already been paid.');
        }

        return view('reservations.checkout', compact('reservation'));
    }

    public function processPayment(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:card,cash',
        ]);

        DB::beginTransaction();
        
        try {
            if ($validated['payment_method'] === 'card') {
                return $this->processCardPayment($request, $reservation);
            } else {
                return $this->processCashPayment($reservation);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    private function processCardPayment(Request $request, Reservation $reservation)
    {
        $paymentIntent = PaymentIntent::create([
            'amount' => $reservation->total_price * 100, // Stripe expects cents
            'currency' => 'usd',
            'metadata' => [
                'reservation_id' => $reservation->id,
                'customer_name' => $reservation->customer_name,
            ]
        ]);

        $reservation->update([
            'payment_method' => 'card',
            'stripe_payment_id' => $paymentIntent->id,
        ]);

        return response()->json([
            'client_secret' => $paymentIntent->client_secret,
            'amount' => $reservation->total_price
        ]);
    }

    private function processCashPayment(Reservation $reservation)
    {
        // For cash payment, mark as confirmed and reduce stock
        $reservation->update([
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'status' => 'confirmed'
        ]);

        // Reduce stock
        $reservation->product->decrement('stock', $reservation->quantity);

        DB::commit();

        return redirect()->route('reservations.success', $reservation)
            ->with('success', 'Reservation confirmed! Please prepare cash for delivery.');
    }

    public function confirmCardPayment(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        try {
            $paymentIntent = PaymentIntent::retrieve($validated['payment_intent_id']);
            
            if ($paymentIntent->status !== 'succeeded') {
                return response()->json(['error' => 'Payment not completed'], 400);
            }

            DB::beginTransaction();

            // Update reservation
            $reservation->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'stripe_payment_id' => $paymentIntent->id,
            ]);

            // Reduce stock
            $reservation->product->decrement('stock', $reservation->quantity);

            DB::commit();

            return response()->json([
                'success' => true,
                'reservation_id' => $reservation->id
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Reservation $reservation)
    {
        return view('reservations.success', compact('reservation'));
    }
}
