<?php

namespace App\Http\Middleware;

class CheckBanned
{
    public function handle($request, $next)
    {
        if (auth()->check() && auth()->user()->isBanned()) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your account has been banned.');
        }
        return $next($request);
    }
}