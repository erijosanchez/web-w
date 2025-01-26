<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check() || !auth()->user()->role_id) {
            return redirect('admin/auth/web-w/login');
        }

        $userRoleId = auth()->user()->role_id;
        
        // Super Admin puede ver todo
        if ($userRoleId === 4) {
            return $next($request);
        }

        // Admin normal solo puede ver su nivel o inferior
        if ($userRoleId === 5) {
            if (in_array('superadmins', $roles)) {
                abort(403);
            }
            return $next($request);
        }

        // Supervisores no pueden ver nada
        if ($userRoleId === 6) {
            abort(403);
        }

        return redirect('admin/auth/web-w/login');
    }
}
