<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_place_order()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // Add items to the cart (Simulated redis add)
        Redis::hset('cart:' . $user->id, $product->id, 2);

        $response = $this->actingAs($user)
                         ->postJson('/api/order/place', [
                             'products' => [
                                 [
                                     'product_id' => $product->id,
                                     'quantity' => 2,
                                 ]
                             ]
                         ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Order placed successfully']);

        // Check if the order is in the database
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
    }

    public function test_viewing_orders()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/orders');

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         [
                             'id' => $order->id,
                             'user_id' => $user->id,
                             'status' => 'pending',
                         ]
                     ]
                 ]);
    }
}
