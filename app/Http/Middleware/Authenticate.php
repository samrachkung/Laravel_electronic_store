<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        if (empty($guards)) {
            // Automatically detect guard based on route prefix
            if ($request->is('admin*')) {
                $guards = ['admin'];
            } else {
                $guards = [null]; // Default guard
            }
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Handle admin authentication redirect
        if ($request->is('admin*')) {
            return route('admin.login');
        }

        // Handle API authentication response
        if ($request->is('api*')) {
            abort(response()->json([
                'message' => 'Unauthenticated',
                'status' => 401
            ], 401));
        }

        // Default frontend login route
        return route('frontend.login');
    }
}
