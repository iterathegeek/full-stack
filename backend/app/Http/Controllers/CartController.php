<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    //

    public function addToCart(Request $request) {
        $product = Product::find($request->product_id);
        if (!$product || $product->quantity < $request->quantity) {
            return response()->json(['error' => 'Product not available'], 400);
        }
    
        Redis::hset('cart:1', $product->id, json_encode([
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity
        ]));
    
        return response()->json(['success' => 'Product added to cart']);
    }

    public function removeFromCart($product_id) {
        // Delete the product from the cart in Redis
        Redis::hdel('cart:1', $product_id);
    
        return response()->json(['message' => 'Item removed successfully']);
    }
    

    public function viewCart() {
        $items = Redis::hgetall('cart:1');
        
        // Transform the Redis data (each item is a JSON string)
        $cart = [];
        foreach ($items as $product_id => $item_json) {
            $item = json_decode($item_json, true);
            $item['product_id'] = $product_id;  // Add product ID to the item object
            $cart[] = $item;  // Append the item to the cart array
        }
        
        return response()->json($cart);
    }
    
    
}
