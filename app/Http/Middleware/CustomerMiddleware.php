<?php

namespace App\Http\Middleware;

use Closure;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user() && \Auth::user()->role === 'management') {
            return $next($request);
        }

        \Auth::logout();
        return redirect()->route('customer-login', ['type' => 'customer']);
    }
}
