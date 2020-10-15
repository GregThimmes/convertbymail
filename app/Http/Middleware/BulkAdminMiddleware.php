<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class BulkAdminMiddleware
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
        if(!Auth::user()->isBulk()){
            return redirect('/');
        }
        return $next($request);
    }
}
