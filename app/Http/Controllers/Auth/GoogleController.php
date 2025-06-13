<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Carbon;

class GoogleController extends Controller
{
    //
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            /** @var \Laravel\Socialite\Two\GoogleProvider $googleDriver */
            $googleDriver = Socialite::driver('google');

            $googleUser = $googleDriver->stateless()->user();

            // Buscar usuario existente
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Si no existe, crear uno nuevo
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => Carbon::now(), // marca el email como verificado
                    'password' => bcrypt('google_' . $googleUser->getId()), // o puedes dejarlo null si no usas contraseña
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/dashboard'); // o tu página principal
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Falló el inicio con Google.');
        }
    }
}
