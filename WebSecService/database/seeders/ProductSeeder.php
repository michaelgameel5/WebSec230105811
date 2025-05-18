<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'code' => 'P001',
                'name' => 'Laptop',
                'price' => 1200.00,
                'model' => 'XPS 13',
                'description' => 'A high-end laptop.',
                'photo' => 'images/laptop.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'P002',
                'name' => 'Smartphone',
                'price' => 800.00,
                'model' => 'Galaxy S21',
                'description' => 'A flagship smartphone.',
                'photo' => 'images/smartphone.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
