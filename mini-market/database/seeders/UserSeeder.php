<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@mini.com',
            'password' => 'admin123',
            'address' => '123 Admin Street, Admin City',
            'phone' => '+1234567890',
            'is_admin' => true,
        ]);

        // Create normal users
        \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'address' => '456 Main Street, City Center',
            'phone' => '+1234567891',
            'is_admin' => false,
        ]);

        \App\Models\User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => 'password123',
            'address' => '789 Oak Avenue, Downtown',
            'phone' => '+1234567892',
            'is_admin' => false,
        ]);

        \App\Models\User::create([
            'name' => 'Mike Johnson',
            'email' => 'mike@example.com',
            'password' => 'password123',
            'address' => '321 Pine Road, Suburbs',
            'phone' => '+1234567893',
            'is_admin' => false,
        ]);
    }
}
