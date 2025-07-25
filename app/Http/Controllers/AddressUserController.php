<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class AddressUserController extends Controller
{
    // user address
    public function storeAddress(Request $request)
    {
        $request->validate([
            'full_name'    => 'required|string|max:255',
            'address'      => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'state'        => 'nullable|string|max:100',
            'country'      => 'required|string|max:100',
            'postal_code'  => 'required|string|max:20',
            'phone'        => 'nullable|string|max:20',
        ]);

        UserAddress::create([
            'user_id'     => Auth::id(),
            'full_name'   => $request->full_name,
            'address'     => $request->address,
            'city'        => $request->city,
            'state'       => $request->state,
            'country'     => $request->country,
            'postal_code' => $request->postal_code,
            'phone'       => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Endereço salvo com sucesso!');
    }

    // Actualizar dirección
    public function update(Request $request, UserAddress $address)
    {
        $request->validate([
            'full_name'    => 'required|string|max:255',
            'address'      => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'state'        => 'nullable|string|max:100',
            'country'      => 'required|string|max:100',
            'postal_code'  => 'required|string|max:20',
            'phone'        => 'nullable|string|max:20',
        ]);

        $address->update($request->only([
            'full_name', 'address', 'city', 'state', 'country', 'postal_code', 'phone'
        ]));

        // Devuelve los datos actualizados como JSON
        return response()->json($address);
    }

    // Eliminar dirección
    public function destroy(UserAddress $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $address->delete();

        return back()->with('success', 'Dirección eliminada exitosamente.');
    }

}
