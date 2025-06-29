<?php

namespace App\Http\Controllers\Admin;
use App\Models\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    //
    public function index()
    {
        $currencies = Currency::orderBy('id', 'desc')->get();
        return view('admin.currencies.index', compact('currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:3|unique:currencies,code',
            'name' => 'required|string|max:100',
            'symbol' => 'required|string|max:5',
            'rate' => 'required|numeric|min:0',
        ]);

        Currency::create($request->all());

        return redirect()->route('admin.currencies.index')->with('success', 'Moeda criada com sucesso.');
    }

    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'code' => 'required|string|max:3|unique:currencies,code,' . $currency->id,
            'name' => 'required|string|max:100',
            'symbol' => 'required|string|max:5',
            'rate' => 'required|numeric|min:0',
        ]);

        $currency->update($request->all());

        return redirect()->route('admin.currencies.index')->with('success', 'Moeda atualizada com sucesso.');
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();

        return redirect()->route('admin.currencies.index')->with('success', 'Moeda removida.');
    }

    public function toggleActive(Currency $currency)
    {
        $currency->is_active = !$currency->is_active;
        $currency->save();

        return response()->json(['success' => true, 'active' => $currency->is_active]);
    }
}
