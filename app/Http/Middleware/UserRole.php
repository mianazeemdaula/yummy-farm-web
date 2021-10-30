<?php

namespace App\Http\Middleware;

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
        if (!Auth::check())
            return redirect('login');
        $user = Auth::user();
        $roles = explode(',', $roles);
        if(in_array($user->role, $roles))
            return $next($request);
        return redirect('login');
    }
}
