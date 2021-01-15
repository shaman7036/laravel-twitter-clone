<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = $request->session()->get('auth') ? $request->session()->get('auth') : null;
        if ($request->method() != 'GET' && $auth == null) {
            return abort(401, 'Unauthorized');
        }
        $request->attributes->add(['auth_id' => $auth->id, 'auth_username' => $auth->username]);

        return $next($request);
    }
}
