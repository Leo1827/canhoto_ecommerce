<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\UserAddress;
use App\Services\MoloniService;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.moloni.api');
    }
    //
    public function index()
    {
        $customers = User::with('orders')->get(); // 🔹 trae todos los usuarios
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', // confirmed espera un campo password_confirmation
            'usertype' => 'required|in:user,admin',   // asegura que solo sea user/admin
        ]);

        // Crear cliente
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // forma recomendada
            'usertype' => $request->usertype,
        ]);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Cliente criado corretamente.');
    }

    public function showAddress(User $user)
    {
        $user->load(['orders', 'addresses']);
        return view('admin.customers.showAddress', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.customers.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id), // ✅ ignora el correo del propio usuario
            ],
            'usertype' => 'required|string|in:user,admin',
        ]);

        $user->update($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Cliente atualizado corretamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Cliente eliminado');
    }

    public function storeAddress(Request $request, User $user)
    {
        $validated = $request->validate([
            'full_name'   => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'state'       => 'required|string|max:100',
            'country'     => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone'       => 'nullable|string|max:20',
        ]);

        $user->addresses()->create($validated);

        return redirect()
            ->route('admin.customers.showAddress', $user->id)
            ->with('success', 'Endereço adicionado com sucesso.');
    }

    public function destroyAddress(User $user, UserAddress $address)
    {
        // Nos aseguramos de que la dirección pertenece al usuario
        if ($address->user_id !== $user->id) {
            return back()->with('error', 'Endereço não pertence a este cliente.');
        }

        $address->delete();

        return redirect()
            ->route('admin.customers.showAddress', $user->id)
            ->with('success', 'Endereço excluído com sucesso.');
    }


}
