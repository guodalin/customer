<?php

namespace App\Http\Middleware;

use App\Helpers\General\MenuHelper;
use Closure;

class BackendMenu
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
        (new MenuHelper())->usingBackendMenu()->build();

        return $next($request);
    }
}
