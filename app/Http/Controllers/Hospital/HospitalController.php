<?php

namespace App\Http\Controllers\Hospital;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\ChamberDiagnosticHospital;
use Illuminate\Support\Facades\Validator;
use Devfaysal\BangladeshGeocode\Models\District;

class HospitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:hospital');
    }

    public function index()
    {
        $today = date('d-m-Y');
        $id = Auth::guard("hospital")->user()->id;
        $data["doctor"] = ChamberDiagnosticHospital::where("hospital_id", $id)->get();
        $data["patient"] = Appointment::where("hospital_id", $id)->get();
        $data["today"] = Appointment::where("hospital_id", $id)->where('appointment_date', $today)->get();
        return view("hospital.dashboard", compact("data"));
    }

    public function profile()
    {
        $data = Auth::guard("hospital")->user();
        return view("hospital.profile.index", compact("data"));
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name"          => "required",
                "username"      => "required|unique:hospitals,username," . $request->id,
                "email"         => "required|email",
                "phone"         => "required",
                "city_id"       => "required",
                "hospital_type" => "required",
                "address"       => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data                  = Hospital::find($request->id);
                $data->name            = $request->name;
                $data->username        = $request->username;
                $data->email           = $request->email;
                $data->hospital_type   = $request->hospital_type;
                $data->phone           = implode(",", $request->phone);
                $data->discount_amount = $request->discount_amount;
                $data->city_id         = $request->city_id;
                $data->address         = $request->address;
                $data->description     = $request->description;
                $data->map_link        = $request->map_link;
                $data->update();
                return "Hospital updated successfully";
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function password()
    {
        return view("hospital.password");
    }

    public function passwordUpdate(Request $request)
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
                $data = Auth::guard("hospital")->user();
                $hasPass = $data->password;
                if (Hash::check($request->password, $hasPass)) {
                    $data->password = Hash::make($request->new_password);
                    $data->update();
                    return response()->json("Password updated successfully");
                } else {
                    return response()->json(["errors" => "Current Password Not Match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function imageUpdate(Request $request)
    {
        try {
            $data = Auth::guard("hospital")->user();
            $old = $data->image;
            if ($request->hasFile('image')) {
                if (File::exists($old)) {
                    File::delete($old);
                }
                $data->image = $this->imageUpload($request, 'image', 'uploads/hospital') ?? '';
                $data->update();
                return response()->json("Hospital image updated");
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function fetch()
    {
        return District::orderBy('name', 'asc')->get();
    }

    public function getDepartment()
    {
        return Department::get();
    }
}
