<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ClosedSite
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
        if (Auth::check()){
            $user = Auth::user();
            if($user->isAdmin() || $user->email=="tester@olastivos.com")
                return $next($request);
        }
        abort(404);
    }
}
