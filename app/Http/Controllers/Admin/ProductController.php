<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Winery;
use App\Models\Region;
use App\Models\WineType;
use App\Models\Vintage;
use App\Models\Condition;

class ProductController extends CustomBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::all(),
            'wineries' => Winery::all(),
            'regions' => Region::all(),
            'wineTypes' => WineType::all(),
            'vintages' => Vintage::all(),
            'conditions' => Condition::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'winery_id' => 'required|exists:wineries,id',
            'region_id' => 'required|exists:regions,id',
            'wine_type_id' => 'required|exists:wine_types,id',
            'vintage_id' => 'required|exists:vintages,id',
            'condition_id' => 'required|exists:conditions,id',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser numérico.',
            'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
            'exists' => 'O valor selecionado para :attribute é inválido.',
            'unique' => 'Este :attribute já está em uso.',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'wineries' => Winery::all(),
            'regions' => Region::all(),
            'wineTypes' => WineType::all(),
            'vintages' => Vintage::all(),
            'conditions' => Condition::all(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'winery_id' => 'required|exists:wineries,id',
            'region_id' => 'required|exists:regions,id',
            'wine_type_id' => 'required|exists:wine_types,id',
            'vintage_id' => 'required|exists:vintages,id',
            'condition_id' => 'required|exists:conditions,id',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser numérico.',
            'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
            'exists' => 'O valor selecionado para :attribute é inválido.',
            'unique' => 'Este :attribute já está em uso.',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produto excluído com sucesso!');
    }
}
