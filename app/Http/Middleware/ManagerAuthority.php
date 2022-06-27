<?php

namespace App\Http\Middleware;

use App\Support\Enums\UserRoleKeyEnum;
use App\Support\ResponseMessage;
use Closure;
use Illuminate\Http\Request;

class ManagerAuthority
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user->isManager){
            return ResponseMessage::unauthorized();
        }

        return $next($request);
    }
}
