<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customers = User::with('orders')->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Cliente creado correctamente');
    }

    public function show(User $user)
    {
        $user->load(['orders', 'addresses', 'termAcceptances']);
        return view('admin.customers.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.customers.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('admin.customers.index')->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Cliente eliminado');
    }
}
