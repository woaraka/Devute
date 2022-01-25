<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PageAssignMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $pageID)
    {
        if(isset(Auth::user()->page_permission)) {
            foreach (Auth::user()->page_permission as $permission) {
                if ($permission->id == $pageID)
                    return $next($request);
            }
        }
        return redirect('/home');
    }
}
