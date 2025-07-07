<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Winery;
use App\Models\Region;
use App\Models\WineType;
use App\Models\Vintage;
use App\Models\Condition;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'winery', 'region', 'wineType', 'vintage', 'condition']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('trashed')) {
            $query->onlyTrashed();
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create', [
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
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'winery_id' => 'required|exists:wineries,id',
            'region_id' => 'required|exists:regions,id',
            'wine_type_id' => 'required|exists:wine_types,id',
            'vintage_id' => 'required|exists:vintages,id',
            'condition_id' => 'required|exists:conditions,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'exists' => 'O :attribute selecionado é inválido.',
            'numeric' => 'O campo :attribute deve ser numérico.',
            'image' => 'O campo :attribute deve ser uma imagem válida.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'min' => 'O campo :attribute deve ser no mínimo :min.',
        ]);

        $slug = Str::slug($request->name);
        $data = $request->except('image');
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            $original = $request->file('image');
            $filename = time() . '.' . $original->getClientOriginalExtension();
            
            $driver = new Driver();
            $manager = new ImageManager($driver);
            // instancia nueva
            $image = $manager->read($original->getPathname()); // leer desde el path temporal

            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Codificamos como JPG o PNG antes de guardar
            $encoded = $image->encode(); // por defecto JPG

            Storage::put("public/products/resized/{$filename}", (string) $encoded);
            Storage::putFileAs('public/products/original', $original, $filename);

            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        return view('admin.product.edit', [
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
            'name' => 'required|max:255',
            'slug' => 'required|unique:products,slug,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O campo :attribute já está em uso.',
            'numeric' => 'O campo :attribute deve ser numérico.',
            'image' => 'O campo :attribute deve ser uma imagem válida.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'min' => 'O campo :attribute deve ser no mínimo :min.',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $original = $request->file('image');
            $filename = time() . '.' . $original->getClientOriginalExtension();

            $driver = new Driver();
            $manager = new ImageManager($driver);
            // instancia nueva
            $image = $manager->read($original->getPathname());

            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $encoded = $image->encode();

            Storage::put("public/products/resized/{$filename}", (string) $encoded);
            Storage::putFileAs('public/products/original', $original, $filename);

            $data['image'] = $filename;
        }


        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto movido para lixeira.');
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('products.index')->with('success', 'Produto restaurado com sucesso!');
    }

    public function exportPdf()
    {
        $products = Product::with('category', 'winery')->get();
        $pdf = PDF::loadView('admin.product.exports.pdf', compact('products'));
        return $pdf->download('produtos.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'produtos.xlsx');
    }
}
