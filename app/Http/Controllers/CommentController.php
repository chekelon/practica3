<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Product;
use App\Comment;
use App\User;
use App\Mail\AccesoDenegadoMail;
use App\Mail\comentarioNew;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function mostrarTodos()
    {
        $comentarios=Comment::get();

        return response()->json($comentarios,201);

    }

    public function guardar(Request $request,$id)
    {
        $request->validate([
            'comment'=>'required',
        ]);
        $comentario=new Comment;
        $comentario->user_id=$request->user()->id;
        $comentario->product_id=$id;
        $comentario->comment=$request->comment;
        $comentario->save();

        $producto=Product::where('id',$id)->first();
        $user=User::where('id',$producto->user_id)->first();

        Mail::to($user->email)->send(new comentarioNew($request->user(),$comentario));
        return ['created'=>true];
    }

    public function modificar(Request $request, $id)
    {   
        $admin=User::where('TipoUser','admin')->first();
        $comentario=Comment::where('id',$id)->first();
        $user=User::where('id',$comentario->user_id)->first();
        $accion='Modificar un comentario';
        if($request->user()->id==$user->id||$request->user()->tokenCan('admin:admin')){
            $comentorio=Comment::find($id);
            $comentorio->update($request->all());

            return ['modified'=>true];
        }else{
            Mail::to($admin->email)->send(new AccesoDenegadoMail($request->user(),$accion));
            return response()->json("No tienes permisos para modificar el comentario...",401);
        }
       
    }

    public function eliminar($id)
    {
        Comment::destroy($id);

        return ['deleted'=>true];        

    }
}
