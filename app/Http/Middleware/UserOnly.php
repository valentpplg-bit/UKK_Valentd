<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $role = Auth::user()?->role;

        if (!Auth::check() || !in_array($role, ['anggota', 'user'], true) || Auth::user()->status !== 'aktif') {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun user tidak aktif atau tidak memiliki akses.',
            ]);
        }

        return $next($request);
    }
}