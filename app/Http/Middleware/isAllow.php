<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAllow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isValid=\App\Helpers\Akses::isValid();
        if(!$isValid['status']){
            return response()->json([
                'metadata'=>[
                    'code'=>401,
                    'message'=>$isValid['message']
                ]
            ]);
        }
        return $next($request);
    }
}
