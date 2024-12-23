<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAddToCartSuccessfullyAddsProduct()
    {
        // Create a product
        $product = Product::factory()->create([
            'quantity' => 10,
        ]);

        // Prepare the request data
        $requestData = [
            'product_id' => $product->id,
            'quantity' => 2,
        ];

        // Act
        $response = $this->postJson('/api/cart/add', $requestData);

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Product added to cart']);

        // Verify that the product is stored in Redis
        $cartItem = Redis::hget('cart:1', $product->id);
        $this->assertNotNull($cartItem);

        $cartData = json_decode($cartItem, true);
        $this->assertEquals($product->id, $cartData['product_id']);
        $this->assertEquals($product->name, $cartData['name']);
        $this->assertEquals(2, $cartData['quantity']);
    }

    public function testAddToCartFailsWhenProductDoesNotExist()
    {
        // Act
        $response = $this->postJson('/api/cart/add', [
            'product_id' => 999,
            'quantity' => 1,
        ]);

        // Assert
        $response->assertStatus(400);
        $response->assertJson(['error' => 'Product not available']);
    }

    public function testRemoveFromCartSuccessfullyRemovesProduct()
    {
        // Set up Redis with a product in the cart
        $productData = [
            'product_id' => 1,
            'name' => 'Test Product',
            'price' => 100,
            'quantity' => 2,
        ];
        Redis::hset('cart:1', $productData['product_id'], json_encode($productData));

        // Act
        $response = $this->deleteJson('/api/cart/remove/1');

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Item removed successfully']);

        // Verify the product was removed from Redis
        $this->assertNull(Redis::hget('cart:1', 1));
    }

    public function testViewCartReturnsAllProductsInCart()
    {
        // Set up Redis with multiple products
        $product1 = [
            'product_id' => 1,
            'name' => 'Product One',
            'price' => 100,
            'quantity' => 2,
        ];
        $product2 = [
            'product_id' => 2,
            'name' => 'Product Two',
            'price' => 200,
            'quantity' => 1,
        ];
        Redis::hset('cart:1', $product1['product_id'], json_encode($product1));
        Redis::hset('cart:1', $product2['product_id'], json_encode($product2));

        // Act
        $response = $this->getJson('/api/cart/view');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'product_id' => 1,
            'name' => 'Product One',
            'price' => 100,
            'quantity' => 2,
        ]);
        $response->assertJsonFragment([
            'product_id' => 2,
            'name' => 'Product Two',
            'price' => 200,
            'quantity' => 1,
        ]);
    }
}
