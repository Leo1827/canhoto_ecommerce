<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomBaseController;
use Illuminate\Http\Request;
use App\Models\Condition;

class ConditionController extends CustomBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $conditions = Condition::orderBy('name')->get();
        return view('admin.condition.index', compact('conditions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:conditions,name',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'Esta condição já existe.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ]);

        Condition::create($request->only('name'));

        return redirect()->route('conditions.index')->with('success', 'Condição criada com sucesso!');
    }

    public function edit(Condition $condition)
    {
        return view('admin.condition.edit', compact('condition'));
    }

    public function update(Request $request, Condition $condition)
    {
        $request->validate([
            'name' => 'required|max:255|unique:conditions,name,' . $condition->id,
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'Esta condição já está em uso.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ]);

        $condition->update($request->only('name'));

        return redirect()->route('conditions.index')->with('success', 'Condição atualizada com sucesso!');
    }

    public function destroy(Condition $condition)
    {
        $condition->delete();
        return back()->with('success', 'Condição excluída com sucesso!');
    }
}
