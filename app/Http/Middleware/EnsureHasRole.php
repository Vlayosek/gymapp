<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            return response()->json(['status' => Response::HTTP_UNAUTHORIZED, 'message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        if (!$request->user()->hasRole($role)) {
            return response()->json(['status' => Response::HTTP_FORBIDDEN, 'message' => 'Forbidden'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
