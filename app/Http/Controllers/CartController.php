<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\ProductInventory;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function json()
    {
        $items = CartItem::with('product.tax', 'inventory')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json([
            'items' => $items->map(function ($item) {
                $rate = $item->tax_rate ?? ($item->product->tax->rate ?? 0);
                $taxAmount = $item->tax_amount ?? ($item->subtotal * $rate / 100);

                return [
                    'id' => $item->id,
                    'name' => optional($item->product)->name ?? 'Produto removido',
                    'image' => optional($item->product)->image_url ?? asset('img/default.jpeg'),
                    'price_unit' => $item->price_unit,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                    'tax_rate' => $rate,
                    'tax_amount' => $taxAmount,
                ];
            }),
            'total' => $items->sum(function ($i) {
                return $i->subtotal + ($i->tax_amount ?? 0);
            }),
        ]);
    }

    // Agregar producto al carrito
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'inventory_id' => 'required|exists:product_inventories,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Traer producto con su IVA
        $product = \App\Models\Product::with('tax')->findOrFail($request->product_id);
        $quantity = $request->quantity;

        // Precio viene de products
        $price = $product->price;
        $taxRate = $product->tax->rate ?? 0;

        // Cálculos
        $subtotal = $price * $quantity;
        $taxAmount = $subtotal * ($taxRate / 100);

        // Buscar si ya existe el item en el carrito
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('inventory_id', $request->inventory_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->subtotal = $cartItem->quantity * $price;
            $cartItem->price_unit = $price;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'inventory_id' => $request->inventory_id,
                'price_unit' => $price,   // precio neto (sin IVA)
                'quantity' => $quantity,
                'subtotal' => $subtotal, // solo base
            ]);
        }

        return response()->json(['message' => 'Produto adicionado ao carrinho.']);
    }

    // Actualizar cantidad
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $item->quantity = $request->quantity;
        $item->subtotal = $item->price_unit * $request->quantity;
        $item->save();

        return back()->with('success', 'Carrinho atualizado.');
    }

    // Remover item
    public function remove($id)
    {
        CartItem::where('id', $id)->where('user_id', Auth::id())->delete();

        return back()->with('success', 'Item removido do carrinho.');
    }
}
