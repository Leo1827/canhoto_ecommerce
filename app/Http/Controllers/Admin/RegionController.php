<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\Region;

use Illuminate\Support\Str;

class RegionController extends CustomBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $regions = Region::latest()->paginate(10);
        return view('admin.regions.index', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:regions,name',
            'country' => 'required|max:100',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'Já existe uma região com este nome.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ]);

        Region::create([
            'name' => $request->name,
            'country' => $request->country,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('regions.index')->with('success', 'Região criada com sucesso!');
    }

    public function edit(Region $region)
    {
        return view('admin.regions.edit', compact('region'));
    }

    public function update(Request $request, Region $region)
    {
        $request->validate([
            'name' => 'required|max:255',
            'country' => 'required|max:100',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ]);

        $region->update([
            'name' => $request->name,
            'country' => $request->country,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('regions.index')->with('success', 'Região atualizada com sucesso!');
    }

    public function destroy(Region $region)
    {
        $region->delete();
        return redirect()->route('regions.index')->with('success', 'Região excluída com sucesso!');
    }
}
