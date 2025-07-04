<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\Vintage;

class VintageController extends CustomBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vintages = Vintage::latest()->paginate(10);
        return view('admin.vintage.index', compact('vintages'));
    }

    public function create()
    {
        return view('admin.vintages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:1800|max:' . date('Y'),
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser um número.',
            'min' => 'O ano mínimo permitido é 1800.',
            'max' => 'O ano não pode ser maior que o atual.',
        ]);

        Vintage::create($request->only('year'));

        return redirect()->route('vintages.index')->with('success', 'Safra criada com sucesso!');
    }

    public function edit(Vintage $vintage)
    {
        return view('admin.vintage.edit', compact('vintage'));
    }

    public function update(Request $request, Vintage $vintage)
    {
        $request->validate([
            'year' => 'required|integer|min:1800|max:' . date('Y'),
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser um número.',
            'min' => 'O ano mínimo permitido é 1800.',
            'max' => 'O ano não pode ser maior que o atual.',
        ]);

        $vintage->update($request->only('year'));

        return redirect()->route('vintages.index')->with('success', 'Safra atualizada com sucesso!');
    }

    public function destroy(Vintage $vintage)
    {
        $vintage->delete();
        return redirect()->route('admin.vintage.index')->with('success', 'Safra excluída com sucesso!');
    }
}
