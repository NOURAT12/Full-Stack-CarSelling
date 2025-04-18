<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        if ($request->user()->Role != 'admin') {
            return $request->expectsJson()
                ? abort(403, 'you not seller')
                : Redirect::guest(URL::route($redirectToRoute ?: 'welcome'));
        }

        return $next($request);
    }
}
