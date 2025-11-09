# 🔐 Admin Dashboard Login Credentials

## 👤 **Current Admin User**

### **Default Admin Account**
- **Email:** `admin@mini.com`
- **Password:** `admin123`
- **Name:** Admin User
- **Role:** Administrator

---

## 🚀 **How to Login to Admin Dashboard**

1. **Start your Laravel server:**
   ```bash
   php artisan serve
   ```

2. **Access the login page:**
   - Go to: `http://127.0.0.1:8000/login`
   - Or your custom admin login route

3. **Enter credentials:**
   - Email: `admin@mini.com`
   - Password: `admin123`

---

## 👥 **All User Accounts**

### **Admin Users**
- **Admin User** - `admin@mini.com` (Password: `admin123`)

### **Regular Users**
- **John Doe** - `john@example.com` (Password: `password123`)
- **Jane Smith** - `jane@example.com` (Password: `password123`)
- **Mike Johnson** - `mike@example.com` (Password: `password123`)

---

## ➕ **Create Additional Admin Users**

### **Option 1: Using Tinker (Recommended)**
```bash
php artisan tinker
```

Then run:
```php
App\Models\User::create([
    'name' => 'Your Admin Name',
    'email' => 'youradmin@example.com',
    'password' => 'your-secure-password',
    'is_admin' => true,
    'address' => 'Admin Address',
    'phone' => '+1234567890'
]);
```

### **Option 2: Using Database Seeder**

Create a new seeder:
```bash
php artisan make:seeder AdminSeeder
```

Add to `database/seeders/AdminSeeder.php`:
```php
public function run(): void
{
    \App\Models\User::create([
        'name' => 'Super Admin',
        'email' => 'superadmin@mini.com',
        'password' => 'superadmin123',
        'is_admin' => true,
        'address' => 'Super Admin Address',
        'phone' => '+1234567890'
    ]);
}
```

Run the seeder:
```bash
php artisan db:seed --class=AdminSeeder
```

### **Option 3: Direct Database Insert**
```sql
INSERT INTO users (name, email, password, is_admin, address, phone, created_at, updated_at) 
VALUES (
    'New Admin', 
    'newadmin@mini.com', 
    '$2y$12$your-hashed-password-here', 
    1, 
    'Admin Address', 
    '+1234567890', 
    NOW(), 
    NOW()
);
```

---

## 🔒 **Change Admin Password**

### **Using Tinker:**
```bash
php artisan tinker
```

```php
$admin = App\Models\User::where('email', 'admin@mini.com')->first();
$admin->password = 'new-secure-password';
$admin->save();
```

### **Using Artisan Command (if you have one):**
```bash
php artisan user:change-password admin@mini.com
```

---

## 🛡️ **Security Best Practices**

1. **Change Default Password:**
   - Always change the default `admin123` password in production
   - Use a strong password with mixed characters

2. **Use Environment Variables:**
   - Store admin credentials in `.env` file for production
   - Never commit real passwords to version control

3. **Enable Two-Factor Authentication:**
   - Consider adding 2FA for admin accounts
   - Use Laravel packages like `laravel/fortify`

---

## 🔍 **Verify Admin Access**

### **Check if User is Admin:**
```php
// In your controller or middleware
if (auth()->user()->isAdmin()) {
    // User has admin access
    return view('admin.dashboard');
} else {
    // Redirect to regular user area
    return redirect('/dashboard');
}
```

### **Admin Middleware Example:**
```php
// In routes/web.php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/products', [AdminController::class, 'products']);
    Route::get('/admin/orders', [AdminController::class, 'orders']);
});
```

---

## 📱 **Quick Login Test**

1. Go to: `http://127.0.0.1:8000/login`
2. Enter: `admin@mini.com` / `admin123`
3. Should redirect to admin dashboard

**Your admin credentials are ready to use! 🎉**
