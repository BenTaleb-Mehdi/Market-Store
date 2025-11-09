# 🗄️ Mini Market Database Setup Guide

## ✅ **What's Been Completed**

Your Laravel Mini Market project now has a complete database structure ready for:
- 🧍 **User Management** (with admin support)
- 🛍️ **Product Catalog** 
- 🛒 **Order Processing**
- 💳 **Payment Handling** (Stripe + COD)

---

## 🧩 **Database Tables Overview**

### 1️⃣ **users** 
```sql
- id (Primary Key)
- name
- email (Unique)
- password
- address (Nullable)
- phone (Nullable)
- is_admin (Boolean, default: false)
- timestamps
```

### 2️⃣ **products**
```sql
- id (Primary Key)
- name
- description (Nullable)
- price (Decimal 10,2)
- stock (Integer, default: 0)
- category (Nullable)
- image (Nullable)
- timestamps
```

### 3️⃣ **orders**
```sql
- id (Primary Key)
- user_id (Foreign Key → users.id)
- total_amount (Decimal 10,2)
- payment_type (Enum: 'card', 'cod', default: 'cod')
- payment_status (Enum: 'pending', 'paid', 'failed', default: 'pending')
- timestamps
```

### 4️⃣ **order_items**
```sql
- id (Primary Key)
- order_id (Foreign Key → orders.id)
- product_id (Foreign Key → products.id)
- quantity (Integer)
- price (Decimal 10,2) // Price at time of order
- timestamps
```

### 5️⃣ **payments**
```sql
- id (Primary Key)
- order_id (Foreign Key → orders.id)
- payment_id (Nullable) // Stripe payment ID
- method (String, default: 'cod')
- amount (Decimal 10,2)
- status (String, default: 'pending')
- timestamps
```

---

## 🚀 **Setup Instructions**

### **Step 1: Create MySQL Database**
```sql
CREATE DATABASE mini_market_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### **Step 2: Configure Environment**
Copy `.env.example` to `.env` and update:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_market_db
DB_USERNAME=root
DB_PASSWORD=
```

### **Step 3: Run Migrations**
```bash
php artisan migrate
```

### **Step 4: Seed Demo Data (Optional)**
```bash
php artisan db:seed --class=ProductSeeder
```

---

## 📋 **Available Migrations**

1. `0001_01_01_000000_create_users_table.php` - Users, password resets, sessions
2. `2025_10_21_095027_create_products_table.php` - Products catalog
3. `2025_10_21_183831_create_orders_table.php` - Orders management
4. `2025_10_21_183858_create_order_items_table.php` - Order line items
5. `2025_10_22_083635_create_payments_table.php` - Payment tracking
6. `2025_10_21_193500_add_is_admin_to_users_table.php` - Admin user support

---

## 🎯 **Demo Data Included**

The `ProductSeeder` creates sample products:
- **Milk** - $12.50 (Drinks category, 30 in stock)
- **Bread** - $4.00 (Bakery category, 50 in stock)  
- **Apple Juice** - $8.90 (Juices category, 20 in stock)

---

## 🔗 **Database Relationships**

```
users (1) ←→ (many) orders
orders (1) ←→ (many) order_items
products (1) ←→ (many) order_items
orders (1) ←→ (many) payments
```

---

## ✅ **Ready For**

- ✅ User registration/login
- ✅ Admin dashboard
- ✅ Product management
- ✅ Shopping cart functionality
- ✅ Order processing
- ✅ Stripe payment integration
- ✅ Cash-on-delivery orders
- ✅ Payment tracking

Your database is now **production-ready** with proper relationships, constraints, and sample data! 🎉
