<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    //
     public function index()
    {
        $methods = PaymentMethod::orderBy('id', 'desc')->get();
        return view('admin.methods.index', compact('methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:payment_methods',
            'driver' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_express' => 'nullable|boolean',
            'config' => 'nullable|array', // Asegúrate de validar como array
        ]);

        PaymentMethod::create([
            'name' => $request->name,
            'code' => $request->code,
            'driver' => $request->driver,
            'icon' => $request->icon,
            'order' => $request->order ?? 0,
            'is_express' => $request->boolean('is_express'),
            'config' => $request->input('config', []), // <- aquí se guarda la configuración
        ]);

        return back()->with('success', 'Método de pago criado com sucesso.');
    }

    public function edit($id)
    {
        $method = PaymentMethod::findOrFail($id);
        return view('admin.methods.edit', compact('method'));
    }

    public function update(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:payment_methods,code,' . $id,
            'driver' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_express' => 'nullable|boolean',
            'config' => 'nullable|array',
        ]);

        $method->update([
            'name' => $request->name,
            'code' => $request->code,
            'driver' => $request->driver,
            'icon' => $request->icon,
            'order' => $request->order ?? 0,
            'is_express' => $request->boolean('is_express'),
            'config' => $request->input('config', []),
        ]);

        return redirect()->route('admin.payment_methods.index')->with('success', 'Método actualizado.');
    }


    public function destroy($id)
    {
        PaymentMethod::destroy($id);
        return back()->with('success', 'Método eliminado.');
    }

    public function toggleActive($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->is_active = !$method->is_active;
        $method->save();

        return response()->json(['is_active' => $method->is_active]);
    }

}
