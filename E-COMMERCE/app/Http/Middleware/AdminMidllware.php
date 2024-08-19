<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMidllware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $emails=['abdo1223@gmail.com',];
       
        if  (in_array(Auth::user()->email, $emails))  
     return $next($request);
    else 
        return redirect('/unauthorized')->with('error', 'You do not have access to this page.');
    }
}
