<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;

class ProductGalleryController extends CustomBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($product_id)
    {
        $product = Product::findOrFail($product_id);
        $galleries = $product->galleries()->latest()->paginate(10);

        return view('admin.products.galleries.index', compact('product', 'galleries'));
    }

    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('admin.products.galleries.create', compact('product'));
    }

    public function store(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);

        $request->validate([
            'image' => 'required|image|max:2048',
        ], [
            'required' => 'A imagem é obrigatória.',
            'image' => 'O arquivo deve ser uma imagem válida.',
            'max' => 'A imagem não pode exceder 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file_path = $file->storeAs('products/gallery', $file_name, 'public');

            $product->galleries()->create([
                'file_name' => $file_name,
                'file_path' => $file_path,
            ]);
        }

        return redirect()->route('admin.products.galleries.index', $product->id)
                         ->with('success', 'Imagem adicionada com sucesso!');
    }

    public function destroy($product_id, $gallery_id)
    {
        $product = Product::findOrFail($product_id);
        $gallery = ProductGallery::where('product_id', $product->id)->findOrFail($gallery_id);

        if ($gallery->file_path && Storage::disk('public')->exists($gallery->file_path)) {
            Storage::disk('public')->delete($gallery->file_path);
        }

        $gallery->delete();

        return redirect()->route('admin.products.galleries.index', $product->id)
                         ->with('success', 'Imagem excluída com sucesso!');
    }
}
