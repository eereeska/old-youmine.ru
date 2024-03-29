<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ServerOnly
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $request->ip();

        if ($ip !== '127.0.0.1' and $ip !== '178.120.56.51') {
            abort(404);
        }
        
        return $next($request);
    }
}