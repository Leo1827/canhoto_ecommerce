<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Winery;
use App\Models\Region;
use App\Models\WineType;
use App\Models\Vintage;
use App\Models\Condition;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use App\Models\ProductGallery;


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

        // Relacionados para los filtros en la vista
        $categories = \App\Models\Category::all();
        $wineries = \App\Models\Winery::all();
        $regions = \App\Models\Region::all();
        $wineTypes = \App\Models\WineType::all();
        $vintages = \App\Models\Vintage::all();
        $conditions = \App\Models\Condition::all();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'wineries',
            'regions',
            'wineTypes',
            'vintages',
            'conditions'
        ));
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
            'taxes' => Tax::all(),
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
            'tax_id' => 'nullable|exists:taxes,id',
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

            Storage::disk('public')->put("products/resized/{$filename}", (string) $encoded);
            Storage::disk('public')->putFileAs('products/original', $original, $filename);


            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
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
            'taxes' => Tax::all(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser numérico.',
            'image' => 'O campo :attribute deve ser uma imagem válida.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'min' => 'O campo :attribute deve ser no mínimo :min.',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            // 1. Eliminar imágenes antiguas si existen
            if ($product->image) {
                $resizedPath = "products/resized/{$product->image}";
                $originalPath = "products/original/{$product->image}";

                Storage::disk('public')->delete([$resizedPath, $originalPath]);
            }

            // 2. Guardar nueva imagen
            $original = $request->file('image');
            $filename = time() . '.' . $original->getClientOriginalExtension();

            $driver = new Driver();
            $manager = new ImageManager($driver);

            $image = $manager->read($original->getPathname());
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $encoded = $image->encode();

            Storage::disk('public')->put("products/resized/{$filename}", (string) $encoded);
            Storage::disk('public')->putFileAs('products/original', $original, $filename);

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

    // switch toggle
    public function toggleActive(Product $product)
    {
        $product->status = !$product->status;
        $product->save();

        return response()->json([
            'status' => $product->status
        ]);
    }

    // produtc gallery
    public function uploadGalleryImage(Request $request, Product $product)
    {
        $request->validate([
            'gallery_image' => 'required|image|max:5120'
        ]);

        $original = $request->file('gallery_image');
        $filename = time() . '_' . uniqid() . '.' . $original->getClientOriginalExtension();

        // Crear instancia del driver GD
        $driver = new Driver();
        $manager = new ImageManager($driver);

        // Redimensionar
        $image = $manager->read($original->getPathname());
        $image->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Guardar la imagen redimensionada
        $resizedPath = "products_gallery/resized/{$filename}";
        Storage::disk('public')->put($resizedPath, (string) $image->encode());

        // Guardar la original
        $originalPath = "products_gallery/original/{$filename}";
        Storage::disk('public')->putFileAs('products_gallery/original', $original, $filename);

        // Guardar en la base de datos
        $gallery = $product->galleries()->create([
            'file_path' => $resizedPath,
            'file_name' => $filename,
        ]);

        return response()->json([
            'id' => $gallery->id,
            'file_path' => $resizedPath,
        ]);
    }

    public function deleteGalleryImage(ProductGallery $gallery)
    {
        // Eliminar de storage
        Storage::disk('public')->delete($gallery->file_path);
        Storage::disk('public')->delete('products_gallery/original/' . $gallery->file_name);

        // Eliminar de la base de datos
        $gallery->delete();

        return response()->json(['success' => true]);
    }



}
