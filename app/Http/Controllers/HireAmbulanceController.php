<?php

namespace App\Http\Controllers;

use App\Models\ContactAmbulance;
use App\Models\ContactPrivatecar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HireAmbulanceController extends Controller
{
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "ambulance_type" => "required",
                "departing_date" => "required",
                "phone" => "required|numeric|min:11",
                "to"    => "required",
                "from"  => "required",
                "email" => "nullable|email|unique:contact_ambulances",
                "trip"  => "required"
            ]);
            if($validator->fails()){
                return response()->json(["error"=>$validator->errors()]);
            }else{
                $data = new ContactAmbulance();
                $data->ambulance_id = $request->id;
                $data->name = $request->name;
                $data->phone = $request->phone;
                $data->email = $request->email;
                $data->departing_date = $request->departing_date;
                $data->ambulance_type = $request->ambulance_type;
                $data->to = $request->to;
                $data->from = $request->from;
                $data->trip = $request->trip;
                $data->save();
                return response()->json("Ambulance Hire Successs");
            }
        }catch(\Throwable $e){
            return response()->json("Something went wrong");
        }
    }
    public function privatecar(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "privatecar_type" => "required",
                "departing_date" => "required",
                "phone" => "required|numeric|min:11",
                "to"    => "required",
                "from"  => "required",
                "email" => "nullable|email|unique:contact_privatecars",
                "trip"  => "required"
            ]);
            if($validator->fails()){
                return response()->json(["error"=>$validator->errors()]);
            }else{
                $data = new ContactPrivatecar();
                $data->privatecar_id = $request->id;
                $data->name = $request->name;
                $data->phone = $request->phone;
                $data->email = $request->email;
                $data->departing_date = $request->departing_date;
                $data->privatecar_type = $request->privatecar_type;
                $data->to = $request->to;
                $data->from = $request->from;
                $data->trip = $request->trip;
                $data->save();
                return response()->json("Privatecar Hire Successs");
            }
        }catch(\Throwable $e){
            return response()->json("Something went wrong");
        }
    }
}
