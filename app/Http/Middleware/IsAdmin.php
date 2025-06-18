<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login DAN apakah dia seorang admin (is_admin == true)
        if (Auth::check() && Auth::user()->is_admin) {
            // Jika ya, izinkan dia melanjutkan
            return $next($request);
        }

        // Jika tidak, kembalikan dia ke halaman utama dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki hak akses sebagai Admin.');
    }
}
