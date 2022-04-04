<?php

namespace JeffersonSimaoGoncalves\MultitenancyNovaTool\Http\Middleware;

use JeffersonSimaoGoncalves\MultitenancyNovaTool\MultitenancyNovaTool;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(MultitenancyNovaTool::class)->authorize($request) ? $next($request) : abort(403);
    }
}
