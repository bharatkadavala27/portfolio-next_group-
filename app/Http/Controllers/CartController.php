<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart($productId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }
        Session::put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        $cartItemCount = array_sum($cart);

        return response()->json(['cartItemCount' => $cartItemCount]);
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::find($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function remove($id)
    {
        $cartItem = Cart::find($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
