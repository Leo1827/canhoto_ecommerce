<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductInventory;

class ProductInventoryController extends CustomBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($product_id)
    {
        $product = Product::findOrFail($product_id);
        $inventories = $product->inventories()->latest()->paginate(10);

        return view('admin.products.inventories.index', compact('product', 'inventories'));
    }

    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('admin.products.inventories.create', compact('product'));
    }

    public function store(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);

        $request->validate([
            'name' => 'required|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'limited' => 'nullable|boolean',
            'minimum' => 'required|integer|min:0',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'numeric' => 'O campo :attribute deve ser numérico.',
            'min' => 'O campo :attribute deve ser no mínimo :min.',
        ]);

        $product->inventories()->create($request->all());

        return redirect()->route('admin.products.inventories.index', $product->id)
                         ->with('success', 'Estoque adicionado com sucesso!');
    }

    public function edit($product_id, $inventory_id)
    {
        $product = Product::findOrFail($product_id);
        $inventory = ProductInventory::where('product_id', $product->id)->findOrFail($inventory_id);

        return view('admin.products.inventories.edit', compact('product', 'inventory'));
    }

    public function update(Request $request, $product_id, $inventory_id)
    {
        $product = Product::findOrFail($product_id);
        $inventory = ProductInventory::where('product_id', $product->id)->findOrFail($inventory_id);

        $request->validate([
            'name' => 'required|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'limited' => 'nullable|boolean',
            'minimum' => 'required|integer|min:0',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'numeric' => 'O campo :attribute deve ser numérico.',
            'min' => 'O campo :attribute deve ser no mínimo :min.',
        ]);

        $inventory->update($request->all());

        return redirect()->route('admin.products.inventories.index', $product->id)
                         ->with('success', 'Estoque atualizado com sucesso!');
    }

    public function destroy($product_id, $inventory_id)
    {
        $product = Product::findOrFail($product_id);
        $inventory = ProductInventory::where('product_id', $product->id)->findOrFail($inventory_id);

        $inventory->delete();

        return redirect()->route('admin.products.inventories.index', $product->id)
                         ->with('success', 'Estoque excluído com sucesso!');
    }
}
