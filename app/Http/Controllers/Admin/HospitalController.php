<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hospital;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
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
        if (!in_array("hospital.index", $access)) {
            return view("admin.unauthorize");
        }

        $hospital = DB::table("hospitals")->orderBy("id", 'DESC')->get();
        return view("admin.hospital.index", compact("hospital"));
    }

    public function create()
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("hospital.create", $access)) {
            return view("admin.unauthorize");
        }
        return view("admin.hospital.create");
    }

    public function store(Request $request)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("hospital.store", $access)) {
            return view("admin.unauthorize");
        }
        try {
            $validator = Validator::make($request->all(), [
                "name"            => "required",
                "username"        => "required|unique:hospitals",
                "email"           => "required|email",
                "password"        => "required",
                "phone"           => "required",
                "city_id"         => "required",
                "discount_amount" => "required",
                "hospital_type"   => "required",
                "address"         => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data                  = new Hospital;
                $data->image           = $this->imageUpload($request, 'image', 'uploads/hospital') ?? '';
                $data->name            = $request->name;
                $data->username        = $request->username;
                $data->email           = $request->email;
                $data->password        = Hash::make($request->password);
                $data->hospital_type   = $request->hospital_type;
                $data->phone           = implode(",", $request->phone);
                $data->discount_amount = $request->discount_amount;
                $data->city_id         = $request->city_id;
                $data->address         = $request->address;
                $data->description     = $request->description;
                $data->map_link        = $request->map_link;
                $data->save();
                return response()->json("Hospital added successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function edit($id)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("hospital.edit", $access)) {
            return view("admin.unauthorize");
        }

        $data = Hospital::find($id);
        return view("admin.hospital.edit", compact('data'));
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name"            => "required",
                "username"        => "required|unique:hospitals,username," . $request->id,
                "email"           => "required|email",
                "phone"           => "required",
                "city_id"         => "required",
                "discount_amount" => "required",
                "hospital_type"   => "required",
                "address"         => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Hospital::find($request->id);
                $old = $data->image;
                if ($request->hasFile('image')) {
                    if (File::exists($old)) {
                        File::delete($old);
                    }
                    $data->image = $this->imageUpload($request, 'image', 'uploads/hospital') ?? '';
                }
                $data->name     = $request->name;
                $data->username = $request->username;
                $data->email    = $request->email;
                if (!empty($request->password)) {
                    $data->password = Hash::make($request->password);
                }
                $data->hospital_type   = $request->hospital_type;
                $data->phone           = implode(",", $request->phone);
                $data->discount_amount = $request->discount_amount;
                $data->city_id         = $request->city_id;
                $data->address         = $request->address;
                $data->description     = $request->description;
                $data->map_link        = $request->map_link;

                $data->update();
                return response()->json("Hospital updated successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function destroy(Request $request)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("hospital.destroy", $access)) {
            return view("admin.unauthorize");
        }

        try {
            $data = Hospital::find($request->id);
            $old = $data->image;
            if (File::exists($old)) {
                File::delete($old);
            }
            $data->delete();
            return response()->json("Hospital Deleted successfully");
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function getHospital()
    {
        $data = Hospital::get();
        return response()->json(["data" => $data]);
    }
}
