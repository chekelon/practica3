<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Scope;
use App\User;
use App\Comment;
use App\Mail\pruebaMail;
use App\Mail\AccesoDenegadoMail;
use App\Mail\activacionMail;
use App\Mail\modificacionUser;
use App\Mail\eliminarUser;
use Illuminate\Support\Facades\Mail;




class UserController extends Controller
{
    
    

    public function usuarios(Request $request)
    {   
       
        $usuario=User::where('id',$request->user()->id)->first();
        $admin=User::where('TipoUser','admin')->first();
        $accion="Ver todos los usuarios..";
          if($request->user()->tokenCan("admin:admin")||$request->user()->tokenCan("user:vendedor")){
            $user=User::get();
            return response()->json($user,200);
           
        }else{
            Mail::to($admin->email)->send(new AccesoDenegadoMail($request->user(),$accion));
            return response()->json("No tienes Permisos",401);
            
        }

        
    }
    public function mostrar(Request $request,$id)
    {
   
        if($request->user()->tokenCan("admin:admin")){
            $usuario=User::get()->where('id',$id);

            return response()->json($usuario,200);
        }else{
            return response()->json($request->user(),401);
        }
            
        
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
            'name'=>'required',
        ]);
           $created=User::create(['name'=>$request->name,
                         'email'=>$request->email,
                         'password'=>Hash::make($request->password),
                         'TipoUser'=>"user"]);
            $user=User::where('email',$request->email)->first();
            
            Mail::to($request->email)->send(new activacionMail($user));
            return ['created'=>$created,
                    'user'=>$user];
   
    }


    public function comentarios_usuario(Request $request,$id)
    {
        
        
            $comentarios=Comment::get()->where('user_id',$id);
            return response()->json($comentarios,200);
       

        
        
    }

    public function modificar(Request $request,$id)
    {
        $admin=User::where('TipoUser','admin')->first();
        $accion="modificar un usuario...";
        if($request->user()->tokenCan("admin:admin")){
            $user=User::find($id);
            $user->update($request->all());
            Mail::to($user->email)->send(new modificacionUser($user,$accion));
            return ['modified'=>true,"user"=>$user];
        }else{
            Mail::to($admin->email)->send(new AccesoDenegadoMail($request->user(),$accion));
            return response()->json("No tienes permisos...Update",401);
        }
        
    }


    


    public function eliminar(Request $request,$id)
    {
        
        $admin=User::where('TipoUser','admin')->first();
        $accion="Eliminar un usuario...";
        if($request->user()->tokenCan('admin:admin')){
            $user=User::where('id',$id)->first();
            Mail::to($user->email)->send(new eliminarUser($request->user()));
            User::destroy($id);
            return ['deleted'=>true];
        }else{
            Mail::to($admin->email)->send(new AccesoDenegadoMail($request->user(),$accion));
            return response()->json("No tienes permisos...Eliminar",401);
        }

        

    }
    
}
