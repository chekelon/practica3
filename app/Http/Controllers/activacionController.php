<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class activacionController extends Controller
{
    public function activar($id)
    {
        $user=User::where('id',$id)->first();
        $user->update(['email_verified_at'=>now()]);

        return response()->json(["email verificado"=>$user->email_verified_at,"nombre"=>$user->name],200);


    }
}
