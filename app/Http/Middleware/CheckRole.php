<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Kalau role tidak cocok, arahkan ke dashboard sesuai role-nya
        if (!in_array($user->role, $roles)) {
            if ($user->role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            } elseif ($user->role === 'bansus') {
                return redirect()->route('bansus.dashboard');
            } else {
                return redirect('/'); // fallback untuk role lain
            }
        }

        return $next($request);
    }
}
