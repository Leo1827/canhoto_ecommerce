<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasPlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */

        $user = Auth::user();

        // Usamos tu método personalizado
    if ($user && $user->hasActiveSubscription()) {
        return $next($request);
    }

    // Redirige si no tiene plan activo
    return redirect()->route('plan.index');
    }
}
