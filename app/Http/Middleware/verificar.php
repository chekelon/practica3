<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class verificar
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
        
        if($request->user()->email_verified_at!=null){
            return $next($request);
        }else{
            return response()->json("Favor de activar  tu cuenta",401);
        }
        
    }
}
