<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\pruebaMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    
   


   

    public function LogIn(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        $user=User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email|password'=>['Datos Incorrectos']
            ]);
        }
        if($user->TipoUser == 'admin')
        {
            $token=$user->createToken($request->email, ['admin:admin'])->plainTextToken;
            
            return response()->json(["token"=>$token,"email"=>$user->email,"user"=>$user->tokenCan("admin:admin")],201);
        }
        elseif($user->TipoUser=='vendedor')
        {
            $token=$user->createToken($request->email, ['user:vendedor'])->plainTextToken;
            
            return response()->json(["token"=>$token,"email"=>$user->email,"user"=>$user->tokenCan("user:vendedor")],201);
                
            
        }else{
                $token=$user->createToken ($request->email,['user:info'])->plainTextToken;
                return response()->json(["token"=>$token],201);
        }

        
    }

    public function Logout(Request $request)
    {
        //return response()->json(["Destroyed"=>$request->user()->token()->delete()],200);
        return response()->json(["destroyed" => $request->user()->tokens()->delete()],200);
    }

    
}
