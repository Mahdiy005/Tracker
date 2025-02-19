<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Helpers\ApiResponseSchema;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user() && $request->user()->role === UserRole::ADMIN->value)
        {
            return $next($request);
        }
        return ApiResponseSchema::sendResponse(403, 'Unauthrized Access');
    }
}
