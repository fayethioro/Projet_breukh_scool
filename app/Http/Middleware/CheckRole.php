<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {

        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            return $next($request);

        }
        return[
             'statutCode' =>Response::HTTP_NON_AUTHORITATIVE_INFORMATION,
              'message' => 'Accès interdit.'];
    }
}

