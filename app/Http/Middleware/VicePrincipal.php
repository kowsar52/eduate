<?php

namespace App\Http\Middleware;

use Closure;

class VicePrincipal
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
        if ($request->user()->user_type != 'vice_principal')
        {
           return redirect('/');
        }
        return $next($request);
    }
}
