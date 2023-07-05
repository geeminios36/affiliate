<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\BusinessSetting;

class CheckAppUrlMiddleware
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
        if (env('APP_ENV') == 'local' || empty(env('APP_ENV'))) {
            return $next($request);
        }
        if (Auth::check()) {
            return $next($request);
            // if (Auth::user()->tenacy_id != 'all') {
            //     if (strlen(strstr(env('APP_URL'), Auth::user()->tenacy_id)) > 0) {
            //         return $next($request);
            //     } else {
            //         auth()->logout();
            //         session(['link' => url()->current()]);
            //         return redirect()->route('user.login');
            //     }
            // } else {
            //     if (strlen(strstr(env('APP_URL'), 'v2.')) > 0) {
            //         return $next($request);
            //     } else {
            //         auth()->logout();
            //         session(['link' => url()->current()]);
            //         return redirect()->route('user.login');
            //     }
            // }
           
        } else {
            return $next($request);
        }
    }
}
