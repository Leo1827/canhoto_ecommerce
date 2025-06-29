<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Currency;

class PlansController extends Controller
{
    /**
     * Muestra todos los planes.
     */
    public function index()
    {
        $plans = Plan::with('currency')->get(); // con relación
        $currencies = Currency::where('is_active', true)->get();
        return view('admin.plans.index', compact('plans', 'currencies'));
    }

    /**
     * Cambia el estado del plan.
     */
    public function toggleActive(Plan $plan)
    {
        $plan->is_active = !$plan->is_active;
        $plan->save();

        return response()->json(['success' => true, 'is_active' => $plan->is_active]);
    }

    /**
     * Guarda un nuevo plan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'features' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'interval' => 'required|in:monthly,yearly,weekly',
            'stripe_id' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'currency_id' => 'required|exists:currencies,id',
        ]);

        Plan::create([
            'name' => $request->name,
            'features' => $request->features,
            'price' => $request->price,
            'interval' => $request->interval,
            'stripe_id' => $request->stripe_id,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
            'currency_id' => $request->currency_id,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Plan creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un plan.
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        $currencies = Currency::where('is_active', true)->get();
        return view('admin.plans.edit', compact('plan', 'currencies'));
    }

    /**
     * Actualiza un plan existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'features' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'interval' => 'required|in:monthly,yearly,weekly',
            'stripe_id' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'currency_id' => 'required|exists:currencies,id',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->update([
            'name' => $request->name,
            'features' => $request->features,
            'price' => $request->price,
            'interval' => $request->interval,
            'stripe_id' => $request->stripe_id,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
            'currency_id' => $request->currency_id,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Plan actualizado correctamente.');
    }

    /**
     * Elimina un plan.
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Plan eliminado correctamente.');
    }
}
