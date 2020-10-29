<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ServerOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (($_SERVER['HTTP_CF_CONNECTING_IP'] ?? $request->ip()) !== '127.0.0.1') {
            abort(404);
        }
        
        return $next($request);
    }
}