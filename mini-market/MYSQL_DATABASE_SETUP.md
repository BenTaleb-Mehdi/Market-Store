# 🗄️ Mini Market MySQL Database Setup

## ✅ **Complete Database Structure Ready**

Your Laravel Mini Market project now has a **production-ready MySQL database** with:

-   🧍 **User Management** (Admin + Regular users)
-   🛍️ **Product Catalog**
-   🛒 **Order Processing**
-   💳 **Payment Handling** (Stripe + COD)
-   🔗 **Proper Eloquent Relationships**

---

## 🚀 **Quick Setup Instructions**

### **1️⃣ Create MySQL Database**

```sql
CREATE DATABASE mini_market_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### **2️⃣ Configure Environment**

Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

Your `.env` should have:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_market_db
DB_USERNAME=root
DB_PASSWORD=
```

### **3️⃣ Run Complete Setup**

```bash
php artisan migrate --seed
```

---

## 🧩 **Database Tables & Relationships**

### **1️⃣ users**

```sql
- id (Primary Key)
- name (String)
- email (String, Unique)
- password (String, Hashed)
- address (String, Nullable)
- phone (String, Nullable)
- is_admin (Boolean, default: false)
- timestamps
```

**Relationships:** `User hasMany Orders`

### **2️⃣ products**

```sql
- id (Primary Key)
- name (String)
- description (Text, Nullable)
- price (Decimal 10,2)
- stock (Integer, default: 0)
- category (String, Nullable)
- image (String, Nullable)
- timestamps
```

**Relationships:** `Product hasMany OrderItems`

### **3️⃣ orders**

```sql
- id (Primary Key)
- user_id (Foreign Key → users.id)
- total_amount (Decimal 10,2)
- payment_type (Enum: 'card', 'cod', default: 'cod')
- payment_status (Enum: 'pending', 'paid', 'failed', default: 'pending')
- timestamps
```

**Relationships:**

-   `Order belongsTo User`
-   `Order hasMany OrderItems`
-   `Order hasOne Payment`

### **4️⃣ order_items**

```sql
- id (Primary Key)
- order_id (Foreign Key → orders.id)
- product_id (Foreign Key → products.id)
- quantity (Integer)
- price (Decimal 10,2) // Price at time of order
- timestamps
```

**Relationships:**

-   `OrderItem belongsTo Order`
-   `OrderItem belongsTo Product`

### **5️⃣ payments**

```sql
- id (Primary Key)
- order_id (Foreign Key → orders.id)
- payment_id (String, Nullable) // Stripe transaction ID
- method (Enum: 'card', 'cod', default: 'cod')
- amount (Decimal 10,2)
- status (Enum: 'pending', 'paid', 'failed', default: 'pending')
- timestamps
```

**Relationships:** `Payment belongsTo Order`

---

## 👥 **Demo Data Included**

### **Admin User**

-   **Email:** `admin@mini.com`
-   **Password:** `admin123`
-   **Role:** Admin

### **Regular Users**

1. **John Doe** - `john@example.com` (password: `password123`)
2. **Jane Smith** - `jane@example.com` (password: `password123`)
3. **Mike Johnson** - `mike@example.com` (password: `password123`)

### **Demo Products**

1. **Milk** - $12.50 (Dairy, 30 in stock)
2. **Bread** - $4.00 (Bakery, 50 in stock)
3. **Apple Juice** - $8.90 (Beverages, 25 in stock)
4. **Eggs Pack** - $15.75 (Dairy, 40 in stock)
5. **Orange Soda** - $6.50 (Beverages, 60 in stock)

---

## 🔧 **Available Models & Methods**

### **User Model**

```php
// Relationships
$user->orders()

// Methods
$user->isAdmin()
```

### **Product Model**

```php
// Relationships
$product->orderItems()

// Scopes
Product::active()
Product::inStock()

// Accessors
$product->image_url
```

### **Order Model**

```php
// Relationships
$order->user()
$order->orderItems()
$order->payment()

// Scopes
Order::pending()
Order::paid()
Order::failed()

// Accessors
$order->status_color
```

### **OrderItem Model**

```php
// Relationships
$orderItem->order()
$orderItem->product()

// Accessors
$orderItem->total_price
```

### **Payment Model**

```php
// Relationships
$payment->order()

// Scopes
Payment::pending()
Payment::paid()
Payment::failed()
```

---

## 🎯 **Testing Your Setup**

After running `php artisan migrate --seed`, you should be able to:

### **✅ Database Verification**

-   See all 5 tables in phpMyAdmin/MySQL Workbench
-   Verify foreign key constraints are in place
-   Check that demo data is populated

### **✅ Authentication Testing**

```php
// Login as admin
Auth::attempt(['email' => 'admin@mini.com', 'password' => 'admin123'])

// Login as regular user
Auth::attempt(['email' => 'john@example.com', 'password' => 'password123'])
```

### **✅ Data Fetching**

```php
// Get all products
$products = Product::active()->inStock()->get();

// Create an order
$order = Order::create([
    'user_id' => 1,
    'total_amount' => 25.40,
    'payment_type' => 'card',
    'payment_status' => 'pending'
]);

// Add order items
$order->orderItems()->create([
    'product_id' => 1,
    'quantity' => 2,
    'price' => 12.50
]);
```

---

## 🔗 **Foreign Key Relationships**

```
users (1) ←→ (many) orders
orders (1) ←→ (many) order_items
products (1) ←→ (many) order_items
orders (1) ←→ (one) payment
```

All relationships include proper `onDelete('cascade')` constraints for data integrity.

---

## 🎉 **Ready For Production**

Your database is now **fully configured** and ready for:

-   ✅ User registration/authentication
-   ✅ Admin dashboard functionality
-   ✅ Product catalog management
-   ✅ Shopping cart operations
-   ✅ Order processing (Card + COD)
-   ✅ Stripe payment integration
-   ✅ Payment tracking and status updates

**Run:** `php artisan migrate --seed` and you're ready to go! 🚀
