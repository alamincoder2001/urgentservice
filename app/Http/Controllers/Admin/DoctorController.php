<?php

namespace App\Http\Controllers\Admin;

use App\Models\Test;
use App\Models\Doctor;
use App\Models\Chamber;
use App\Models\UserAccess;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Sittime;
use App\Models\Specialist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
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
        if (!in_array("doctor.index", $access)) {
            return view("admin.unauthorize");
        }

        $doctors = Doctor::with("department")->latest()->get();
        return view("admin.doctor.index", compact('doctors'));
    }
    public function create()
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("doctor.create", $access)) {
            return view("admin.unauthorize");
        }

        $hospitals = DB::table("hospitals")->orderBy("id", "DESC")->get();
        $departments = DB::table("departments")->orderBy("id", "DESC")->get();
        $diagnostics = DB::table("diagnostics")->orderBy("id", "DESC")->get();
        return view("admin.doctor.create", compact("hospitals", "diagnostics", "departments"));
    }

    public function store(Request $request)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("doctor.store", $access)) {
            return "UnAuthorized access! You have no access";
        }
        try {
            $validator = Validator::make($request->all(), [
                'name'          => "required|max:255",
                'email'         => "required|email",
                'education'     => "required",
                'password'      => "required",
                'username'      => "required|unique:hospitals",
                'department_id' => "required",
                'city_id'       => "required",
                'day'           => "required",
                'phone'         => "required",
                'concentration' => "required",
                'first_fee'     => "required|numeric",
                'second_fee'    => "required|numeric",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data           = new Doctor;
                $data->image    = $this->imageUpload($request, 'image', 'uploads/doctor') ?? '';
                $data->name     = $request->name;
                $data->username = $request->username;
                $data->email    = $request->email;
                $data->password = Hash::make($request->password);

                $data->education = $request->education;

                $data->city_id       = $request->city_id;
                $data->phone         = implode(",", $request->phone);
                $data->first_fee     = $request->first_fee;
                $data->second_fee    = $request->second_fee;
                $data->concentration = $request->concentration;
                $data->description   = $request->description;

                if (!empty($request->hospital_id)) {
                    $data->hospital_id = implode(",", $request->hospital_id);
                }
                if (!empty($request->diagnostic_id)) {
                    $data->diagnostic_id = implode(",", $request->diagnostic_id);
                }
                $data->save();

                if (!empty($request->chamber)) {
                    foreach ($request->chamber as $key => $item) {
                        $chamber = new Chamber;
                        $chamber->name = $item;
                        $chamber->address = $request->address[$key];
                        $chamber->doctor_id = $data->id;
                        $chamber->save();
                    }
                }
                if (!empty($request->from)) {
                    foreach ($request->from as $key => $item) {
                        $t            = new Sittime();
                        $t->doctor_id = $data->id;
                        $t->day       = $request->day[$key];
                        $t->from      = $item;
                        $t->to        = $request->to[$key];
                        $t->save();
                    }
                }
                if (!empty($request->department_id)) {
                    foreach ($request->department_id as $item) {
                        $s = new Specialist();
                        $s->doctor_id = $data->id;
                        $s->department_id = $item;
                        $s->save();
                    }
                }
                return response()->json("Doctor addedd successfully");
            }
        } catch (\Throwable $e) {
            return "Opps! something went wrong";
        }
    }

    public function edit($id)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("doctor.edit", $access)) {
            return view("admin.unauthorize");
        }

        $data = Doctor::with("chamber", "time")->find($id);
        $hospitals = DB::table("hospitals")->orderBy("id", "DESC")->get();
        $departments = DB::table("departments")->orderBy("id", "DESC")->get();
        $diagnostics = DB::table("diagnostics")->orderBy("id", "DESC")->get();
        return view("admin.doctor.edit", compact("data", "hospitals", "diagnostics", "departments"));
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'          => "required|max:255",
                'email'         => "required|email",
                'education'     => "required",
                'username'      => "required|unique:hospitals,username," . $request->id,
                'department_id' => "required",
                'city_id'       => "required",
                'day'           => "required",
                'phone'         => "required",
                'concentration' => "required",
                'first_fee'     => "required|numeric",
                'second_fee'    => "required|numeric",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Doctor::find($request->id);
                $old  = $data->image;
                if ($request->hasFile('image')) {
                    if (File::exists($old)) {
                        File::delete($old);
                    }
                    $data->image = $this->imageUpload($request, 'image', 'uploads/doctor') ?? '';
                }
                $data->name     = $request->name;
                $data->username = $request->username;
                $data->email    = $request->email;
                if (!empty($request->password)) {
                    $data->password = Hash::make($request->password);
                }
                $data->education     = $request->education;
                $data->city_id       = $request->city_id;
                $data->phone         = implode(",", $request->phone);
                $data->first_fee     = $request->first_fee;
                $data->second_fee    = $request->second_fee;
                $data->concentration = $request->concentration;
                $data->description   = $request->description;
                if (!empty($request->hospital_id)) {
                    $data->hospital_id = implode(",", $request->hospital_id);
                }
                if (!empty($request->diagnostic_id)) {
                    $data->diagnostic_id = implode(",", $request->diagnostic_id);
                }
                $data->update();

                Chamber::where("doctor_id", $request->id)->delete();
                if (!empty($request->chamber)) {
                    foreach ($request->chamber as $key => $item) {
                        $chamber = new Chamber;
                        $chamber->name = $item;
                        $chamber->address = $request->address[$key];
                        $chamber->doctor_id = $request->id;
                        $chamber->save();
                    }
                }
                Specialist::where("doctor_id", $request->id)->delete();
                if (!empty($request->department_id)) {
                    foreach ($request->department_id as $item) {
                        $s = new Specialist();
                        $s->doctor_id = $request->id;
                        $s->department_id = $item;
                        $s->save();
                    }
                }
                Sittime::where("doctor_id", $request->id)->delete();
                if (!empty($request->from)) {
                    foreach ($request->from as $key => $item) {
                        $t            = new Sittime();
                        $t->doctor_id = $request->id;
                        $t->day      = $request->day[$key];
                        $t->from      = $item;
                        $t->to        = $request->to[$key];
                        $t->save();
                    }
                }
                return response()->json("Doctor updated successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function destroy(Request $request)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("doctor.destroy", $access)) {
            return view("admin.unauthorize");
        }

        try {
            $data = Doctor::find($request->id);
            $old = $data->image;
            if (File::exists($old)) {
                File::delete($old);
            }
            $data->delete();
            return response()->json("Doctor deleted successfully");
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    // doctor patient appointment
    public function appointment($id)
    {
        $admin_id = Auth::guard("admin")->user()->id;
        $tests = Test::where("admin_id", $admin_id)->orderBy("name", "ASC")->get();
        $appointments = Appointment::with('chamber', 'hospital', 'diagnostic')->where("doctor_id", $id)->get();
        return view("admin.doctor.appointment", compact("appointments", "tests"));
    }
}
