<?php

namespace App\Http\Middleware\control;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       
        if (auth()->user()->profile != 'super-admin') {

           
            return redirect()->back();

        } else {

            return $next($request);
            
        }
        
    }
}
