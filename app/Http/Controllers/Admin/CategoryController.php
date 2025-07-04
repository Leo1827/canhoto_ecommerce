<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends CustomBaseController
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $parentId = $request->get('parent', 0);
        $module = $request->get('module', 1); // valor por defecto
        $categories = Category::where('parent', $parentId)->where('module', $module)->get();

        return view('admin.categories.index', compact('categories', 'module'));
    }

    public function subcategories($parent)
    {
        $parentCategory = Category::findOrFail($parent);
        $module = $parentCategory->module;

        // Trae las subcategorías de esa categoría padre
        $categories = Category::where('parent', $parent)->get();

        // Trae todas las categorías principales (parent = 0) para asignar un nuevo padre si se desea
        $allCategories = Category::where('parent', 0)->where('module', $module)->get();

        return view('admin.categories.subcategories', compact('categories', 'parentCategory', 'module', 'allCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'module' => 'required|integer',
            'parent' => 'nullable|integer',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // genera slug automáticamente
            'module' => $request->module,
            'parent' => $request->parent ?? 0,
        ]);

        return redirect()->route('categories.index', ['module' => $request->module])
                        ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(Category $category)
    {
        $allCategories = Category::where('id', '!=', $category->id)
                                ->where('module', $category->module)
                                ->get();

        return view('admin.categories.edit', compact('category', 'allCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'parent' => 'nullable|integer',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent' => $request->parent ?? 0,
            'module' => $category->module,
        ]);

        return redirect()->route('categories.index', ['module' => $category->module])
                        ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoria excluída com sucesso!');
    }
}
