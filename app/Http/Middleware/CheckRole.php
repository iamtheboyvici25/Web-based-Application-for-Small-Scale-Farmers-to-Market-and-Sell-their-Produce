<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
   public function handle(Request $request, Closure $next, string $role): Response
    {
        // If the user isn't logged in, or their database role doesn't match the required route role...
        if (!$request->user() || $request->user()->role !== $role) {
            // Turn them away with a 403 Forbidden error
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
