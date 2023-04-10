<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DonorController extends Controller
{
    public function index($any = null)
    {
        $city_id = null;
        $blood_group = null;
        if ($any != null) {
            if ($any == 'blood-group') {
                $blood_group .= $_GET['id'];
                $data = Donor::with('group')->where('blood_group', $_GET['id'])->get();
            } else if($any == 'city') {
                $city_id .= $_GET['id'];
                $data = Donor::with('group')->where("city_id", $_GET['id'])->get();
            }else{
                return redirect("/");
            }
        } else {
            $data = Donor::with('group')->get();
        }
        return view("donor", compact("data", "city_id", "blood_group"));
    }

    public function store(Request $request)
    {
        try {
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
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Donor::create($request->all());
                $data->image = $this->imageUpload($request, "image", "uploads/donor");
                $data->update();
                return response()->json("Donor added successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong" . $e->getMessage());
        }
    }
}
