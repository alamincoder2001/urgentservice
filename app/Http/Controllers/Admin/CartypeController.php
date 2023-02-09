<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cartype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CartypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view("admin.cartype.index");
    }

    public function fetch()
    {
        $data = Cartype::latest()->get();
        return response()->json(["data"=>$data]);
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                "name" => "required"
            ],["name.required" => "Cartype name required"]);
            if($validator->fails()){
                return response()->json(["error" => $validator->errors()]);
            }else{
                if(empty($request->id)){
                    $data = new Cartype();
                }else{
                    $data = Cartype::find($request->id);
                }
                $data->name = $request->name;
                $data->save();
                $id = $data->id;
                if(empty($request->id)){
                    return response()->json(["msg"=>"Cartype added successfully"]);
                }else{
                    return response()->json(["msg"=>"Cartype updated successfully"]);
                }
            }
        }catch(\Throwable $e){
            return response()->json("Something went wrong");
        }
    }
    public function edit($id)
    {
        try{
            $data = Cartype::find($id);
            return response()->json($data);
        }catch(\Throwable $e){
            return response()->json("something went wrong");
        }
    }

    public function destroy(Request $request)
    {
        try{
            Cartype::find($request->id)->delete();
            return response()->json("Cartype delete successfully");
        }catch(\Throwable $e){
            return response()->json("something went wrong");
        }
    }
} 
