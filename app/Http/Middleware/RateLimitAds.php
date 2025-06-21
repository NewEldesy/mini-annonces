<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RateLimitAds
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $key = 'ads.' . $request->user()->id;

        if ($this->limiter->tooManyAttempts($key, 6)) {
            abort(429, 'Too many attempts. Please try again later.');
        }

        $this->limiter->hit($key, 60); // 1 minute decay

        return $next($request);
    }
}