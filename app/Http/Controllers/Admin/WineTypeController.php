<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\WineType;
use Illuminate\Support\Str;

class WineTypeController extends CustomBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wineTypes = WineType::latest()->paginate(10);
        return view('admin.wine_type.index', compact('wineTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:wine_types,name',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'Este tipo de vinho já está cadastrado.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ]);

        WineType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('wine_types.index')->with('success', 'Tipo de vinho criado com sucesso!');
    }

    public function edit(WineType $wineType)
    {
        return view('admin.wine_type.edit', compact('wineType'));
    }

    public function update(Request $request, WineType $wineType)
    {
        $request->validate([
            'name' => 'required|max:255|unique:wine_types,name,' . $wineType->id,
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'Este tipo de vinho já está em uso.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ]);

        $wineType->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('wine_types.index')->with('success', 'Tipo de vinho atualizado com sucesso!');
    }

    public function destroy(WineType $wineType)
    {
        $wineType->delete();
        return redirect()->route('wine_types.index')->with('success', 'Tipo de vinho excluído com sucesso!');
    }
}

