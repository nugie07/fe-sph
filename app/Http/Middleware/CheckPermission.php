<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\PermissionHelper;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission = null, $action = null, $subMenu = null)
    {
        // Check if user is authenticated
        if (!session('api_token')) {
            return redirect()->route('login');
        }

        // If no permission specified, just check if user is logged in
        if (!$permission) {
            return $next($request);
        }

        // Check permission based on parameters
        $hasAccess = false;

        if ($action && $subMenu) {
            $hasAccess = PermissionHelper::hasActionAccess($permission, $action, $subMenu);
        } elseif ($action) {
            $hasAccess = PermissionHelper::hasActionAccess($permission, $action);
        } elseif ($subMenu) {
            // For submenu access, also check if user has menu access
            $hasAccess = PermissionHelper::hasSubMenuAccess($permission, $subMenu) ||
                        PermissionHelper::hasMenuAccess($permission);
        } else {
            $hasAccess = PermissionHelper::hasMenuAccess($permission);
        }



        if (!$hasAccess) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You don\'t have access to this page'
                ], 403);
            }

            abort(403, 'You don\'t have access to this page');
        }

        return $next($request);
    }
}
