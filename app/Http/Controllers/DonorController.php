<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DonorController extends Controller
{
    public function index($city_id = null)
    {
        if ($city_id == null) {
            $data = Donor::with('group')->paginate(30);
        }else{
            $data = Donor::with('group')->where("city_id", $city_id)->paginate(30);
        }
        return view("donor", compact("data", "city_id"));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name'        => "required",
                "phone"       => "required|min:11|max:15",
                "dob"         => "nullable",
                "gender"      => "required",
                "blood_group" => "required",
                "city_id"     => "required",
                "address"     => "required",
                "email"       => "nullable|email",
                "image"       => "mimes:jpg,jpeg,JPEG,png,PNG"
            ]);
            if($validator->fails()){
                return response()->json(["error"=>$validator->errors()]);
            }else{
                $data = Donor::create($request->all());
                $data->image = $this->imageUpload($request, "image", "uploads/donor");
                $data->update();
                return response()->json("Donor added successfully");
            }
        }catch(\Throwable $e){
            return response()->json("Something went wrong".$e->getMessage());
        }
    }
}
