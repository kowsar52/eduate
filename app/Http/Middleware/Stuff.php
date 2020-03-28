<?php

namespace App\Http\Middleware;

use Closure;

class Stuff
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
        session_start();                

        if (empty($_SESSION["user"]))
        {
           return redirect('/');
        }
        return $next($request);
    }
}
