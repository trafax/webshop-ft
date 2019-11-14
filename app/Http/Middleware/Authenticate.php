<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if($request->user()) {
            if (isset($guards[0]) && $request->user()->role != $guards[0]) {
                return redirect()->to('/');
            }
            return $next($request);
        }
        else {
            return redirect()->to('/');
        }
    }
}
