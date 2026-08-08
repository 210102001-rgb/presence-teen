<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCacheHeaders
{
    /**
     * Tambahkan header no-cache pada semua halaman authenticated
     * agar browser tidak menyimpan snapshot halaman (bfcache).
     * Ini mencegah bug di mana halaman role lain masih tampil
     * setelah logout dan login dengan role berbeda.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya apply ke response HTML (bukan asset/API)
        if ($response instanceof \Illuminate\Http\Response) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }
}
