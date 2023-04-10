<?php

namespace App\Http\Controllers\Diagnostic;

use App\Models\Doctor;
use App\Models\Sittime;
use App\Models\Department;
use App\Models\Specialist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChamberDiagnosticHospital;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:diagnostic');
    }

    public function index()
    {
        $id = Auth::guard("diagnostic")->user()->id;
        $doctors = ChamberDiagnosticHospital::with("doctor")->where("diagnostic_id", $id)->get();
        return view("diagnostic.doctor.index", compact('doctors'));
    }
    public function create()
    {
        $departments = Department::all();
        return view("diagnostic.doctor.create", compact("departments"));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'          => "required|max:255",
                'username'      => "required|unique:doctors",
                'email'         => "required|email",
                'education'     => "required|max:255",
                'department_id' => "required",
                'concentration' => "required",
                'password'      => "required",
                'phone'         => "required",
                'first_fee'     => "required|numeric",
                'second_fee'    => "required|numeric",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = new Doctor;
                $data->image = $this->imageUpload($request, 'image', 'uploads/doctor') ?? '';
                $data->name = $request->name;
                $data->username = $request->username;
                $data->email = $request->email;
                $data->password = Hash::make($request->password);
                $data->education = $request->education;
                $data->city_id = Auth::guard("diagnostic")->user()->city_id;
                $data->phone = implode(",", $request->phone);
                $data->first_fee = $request->first_fee;
                $data->second_fee = $request->second_fee;
                $data->description = $request->description;
                $data->concentration = $request->concentration;
                $data->diagnostic_id = Auth::guard("diagnostic")->user()->id;
                $data->save();

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
                        $s                = new Specialist();
                        $s->doctor_id     = $data->id;
                        $s->department_id = $item;
                        $s->save();
                    }
                }
                return response()->json("Doctor addedd successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function edit($id)
    {
        $departments = Department::all();
        $data = Doctor::with("time", "department")->find($id);
        $avail = explode(",", $data->availability);
        return view("diagnostic.doctor.edit", compact("data", 'avail', "departments"));
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => "required|max:255",
                'username' => "required|unique:doctors,username," . $request->id,
                'email' => "required|email",
                'education' => "required|max:255",
                'department_id' => "required",
                'availability' => "required",
                'phone' => "required",
                'first_fee' => "required|numeric",
                'second_fee' => "required|numeric",
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
                $data->name = $request->name;
                $data->username = $request->username;
                $data->email = $request->email;
                if (!empty($request->password)) {
                    $data->email = Hash::make($request->password);
                }
                $data->education = $request->education;
                $data->city_id = Auth::guard("diagnostic")->user()->city_id;
                $data->availability = implode(",", $request->availability);
                $data->phone = implode(",", $request->phone);
                $data->first_fee = $request->first_fee;
                $data->second_fee = $request->second_fee;
                $data->description = $request->description;
                $data->concentration = $request->concentration;
                $data->diagnostic_id = Auth::guard("diagnostic")->user()->id;
                $data->update();

                Specialist::where("doctor_id", $request->id)->delete();
                if (!empty($request->department_id)) {
                    foreach ($request->department_id as $item) {
                        $s                = new Specialist();
                        $s->doctor_id     = $request->id;
                        $s->department_id = $item;
                        $s->save();
                    }
                }
                Sittime::where("doctor_id", $request->id)->delete();
                if (!empty($request->from)) {
                    foreach ($request->from as $key => $item) {
                        $t            = new Sittime();
                        $t->doctor_id = $request->id;
                        $t->day       = $request->day[$key];
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
}
