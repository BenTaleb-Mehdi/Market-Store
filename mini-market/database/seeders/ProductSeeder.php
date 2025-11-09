<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::insert([
            [
                'name' => 'Milk',
                'description' => 'Fresh whole milk - 1 liter',
                'price' => 12.50,
                'stock' => 30,
                'category' => 'Dairy',
                'image' => 'placeholder-milk.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bread',
                'description' => 'Fresh baked white bread loaf',
                'price' => 4.00,
                'stock' => 50,
                'category' => 'Bakery',
                'image' => 'placeholder-bread.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Apple Juice',
                'description' => '100% pure apple juice - 500ml',
                'price' => 8.90,
                'stock' => 25,
                'category' => 'Beverages',
                'image' => 'placeholder-apple-juice.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Eggs Pack',
                'description' => 'Fresh farm eggs - pack of 12',
                'price' => 15.75,
                'stock' => 40,
                'category' => 'Dairy',
                'image' => 'placeholder-eggs.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Orange Soda',
                'description' => 'Refreshing orange flavored soda - 330ml',
                'price' => 6.50,
                'stock' => 60,
                'category' => 'Beverages',
                'image' => 'placeholder-orange-soda.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
