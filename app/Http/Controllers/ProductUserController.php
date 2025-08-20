<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductUserController extends Controller
{
    // Página principal del catálogo
    public function index(Request $request)
    {
        $query = Product::with(['region', 'vintage', 'winery', 'wineType'])
            ->where('status', true);

        // Filtrar por tipos de vino
        if ($request->filled('wine_types')) {
            $query->whereIn('wine_type_id', $request->wine_types);
        }

        // Filtrar por regiones
        if ($request->filled('regions')) {
            $query->whereIn('region_id', $request->regions);
        }

        // Filtrar por precio
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(9)->appends($request->query());

        return view('dashboard', compact('products'));
    }

    // Detalle de producto
    public function show($slug)
    {
        $product = Product::with([
            'inventories', 'region', 'vintage', 'condition', 'wineType', 'winery', 'galleries'
        ])->where('slug', $slug)
        ->where('status', true)
        ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
