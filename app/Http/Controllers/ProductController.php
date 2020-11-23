<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Product;
use App\Comment;
use App\User;
use App\Mail\AccesoDenegadoMail;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{


    public function create(Request $request)
    {
        
        $admin=User::where('TipoUser','admin')->first();
        $accion='Crear un nuevo Producto';
        if($request->user()->tokenCan('admin:admin')||$request->user()->tokenCan('user:vendedor')){
            $request->validate([
                'name'=>'required',
                'caducidad'=>'required'
            ]);
            $producto=Product::create([
                'name'=>$request->name,
                'caducidad'=>$request->caducidad,
                'user_id'=>$request->user()->id
            ]);
            return ['created'=>true];
        }else{
            Mail::to($admin->email)->send(new AccesoDenegadomail($request->user(),$accion));
            return response()->json("No tienes permisos...Para crear un Producto",200);
        }

    }


    public function mostrarTodos()
    {
        $productos=DB::table('products')->select('id','name')->get();
       // $productos=Product::get();
      
        return response()->json($productos,201);
    }
   
    public function mostrar($producto)
    {
       
        $producto=Product::get()->where('id',$producto);

        return response()->json($producto,201);

    }
    public function comentarios($producto)
    {
       
        $comentarios=Comment::get()->where('product_id',$producto);

        return response()->json($comentarios,201);

    }

    public function modificar(Request $request,$id)
    {   
        $admin=User::where('TipoUser','admin')->first();
        $accion='Modificar un Producto';
        if($request->user()->tokenCan("admin:admin")){
            $producto=Product::find($id);
            $producto->update($request->all());

            return ['modified'=>true];
        }else{
            $admin=User::where('TipoUser','admin')->first();
            Mail::to($admin->email)->send(new AccesoDenegadoMail($request->user(),$accion));
            return response()->json("No tienes permisos...Para modificar el Producto",401);
        }
           
    }

    public function eliminar(Request $request,$id)
    {
        $admin=User::where('TipoUser','admin')->first();
        $accion='Eliminar un Producto';
        if($request->user()->tokenCan('admin:admin')){
            Product::destroy($id);
            return ['deleted'=>true];
        }else{
            Mail::to($admin->email)->send(new AccesoDenegadoMail($request->user(),$accion));
            return response()->json("No tienes permisos...Para Eliminar el Producto",401);
        }
         

    }
}
