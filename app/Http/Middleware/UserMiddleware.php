<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|\Illuminate\Contracts\Auth\MustVerifyEmail $user */
        $user = Auth::user();

        if ($user && $user->usertype === 'user') {
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            return $next($request);
        }

        return redirect()->back();
    }
}
