<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function autenticate(Request $request){
        $users = User::all();
        
        if(count($users) == 0){
            return response()->json(
                ["ok" => false, "message" => "No existen usuarios todavia"],
                404
            );
        }else{
            foreach($users as $user){
                if($user->email == $request->email && Hash::check($request->password, $user->password)){
                    
                    $authUser = ["name" => $user->name, "email" => $user->email, "role" => $user->role_id];
                    
                    return response()->json(
                        ["ok" => true, "user" => $authUser],
                        200
                    );
                    break;
                }
            }
            return response()->json(
                ["ok" => false, "error" => "El correo y/o la contraseña son incorrectas"],
                401
            );
        }
    }

    public function hashPassword($id){

        try {
            $user = User::findOrFail($id);
            $user->password = Hash::make($user->password);
            
            $user->save ();
            
            return response()->json(
                ["ok" => true, "message" => "La contraseña fue encriptada con exito"],
                200
            );
        } catch (ModelNotFoundException $th) {
            return response()->json(
                ["ok" => false, "message" => "No es encuentra el usuario"],
                404
            );
        }
    }
}
