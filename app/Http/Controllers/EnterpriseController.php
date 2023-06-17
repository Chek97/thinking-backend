<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enterprises = Enterprise::all();

        return response()->json(
            ["ok" => true, "data" => $enterprises],
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $enterprise = new Enterprise();

        $enterprise->NIT = $request->nit;
        $enterprise->name = $request->name;
        $enterprise->email = $request->address;
        $enterprise->phone = $request->phone;

        $status = $enterprise->save();

        if($status){
            return response()->json(
                ["ok" => true, "message" => "registro guardado con exito"],
                200
            );
        }else{
            return response()->json(
                ["ok" => false, "message" => "no fue posible guardar el registro, intentalo mas tarde"],
                400
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $enterprise = Enterprise::where("NIT", $id)->firstOrFail();

            return response()->json(["ok" => true, "data"=> $enterprise], 200);
            
        } catch (ModelNotFoundException $th) {
            return response()->json(
                ["ok" => false, "message" => "La empresa no existe"],
                400
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $enterprise = Enterprise::findOrFail($id);

            $enterprise->NIT = $request->filled("nit") ? $request->nit : $enterprise->NIT;
            $enterprise->name = $request->filled("name") ? $request->name : $enterprise->name;
            $enterprise->email = $request->filled("email") ? $request->email : $enterprise->email;
            $enterprise->phone = $request->filled("phone") ? $request->phone : $enterprise->phone;

            $status = $enterprise->save();

            if($status){
                return response()->json(
                    ["ok" => true, "message" => "registro actualizado con exito"],
                    200
                );
            }else{
                return response()->json(
                    ["ok" => false, "message" => "no fue posible actualizar el registro, intentalo mas tarde"],
                    400
                );
            }

        }catch(ModelNotFoundException $th){
            return response()->json(
                ["ok" => false, "message" => "La empresa no existe"],
                400
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $enterprise = Enterprise::where("NIT", $id)->firstOrFail();

            $response = $enterprise->delete();

            if($response == 1){
                return response()->json(
                    ["ok" => true, "message" => "Registro eliminado con exito"],
                    200
                );
            }else{
                return response()->json(
                    ["ok" => false, "message" => "Hubo un error en la eliminacion, intentalo mas tarde"],
                    500
                );
            }

        }catch(ModelNotFoundException $th){
            return response()->json(
                ["ok" => false, "message" => "La empresa no existe"],
                400
            );
        }
    }
}
