<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\Winery;
use Illuminate\Support\Str;

class WineryController extends CustomBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wineries = Winery::latest()->paginate(10);
        return view('admin.winery.index', compact('wineries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:wineries,name',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'Já existe uma vinícola com este nome.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ]);

        Winery::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('wineries.index')->with('success', 'Vinícola criada com sucesso!');
    }

    public function edit(Winery $winery)
    {
        return view('admin.winery.edit', compact('winery'));
    }

    public function update(Request $request, Winery $winery)
    {
        $request->validate([
            'name' => 'required|max:255|unique:wineries,name,' . $winery->id,
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'Já existe uma vinícola com este nome.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ]);

        $winery->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('wineries.index')->with('success', 'Vinícola atualizada com sucesso!');
    }

    public function destroy(Winery $winery)
    {
        $winery->delete();
        return redirect()->route('wineries.index')->with('success', 'Bodega excluída com sucesso!');
    }
}
