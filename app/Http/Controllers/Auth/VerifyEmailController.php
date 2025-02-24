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
            return $this->redirectBasedOnRole($request);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectBasedOnRole($request);
    }

    private function redirectBasedOnRole($request): RedirectResponse
    {
        $route = $request->user()->role === 'admin' ? 'admin.dashboard' : 'student.dashboard';
        return redirect()->intended(route($route).'?verified=1');
    }
}
