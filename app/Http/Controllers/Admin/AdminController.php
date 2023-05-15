<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Donor;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Ambulance;
use App\Models\Diagnostic;
use App\Models\UserAccess;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Investigation;
use App\Models\Privatecar;
use App\Models\Slider;
use App\Models\Test;
use Devfaysal\BangladeshGeocode\Models\District;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("dashboard.index", $access)) {
            return view("admin.unauthorize");
        }

        $data['doctor']        = Doctor::all();
        $data['hospital']      = Hospital::all();
        $data['diagnostic']    = Diagnostic::all();
        $data['ambulance']     = Ambulance::all();
        $data['privatecar']    = Privatecar::all();
        $data['department']    = Department::all();
        $data['test']          = Test::all();
        $data['investigation'] = Investigation::all();
        $data['slider']        = Slider::all();
        $data['donor']         = Donor::all();
        $data['city']          = District::all();
        $data['user']          = Admin::where("id", "!=", 1)->get();
        return view("admin.dashboard", compact("data"));
    }

    public function profile()
    {
        return view("admin.profile.index");
    }

    public function getProfile()
    {
        $admin = Auth::guard("admin")->user();
        return response()->json($admin);
    }

    public function saveProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email"
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            } else {
                if ($request->hasFile('image')) {
                    $admin = Auth::guard("admin")->user();
                    $old = $admin->image;
                    if (File::exists($old)) {
                        File::delete($old);
                    }
                    $admin->image = $this->imageUpload($request, 'image', 'uploads/admin') ?? '';

                    $admin->name = $request->name;
                    $admin->email = $request->email;
                    $admin->updated_at = Carbon::now();
                    $admin->update();
                    return response()->json("Admin Profile updated successfully");
                } else {
                    $admin = Auth::guard("admin")->user();
                    $admin->name = $request->name;
                    $admin->email = $request->email;
                    $admin->updated_at = Carbon::now();
                    $admin->update();
                    return response()->json("Admin Profile updated successfully");
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    // Password Controller 

    public function password()
    {
        return view("admin.profile.password");
    }

    public function passwordChange(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "password" => "required",
                "new_password" => "required",
                "confirm_password" => "required|same:new_password"
            ], [
                "new_password.required" => "New password required",
                "confirm_password.required" => "Confirm password required"
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $admin = Auth::guard("admin")->user();
                $hash_password = $admin->password;
                if (Hash::check($request->password, $hash_password)) {
                    $admin->password = Hash::make($request->new_password);
                    $admin->update();
                    return response()->json("Password Change Successfully");
                } else {
                    return response()->json(["errors" => "Current password does not match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    // blood donor
    public function blooddonor()
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("blood-donor.index", $access)) {
            return view("admin.unauthorize");
        }
        $data = Donor::latest()->get();
        return view("admin.donor.index", compact("data"));
    }

    public function donordestroy(Request $request)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("blood-donor.destroy", $access)) {
            return response()->json(["unauthorize" => "Unauthorized page! Sorry you have no access!"]);
        }
        try {
            $data = Donor::find($request->id);
            $old = $data->image;
            if (File::exists($old)) {
                File::delete($old);
            }
            $data->delete();
            return response()->json("Donor delete successfully");
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function showprescription()
    {
        $data = Prescription::latest()->get();
        return view("admin.prescription.index", compact("data"));
    }

    public function deletePrescription(Request $request)
    {
        $data = Prescription::find($request->id);
        $old = $data->image;
        if (File::exists($old)) {
            File::delete($old);
        }
        $data->delete();
        return "Prescription Delete";
    }
}
