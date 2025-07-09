<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductInventory;

class ProductInventoryController extends CustomBaseController
{
    public function index(Product $product)
    {
        return view('admin.products.inventories.index', compact('product'));
    }

    public function create(Product $product)
    {
        return view('admin.products.inventories.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'limited' => 'sometimes|boolean',
        ]);

        // Si está limitado, validamos quantity y minimum
        if ($request->boolean('limited')) {
            $request->validate([
                'quantity' => 'required|integer|min:0',
                'minimum' => 'required|integer|min:0',
            ]);
        }

        // Siempre aseguramos que `limited` sea 0 o 1
        $data = $request->all();
        $data['limited'] = $request->boolean('limited') ? 1 : 0;

        $product->inventories()->create($data);

        return redirect()
            ->route('admin.products.inventories.index', $product->id)
            ->with('success', 'Inventário adicionado com sucesso.');
    }

    public function edit(Product $product, ProductInventory $inventory)
    {
        return view('admin.products.inventories.edit', compact('product', 'inventory'));
    }

    public function update(Request $request, Product $product, ProductInventory $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'limited' => 'sometimes|boolean',
        ]);

        if ($request->boolean('limited')) {
            $request->validate([
                'quantity' => 'required|integer|min:0',
                'minimum' => 'required|integer|min:0',
            ]);
        }

        $data = $request->all();
        $data['limited'] = $request->boolean('limited') ? 1 : 0;

        $inventory->update($data);

        return redirect()
            ->route('admin.products.inventories.index', $product->id)
            ->with('success', 'Inventário atualizado com sucesso.');
    }


    public function destroy(Product $product, ProductInventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('admin.products.inventories.index', $product->id)
            ->with('success', 'Inventario eliminado.');
    }
}
