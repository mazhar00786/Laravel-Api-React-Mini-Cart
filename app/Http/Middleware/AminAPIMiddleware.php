<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AminAPIMiddleware
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
        if (Auth::check()) {
            # code...
            if (auth()->user()->tokenCan('server:admin')) {
                # code...
                return $next($request);
            } else {
                # code...
                return response()->json([
                    'message' => 'Access Denied.! U R not an Admin.'
                ], 403);
            }
            
        } else {
            # code...
            return response()->json([
                'status' => 401,
                'message' => 'Please Login to access'
            ]);
        }
        
    }
}
