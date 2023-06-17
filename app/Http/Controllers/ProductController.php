<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json(
            ["ok" => true, "data" => $products],
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
        $products = new Product();

        $products->code = $request->code;
        $products->name = $request->name;
        $products->characteristics = $request->characteristics;
        $products->price = $request->price;
        $products->enterprise_id = $request->enterprise_id;

        $status = $products->save();

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
            $product = Product::where("code", $id)->firstOrFail();

            return response()->json(["ok" => true, "data"=> $product], 200);
            
        } catch (ModelNotFoundException $th) {
            return response()->json(
                ["ok" => false, "message" => "El producto no existe"],
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
        //
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
            $product = Product::where("code", $id)->firstOrFail();

            $product->code = $request->filled("code") ? $request->code : $product->code;
            $product->name = $request->filled("name") ? $request->name : $product->name;
            $product->characteristics = $request->filled("characteristics") ? $request->characteristics : $product->characteristics;
            $product->price = $request->filled("price") ? $request->price : $product->price;
            $product->enterprise_id = $request->filled("enterprise_id") ? $request->enterprise_id : $product->enterprise_id;

            $status = $product->save();

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
                ["ok" => false, "message" => "El producto no existe"],
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
            $product = Product::where("code", $id)->firstOrFail();

            $response = $product->delete();

            if($response){
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
                ["ok" => false, "message" => "El producto no existe"],
                400
            );
        }
    }
}
