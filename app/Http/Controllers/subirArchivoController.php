<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Mail\AccesoDenegadoMail;
use Illuminate\Support\Facades\Mail;

class subirArchivoController extends Controller
{

    public function subir(Request $request,$id)
    {

        $user=User::where('id',$id)->first();
        if($request->user()->id==$id){
            if($request->hasFile('file'))
            {

               // $path=Storage::disk('public')->put('ProfilePictures',$request->file);
                $file=$request->file('file');
                $filename=$file->getClientOriginalName();
                
                $filename=pathinfo($filename,PATHINFO_FILENAME);
                $name_file=str_replace(" ","_",$filename);

                $extencion=$file->getClientOriginalExtension();

                $picture=date('His').'_'.$name_file.'.'.$extencion;
                $file->move(public_path('File/'),$picture);
                $path='File\\'.$picture;

                $user->update([
                    'img'=>$path
                ]);

                return response()->json(["mensaje"=>"Se guardo correctamente",
                                        "ruta"=>$path]);

            }else{
                return response()->json(["mensaje"=>"Ocurrio un Error..."]);
            }

        }else{
            $accion='Cambiar tu foto de perfil..';
            Mail::to($user->email)->send(new AccesoDenegadoMail($user,$accion));
            return response()->json("No tienes permisos..",401);
        }
        
    }
    //
}
