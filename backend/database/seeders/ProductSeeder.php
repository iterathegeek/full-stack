<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create(['name' => 'Laptop', 'description' => 'A high-performance laptop', 'price' => 1000,'quantity' => 1000]);
        Product::create(['name' => 'Smartphone', 'description' => 'Latest model smartphone', 'price' => 700,'quantity' => 1000]);
        Product::create(['name' => 'Headphones', 'description' => 'Noise-cancelling headphones', 'price' => 200,'quantity' => 1000]);
        Product::create(['name' => 'Camera', 'description' => 'DSLR camera', 'price' => 1500,'quantity' => 1000]);
        Product::create(['name' => 'Monitor', 'description' => '4K Ultra HD monitor', 'price' => 500,'quantity' => 1000]);
    }
}
