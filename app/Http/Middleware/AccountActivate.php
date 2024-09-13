<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
class AccountActivate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::user()->is_active){
            Auth::logout(); //auth()->logout();
            return redirect('login')->withSuccess('Your account is not acivated. Please check your email inbox/spam folder for activation email sent by Car Service.');
        }

        return $next($request);
    }
}
