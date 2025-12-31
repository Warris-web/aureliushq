<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        return response()->json([
            'items' => $cart ? $cart->items : []
        ]);
    }


    public function add_cart(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => ' Please login to add items to cart.',
            ]);
        }
    
        // Find or create cart for this user
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['items' => []]
        );
    
        $items = $cart->items ?? [];
        $id = $request->id;
        $name = $request->name;
        $price = $request->price;
        $qty = $request->qty ?? 1;
        $limit = 20000; // Example limit ₦20,000
    
        $itemTotal = $price * $qty;
        $totalAmount = collect($items)->sum('total');
    
        // Limit check
        // if ($totalAmount + $itemTotal > $limit) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => " Cannot exceed ₦" . number_format($limit),
        //     ]);
        // }
    
        // Update or add item
        if (isset($items[$id])) {
            $items[$id]['qty'] += $qty;
            $items[$id]['total'] = $items[$id]['qty'] * $price;
        } else {
            $items[$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'qty' => $qty,
                'total' => $itemTotal,
            ];
        }
    
        // Save back to DB
        $cart->items = $items;
        $cart->save();
    
        return response()->json([
            'success' => true,
            'message' => " $name added to cart!",
            'cart' => $items,
            'count' => collect($items)->sum('qty') // cart count
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0'
        ]);

        $cart = Cart::updateOrCreate(
            ['user_id' => Auth::id()],
            ['items' => $request->items]
        );

        return response()->json([
            'success' => true,
            'message' => 'Cart saved successfully'
        ]);
    }

    public function destroy()
    {
        Cart::where('user_id', Auth::id())->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }


    public function update_cart(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => ' Please login to manage cart.',
        ]);
    }

    $cart = Cart::where('user_id', $user->id)->first();
    if (!$cart) {
        return response()->json([
            'success' => false,
            'message' => ' Cart not found.',
        ]);
    }

    $items = $cart->items ?? [];
    $id = $request->id;
    $qty = $request->qty ?? 1;
    $limit = 20000; // Example limit ₦20,000

    if (!isset($items[$id])) {
        return response()->json([
            'success' => false,
            'message' => ' Item not found in cart.',
        ]);
    }

    if ($qty <= 0) {
        return response()->json([
            'success' => false,
            'message' => ' Invalid quantity.',
        ]);
    }

    // Update quantity and calculate new total
    $items[$id]['qty'] = $qty;
    $items[$id]['total'] = $items[$id]['qty'] * $items[$id]['price'];

    // Check limit
    $totalAmount = collect($items)->sum('total');
    if ($totalAmount > $limit) {
        // return response()->json([
        //     'success' => false,
        //     'message' => " Cannot exceed ₦" . number_format($limit),
        // ]);
    }

    // Save back to DB
    $cart->items = $items;
    $cart->save();

    return response()->json([
        'success' => true,
        'message' => " Cart updated!",
        'cart' => $items,
        'count' => collect($items)->sum('qty'),
        'total' => $totalAmount
    ]);
}

public function remove_from_cart(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => ' Please login to manage cart.',
        ]);
    }

    $cart = Cart::where('user_id', $user->id)->first();
    if (!$cart) {
        return response()->json([
            'success' => false,
            'message' => ' Cart not found.',
        ]);
    }

    $items = $cart->items ?? [];
    $id = $request->id;

    if (!isset($items[$id])) {
        return response()->json([
            'success' => false,
            'message' => ' Item not found in cart.',
        ]);
    }

    $itemName = $items[$id]['name'];
    unset($items[$id]);

    // Save back to DB
    $cart->items = $items;
    $cart->save();

    $totalAmount = collect($items)->sum('total');

    return response()->json([
        'success' => true,
        'message' => " {$itemName} removed from cart!",
        'cart' => $items,
        'count' => collect($items)->sum('qty'),
        'total' => $totalAmount
    ]);
}

public function clear_cart(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => ' Please login to manage cart.',
        ]);
    }

    $cart = Cart::where('user_id', $user->id)->first();
    if ($cart) {
        $cart->items = [];
        $cart->save();
    }

    return response()->json([
        'success' => true,
        'message' => " Cart cleared!",
        'cart' => [],
        'count' => 0,
        'total' => 0
    ]);
}
}