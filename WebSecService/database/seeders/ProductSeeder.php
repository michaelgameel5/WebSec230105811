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
                'name' => 'LG TV',
                'price' => 25000.00,
                'model' => 'XPS 13',
                'description' => 'A high-end TV.',
                'photo' => 'images/lgtv50.jpg',
                'created_at' => '2025-05-18 21:37:14',
                'updated_at' => '2025-05-18 21:37:14',
            ],
            [
                'code' => 'P002',
                'name' => 'Toshiba Fridge',
                'price' => 30000.00,
                'model' => 'TH-50',
                'description' => 'A good fridge',
                'photo' => 'images/tsrf50.jpg',
                'created_at' => '2025-05-18 21:37:14',
                'updated_at' => '2025-05-18 21:37:14',
            ],
            [
                'code' => 'P003',
                'name' => 'Pentesting Toolkit',
                'price' => 500.00,
                'model' => 'PT',
                'description' => 'Amazing PT Toolkit',
                'photo' => 'images/pentestkit.jpg',
                'created_at' => '2025-05-18 21:37:14',
                'updated_at' => '2025-05-18 21:37:14',
            ],
        ]);
    }
}
