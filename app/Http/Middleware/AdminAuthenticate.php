<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminAuthenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }
    public function handle($request, Closure $next)
    {
        $user=auth()->user()->id;
        $user=User::find($user)->first();
        if(!($user->username!== 'nouraltawel33@gmail.com' || Hash::check('12345678', $user->password))){
            dd($user);
            return Inertia::render('Welcome');
        }
        return $next($request);
    }
}
