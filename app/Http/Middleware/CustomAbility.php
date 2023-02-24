<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomAbility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $permission)
    {

        if (!$request->user()->tokenCan($permission)) {
            return response()->json([
                'error' => 'Acesso negado. Você não tem permissão para acessar esse recurso.'
            ], 403);
        }
    
        return $next($request);
    }
}
