<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Route-route ini memang khusus untuk role tertentu saja —
     * super_admin tidak perlu mengaksesnya.
     */
    protected array $strictRoleRoutes = [
        'siswa',
        'orang_tua',
    ];

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            abort(403, 'Unauthorized');
        }

        $userRole = $request->user()->role;

        // Super admin bypass semua role check,
        // KECUALI route yang memang khusus siswa / orang_tua
        if ($userRole === 'super_admin') {
            $isStrictRoute = count(array_intersect($roles, $this->strictRoleRoutes)) > 0
                          && ! in_array('guru', $roles)
                          && ! in_array('super_admin', $roles);

            if ($isStrictRoute) {
                abort(403, 'Halaman ini khusus untuk ' . implode(' / ', $roles) . '.');
            }

            return $next($request);
        }

        if (! in_array($userRole, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
