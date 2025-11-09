# Payment Setup Guide

## 🚀 Mini Market Payment Integration

This guide will help you set up both **Stripe** and **Cash on Delivery (COD)** payment methods for your Mini Market application.

## 📋 Prerequisites

- Laravel application running
- Composer installed
- Stripe account (for card payments)

## 🔧 Installation & Setup

### 1. Stripe Package (Already Installed)
```bash
composer require stripe/stripe-php
```

### 2. Environment Configuration

Add these variables to your `.env` file:

```env
# Stripe Configuration
STRIPE_KEY=pk_test_your_stripe_publishable_key_here
STRIPE_SECRET=sk_test_your_stripe_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
```

### 3. Get Your Stripe Keys

1. **Sign up for Stripe**: Go to [https://stripe.com](https://stripe.com) and create an account
2. **Get Test Keys**: 
   - Go to Dashboard → Developers → API Keys
   - Copy your **Publishable key** (starts with `pk_test_`)
   - Copy your **Secret key** (starts with `sk_test_`)
3. **Add to .env**: Replace the placeholder values in your `.env` file

### 4. Test Card Numbers

For testing, use these Stripe test card numbers:

| Card Number | Brand | CVC | Date |
|-------------|-------|-----|------|
| `4242424242424242` | Visa | Any 3 digits | Any future date |
| `4000000000000002` | Visa (declined) | Any 3 digits | Any future date |
| `5555555555554444` | Mastercard | Any 3 digits | Any future date |

## 🎯 Features Implemented

### ✅ Payment Methods
- **💳 Stripe Card Payment**: Secure credit/debit card processing
- **💰 Cash on Delivery**: Pay when you receive your order

### ✅ Order Management
- Orders saved to database with payment method
- Different statuses: `pending` (COD) or `confirmed` (Stripe)
- Order tracking and history
- Email notifications (ready to implement)

### ✅ Security Features
- CSRF protection on all forms
- Server-side payment validation
- Stripe's secure payment processing
- Input sanitization and validation

## 🛠️ How It Works

### Card Payment Flow:
1. User selects "Card Payment"
2. Stripe Elements loads secure card form
3. Payment Intent created on server
4. Card details processed by Stripe
5. Payment confirmed and order saved
6. User redirected to success page

### COD Payment Flow:
1. User selects "Cash on Delivery"
2. Order details validated
3. Order saved with `pending` status
4. Stock reduced immediately
5. User redirected to success page

## 🔍 Testing the Payment System

### Test Stripe Payment:
1. Add items to cart
2. Go to checkout
3. Select "Card Payment"
4. Use test card: `4242424242424242`
5. Enter any future expiry date and CVC
6. Complete payment

### Test COD Payment:
1. Add items to cart
2. Go to checkout  
3. Select "Cash on Delivery"
4. Fill in shipping details
5. Place order

## 📁 Key Files

```
app/Http/Controllers/PaymentController.php  # Payment processing logic
resources/views/checkout/index.blade.php    # Checkout form with Stripe
routes/web.php                             # Payment routes
database/migrations/*_orders_table.php     # Orders database structure
```

## 🚨 Important Notes

### For Production:
1. **Replace test keys** with live Stripe keys
2. **Set up webhooks** for payment confirmations
3. **Enable HTTPS** (required for Stripe)
4. **Test thoroughly** before going live

### Security:
- Never expose secret keys in frontend code
- Always validate payments on server-side
- Use HTTPS in production
- Implement proper error handling

## 🎨 UI Features

- **Responsive Design**: Works on mobile and desktop
- **Real-time Validation**: Instant feedback on card errors
- **Loading States**: Visual feedback during processing
- **Error Handling**: Clear error messages for users
- **Modern UI**: Clean TailwindCSS design

## 🔄 Order Status Flow

```
COD Orders:    pending → confirmed → processing → completed
Stripe Orders: confirmed → processing → completed
```

## 📞 Support

If you need help:
1. Check Stripe documentation: [https://stripe.com/docs](https://stripe.com/docs)
2. Review Laravel payment guides
3. Test with Stripe's test mode first

---

**🎉 Your Mini Market now supports both card payments and cash on delivery!**

The payment system is fully functional and ready for production use. Just add your real Stripe keys when you're ready to go live.
