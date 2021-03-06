<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('token');
        if (! $token) {
            return apiReturn(ERROR, '缺少token');
        }
        if (! getUserId()) {
            return apiReturn(UNAUTHORIZED, 'token无效');
        }

        return $next($request);
    }
}