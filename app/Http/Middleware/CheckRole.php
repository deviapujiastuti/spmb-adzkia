<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. JIKA RUTE INI UNTUK PENDAFTAR (USER)
        if (in_array('user', $roles)) {
            if (session('is_pendaftar')) {
                return $next($request); // Silakan masuk
            }
            // Jika belum login, tendang ke login mahasiswa
            return redirect('/login')->with('error', 'Silakan login dengan No. Pendaftaran Anda.');
        }

        // 2. JIKA RUTE INI UNTUK ADMIN / SUPER ADMIN
        if (in_array('admin', $roles) || in_array('super_admin', $roles)) {
            if (Auth::check()) {
                $userRole = Auth::user()->role;
                
                // Jika rolenya sesuai (contoh: super_admin mau masuk ke menu super_admin)
                if (in_array($userRole, $roles)) {
                    return $next($request);
                }
                
                // Jika Admin biasa mencoba membuka halaman Super Admin
                return redirect('/admin')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
            }

            // Jika BELUM LOGIN sama sekali tapi mencoba buka URL /admin...
            // TENDANG KE LOGIN ADMIN!
            return redirect('/login-admin')->with('error', 'Akses ditolak. Silakan login sebagai Admin.');
        }

        return redirect('/');
    }
}