<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class UniqueSession
{
    /**
     * Summary of handle
     * 
     * @param mixed $request
     * @param \Closure $next
     * @return mixed
     * 
     */
    public function handle($request, Closure $next): mixed {
        
        // 
        if (!session()->has('unique_session_id')) {
            session(['unique_session_id' => Str::uuid()]);
        }

        //
        return $next($request);
    }
}
