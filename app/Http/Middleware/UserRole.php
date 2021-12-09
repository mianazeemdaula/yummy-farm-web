<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $user = $request->user();
        $roles = explode(',', $roles);
        if(in_array($user->role, $roles))
            return $next($request);
        return abort(401,'unathorized');
    }
}
