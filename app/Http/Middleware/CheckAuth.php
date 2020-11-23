<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckAuth
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
        try{
            $usuario=User::where('email',$request->email)->first();
            if($usuario!=null){
                if($usuario->email==$request->email&&Hash::check($request->password,$usuario->password))
                {
                
                    return $next($request);
                }
                else{
                    //return  abort(400,"Usuario no Autorizado");
                    return response()->json("Email o Password incorrecto....",400);
                }
            }else{
                return response()->json("Email o Password incorrecto....",400);
            }

        }catch(ModelNotFoundException $e)
        {
            //return  abort(400,"Usuario no Autorizado");
            return response()->json("Usuario no Autorizado....",404);
        }
       
        
        
    }
}
