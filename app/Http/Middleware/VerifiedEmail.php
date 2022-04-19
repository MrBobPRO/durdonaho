<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class VerifiedEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            if(!Auth::user()->verified_email) {
                $currentRoute = Route::currentRouteName();
                if($currentRoute != 'verification.notice') {
                    //ignore routes which may enter without verifying emal
                    if($currentRoute == 'logout' || $currentRoute == 'verification.verify' || $currentRoute == 'verification.resend.email' || $currentRoute == 'password.reset.show' || $currentRoute == 'password.reset.update') {
                        return $next($request);
                    } else {
                        return redirect()->route('verification.notice');
                    }
                }
            }
        }

        return $next($request);
    }
}