<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Providers\RouteServiceProvider1;
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
            $user = auth()->user()->Role;
            if ($user == 'seller') {
                return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            } else {
                return redirect()->intended(RouteServiceProvider1::HOME.'?verified=1');
            }
            // return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        
        $user = auth()->user()->Role;
        if ($user == 'seller') {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        } else {
            return redirect()->intended(RouteServiceProvider1::HOME.'?verified=1');
        }
        // return redirect()->intended(default: RouteServiceProvider::HOME.'?verified=1');
    }
}
