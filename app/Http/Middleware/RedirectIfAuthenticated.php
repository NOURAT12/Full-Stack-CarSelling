<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Providers\RouteServiceProvider1;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = auth()->user()->Role;
                if ($user == 'seller') {
                    return redirect(RouteServiceProvider::HOME);
                } else {
                    return redirect(RouteServiceProvider1::HOME);
                }
            }
        }

        return $next($request);
    }
}
