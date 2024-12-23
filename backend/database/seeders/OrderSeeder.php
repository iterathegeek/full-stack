<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'user_id' => 1,
            'total_price' => 1700,
            'status' => 'Processing',
            'created_at' => now(),
        ]);

        Order::create([
            'user_id' => 2,
            'total_price' => 700,
            'status' => 'Shipped',
            'created_at' => now(),
        ]);

        Order::create([
            'user_id' => 1,
            'total_price' => 1000,
            'status' => 'Delivered',
            'created_at' => now(),
        ]);
    }
}
