<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsFactory
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
        if (Auth::check() && (Auth::user()->user_type == 'staff' && str_contains(Auth::user()->staff->role->name, 'Factory'))) {
            flash(translate('You have no permission to access this page'))->error();
            return back();
        } else {
            return $next($request);
        }
    }
}
