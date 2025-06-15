<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Ya está verificado, verificamos si tiene suscripción activa
            return $this->redirectAfterVerification($request);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectAfterVerification($request);
    }

    protected function redirectAfterVerification(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if (method_exists($user, 'hasActiveSubscription') && $user->hasActiveSubscription()) {
            return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
        }

        return redirect()->route('plan.index');
    }

}
