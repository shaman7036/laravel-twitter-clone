<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Pagination
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
        if ($request->method() == 'GET') {
            // create pagination object
            $pagination = (object)[
                'total' => 0,
                'per_page' => env('TWEETS_PER_PAGE', 10),
                'current_page' => $request->input('page') ? $request->input('page') : 1,
                'page_link' => '',
            ];
            if (strrpos($request->path(), 'following') || strrpos($request->path(), 'followers')) {
                $pagination->per_page = env('USERS_PER_PAGE', 12);
            }
        } else {
            $pagination = null;
        }

        $request->attributes->add(['pagination' => $pagination]);

        return $next($request);
    }
}
