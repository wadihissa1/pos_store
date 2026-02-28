<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $data) {
            $product = Product::with(['category', 'defaultUnit'])->find($productId);
            if ($product) {
                $qty = (int) ($data['quantity'] ?? 1);
                $price = $product->defaultUnit?->price ?? $product->cost_price;
                $subtotal = $price * $qty;
                $total += $subtotal;
                $items[] = [
                    'product' => $product,
                    'quantity' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('pages.cart.index', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        $productId = (int) $request->product_id;
        $quantity = (int) $request->quantity;

        $cart = session('cart', []);
        $current = $cart[$productId]['quantity'] ?? 0;
        $cart[$productId] = ['quantity' => $current + $quantity];
        session(['cart' => $cart]);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Added to cart.');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0|max:999',
        ]);

        $productId = (int) $request->product_id;
        $quantity = (int) $request->quantity;

        $cart = session('cart', []);

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = ['quantity' => $quantity];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index');
    }

    public function remove(Product $product): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index');
    }
}
