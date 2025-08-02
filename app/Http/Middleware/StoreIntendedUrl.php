<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreIntendedUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika request memiliki parameter 'redirect_to'
        if ($request->has('redirect_to')) {
            // Simpan URL tersebut ke dalam session dengan key 'url.intended'
            session(['url.intended' => $request->query('redirect_to')]);
        }

        return $next($request);
    }
}