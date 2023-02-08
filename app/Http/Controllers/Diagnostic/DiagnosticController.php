<?php

namespace App\Http\Controllers\Diagnostic;

use App\Models\Doctor;
use App\Models\Diagnostic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DiagnosticController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:diagnostic');
    }

    public function index()
    {
        $id = Auth::guard("diagnostic")->user()->id;
        $data["doctor"] = Doctor::where("diagnostic_id", $id)->get();
        $data["patient"] = Appointment::where("diagnostic_id", $id)->get();
        return view("diagnostic.dashboard", compact("data"));
    }

    public function profile()
    {
        return view("diagnostic.profile");
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "username" => "required|unique:diagnostics,username,".$request->id,
                "email" => "required|email",
                "phone" => "required|min:11|max:15",
                "city_id" => "required",
                "diagnostic_type" => "required",
                "address" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Diagnostic::find($request->id);
                $data->name = $request->name;
                $data->username = $request->username;
                $data->email = $request->email;
                $data->diagnostic_type = $request->diagnostic_type;
                $data->phone = $request->phone;
                $data->discount = $request->discount;
                $data->city_id = $request->city_id;
                $data->address = $request->address;
                $data->description = $request->description;
                $data->map_link = $request->map_link;

                $data->update();
                return response()->json("Diagnostic updated successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function password()
    {
        return view("diagnostic.password");
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
                $data = Auth::guard("diagnostic")->user();
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
            $data = Auth::guard("diagnostic")->user();
            $old = $data->image;
            if ($request->hasFile('image')) {
                if (File::exists($old)) {
                    File::delete($old);
                }
                $data->image = $this->imageUpload($request, 'image', 'uploads/diagnostic') ?? '';
                $data->update();
                return response()->json("Diagnostic image updated");
            }
        }catch(\Throwable $e){
            return response()->json("Something went wrong");
        }
    }
}
