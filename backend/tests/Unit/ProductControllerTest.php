<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    // Test for fetching all products
    public function test_get_all_products()
    {
        Product::factory()->count(5)->create(); // Assuming you have a Product factory

        $response = $this->getJson('/api/products');
       // dump('zola', $response->json());
        $response->assertStatus(200)
                 ->assertJsonCount(5); // Ensure the count matches the number of products created
    }

    // Test for fetching a single product by ID
    public function test_get_single_product()
    {
        $product = Product::factory()->create();  // Creating a sample product

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $product->id,
                     'name' => $product->name,
                     'description' => $product->description,
                     'price' => $product->price,
                     'quantity' => $product->quantity,
                 ]);
    }

    public function test_get_product_not_found()
    {
        $response = $this->getJson('/api/products/999');  // Non-existent product ID

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Product not found']);
    }

    // Test storing a new product
    public function test_create_product()
    {
        $user = User::factory()->create(); // Assuming you're testing with an authenticated user

        $response = $this->actingAs($user)->postJson('/api/products', [
            'name' => 'Product A',
            'description' => 'This is a great product',
            'price' => 25.50,
            'quantity' => 100,
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Product created successfully',
                     'product' => [
                         'name' => 'Product A',
                         'description' => 'This is a great product',
                         'price' => 25.50,
                         'quantity' => 100,
                     ]
                 ]);

        // Ensure the product is saved in the database
        $this->assertDatabaseHas('products', [
            'name' => 'Product A',
            'price' => 25.50,
        ]);
    }

    public function test_create_product_validation_error()
    {
        $user = User::factory()->create();

        // Test without required fields
        $response = $this->actingAs($user)->postJson('/api/products', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'description', 'price', 'quantity']);
    }

    // Test updating an existing product
    public function test_update_product()
    {
        $product = Product::factory()->create();

        $response = $this->putJson('/api/products/' . $product->id, [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 30.00,
            'quantity' => 120,
        ]);

       // dump('zola', $response->json());
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Product updated successfully',
                     'product' => [
                         'id' => $product->id,
                         'name' => 'Updated Product',
                         'description' => 'Updated description',
                         'price' => 30.00,
                         'quantity' => 120,
                     ]
                 ]);

        // Ensure the product is updated in the database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 30.00,
        ]);
    }

    public function test_update_product_not_found()
    {
        $response = $this->putJson('/api/products/1', [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 30.00,
            'quantity' => 120,
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Product not found']);
    }

    // Test deleting a product
    public function test_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Product deleted successfully']);

        // Ensure the product is deleted from the database
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_delete_product_not_found()
    {
        $response = $this->deleteJson('/api/products/999');  // Non-existent product ID

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Product not found']);
    }
}
