<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{


    public function index()
    {
        // Fetch all orders
        $orders = Order::with('orderItems')->get();

        return response()->json($orders,200);
    }

    
    public function placeOrder(Request $request) {
       // $user_id = $request->user()->id; // Assuming you are using authentication
       $user_id = 1;
        $cartItems = Redis::hgetall('cart:' . $user_id);
    
        if (empty($cartItems)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }
    
        // Calculate total price
        $totalPrice = array_reduce($cartItems, function ($total, $item) {
            $item = json_decode($item, true);
            return $total + ($item['price'] * $item['quantity']);
        }, 0);
    
        // Create the order
        $order = Order::create([
            'user_id' => $user_id,
            'total_price' => $totalPrice,
            'status' => 'processing',
        ]);
    
        // Add items to the order
        foreach ($cartItems as $item) {
            $item = json_decode($item, true);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    
        Redis::del('cart:' . $user_id); // Clear cart
    
        // return response()->json(['success' => 'Order placed successfully']);
        return response()->json(['success' => 'Order placed successfully', 'order_id' => $order->id], 200);
    }
    
}
