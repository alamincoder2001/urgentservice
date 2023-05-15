<?php

namespace App\Http\Controllers\Ambulance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class AmbulanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:ambulance');
    }

    public function index()
    {
        return view("ambulance.dashboard");
    }

    public function profile()
    {
        return view("ambulance.profile");
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name"           => "required",
                "username"       => "required|unique:ambulances,username,".$request->id,
                "email"          => "required|email",
                "phone"          => "required",
                "city_id"        => "required",
                "upazila_id"     => "required",
                "ambulance_type" => "required",
                "address"        => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data                 = Ambulance::find($request->id);
                $data->name           = $request->name;
                $data->username       = $request->username;
                $data->email          = $request->email;
                $data->ambulance_type = implode(",",$request->ambulance_type);
                $data->phone          = implode(",", $request->phone);
                $data->city_id        = $request->city_id;
                $data->upazila_id     = $request->upazila_id;
                $data->address        = $request->address;
                $data->description    = $request->description;
                $data->map_link       = $request->map_link;

                $data->update();
                return response()->json("Ambulance updated successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function password()
    {
        return view("ambulance.password");
    }

    public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "password" => "required",
                "new_password" => "required|same:confirm_password",
                "confirm_password" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Auth::guard("ambulance")->user();
                $hasPass = $data->password;
                if(Hash::check($request->password, $hasPass)){
                    $data->password = Hash::make($request->new_password);
                    $data->update();
                    return response()->json("Password updated successfully");
                }else{
                    return response()->json(["errors"=> "Current Password Not Match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function updateImage(Request $request)
    {
        try{
            $data = Auth::guard("ambulance")->user();
            $old = $data->image;
            if ($request->hasFile('image')) {
                if (File::exists($old)) {
                    File::delete($old);
                }
                $data->image = $this->imageUpload($request, 'image', 'uploads/ambulance') ?? '';
                $data->update();
                return response()->json("Ambulance image updated");
            }
        }catch(\Throwable $e){
            return response()->json("Something went wrong");
        }
    }
}
