<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Carbon;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Buscar usuario existente por google_id o por email (opcionalmente)
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if (!$user) {
                // Si no existe, crear usuario nuevo
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => Carbon::now(),
                    'usertype' => 'user', // aseguras que sea user
                    'password' => bcrypt('google_' . $googleUser->getId()),
                ]);
            } else {
                // Si existe pero no tiene google_id, se lo asignamos
                if (is_null($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                }
            }

            // Autenticar
            Auth::login($user);

            // Redirección según tipo
            if ($user->usertype === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (!$user->hasActiveSubscription()) {
                return redirect()->route('plan.index');
            }

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Error al iniciar sesión con Google.');
        }
    }
}
