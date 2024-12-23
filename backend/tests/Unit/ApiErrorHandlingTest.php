<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APIErrorHandlingTest extends TestCase
{
    use RefreshDatabase;

    public function test_error_adding_item_to_cart_when_not_found()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->postJson('/api/cart/add', [
                             'product_id' => 999,  // Non-existent product
                             'quantity' => 1,
                         ]);

        $response->assertStatus(404)
                 ->assertJson(['error' => 'Product not found']);
    }

    public function test_error_when_invalid_quantity_added_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
                         ->postJson('/api/cart/add', [
                             'product_id' => $product->id,
                             'quantity' => 0,  // Invalid quantity
                         ]);

        $response->assertStatus(400)
                 ->assertJson(['error' => 'Quantity must be greater than zero']);
    }

    public function test_error_when_user_tries_to_place_empty_order()
    {
        $user = User::factory()->create();

        // Empty order
        $response = $this->actingAs($user)
                         ->postJson('/api/order/place', ['products' => []]);

        $response->assertStatus(400)
                 ->assertJson(['error' => 'Order must contain products']);
    }
}
