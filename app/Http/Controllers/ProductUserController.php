<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductUserController extends Controller
{
    // Página principal del catálogo
    public function index()
    {
        $products = Product::with(['region', 'vintage', 'winery']) // Asegúrate de tener relaciones
            ->where('status', true)
            ->latest()
            ->paginate(9);

        return view('dashboard', compact('products'));
    }

    // Detalle de producto
    public function show($slug)
    {
        $product = Product::with([
            'region', 'vintage', 'condition', 'wineType', 'winery', 'galleries'
        ])->where('slug', $slug)
        ->where('status', true)
        ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
