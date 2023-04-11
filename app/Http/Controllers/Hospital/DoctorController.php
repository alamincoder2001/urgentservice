<?php

namespace App\Http\Controllers\Hospital;

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
        $this->middleware('auth:hospital');
    }

    public function index()
    {
        $id = Auth::guard("hospital")->user()->id;
        $doctors = ChamberDiagnosticHospital::with("doctor")->where("hospital_id", $id)->get();
        return view("hospital.doctor.index", compact('doctors'));
    }
    public function create($id = null)
    {
        return view("hospital.doctor.create", compact('id'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'          => "required|max:255",
                'username'      => "required|unique:doctors",
                'email'         => "required",
                'education'     => "required|max:255",
                'department_id' => "required",
                'password'      => "required",
                'to'            => "required",
                'from'          => "required",
                'concentration' => "required",
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
                $data->city_id = Auth::guard("hospital")->user()->city_id;
                $data->phone = implode(",", $request->phone);
                $data->first_fee = $request->first_fee;
                $data->second_fee = $request->second_fee;
                $data->description = $request->description;
                $data->concentration = $request->concentration;
                $data->hospital_id = Auth::guard("hospital")->user()->id;
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
                        $s = new Specialist();
                        $s->doctor_id = $data->id;
                        $s->department_id = $item;
                        $s->save();
                    }
                }
                return response()->json("Doctor addedd successfully");
            }
        } catch (\Throwable $e) {
            return "Something went wrong";
        }
    }

    public function edit($id)
    {
        $departments = Department::all();
        $data = Doctor::with("time", "department")->find($id);
        return view("hospital.doctor.edit", compact("data", "departments"));
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'          => "required|max:255",
                'username'      => "required|unique:doctors,username," . $request->id,
                'email'         => "required",
                'education'     => "required|max:255",
                'department_id' => "required",
                'to'            => "required",
                'from'          => "required",
                'concentration' => "required",
                'phone'         => "required",
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
                $data->name = $request->name;
                $data->username = $request->username;
                $data->email = $request->email;
                if (!empty($request->password)) {
                    $data->email = Hash::make($request->password);
                }

                $data->education = $request->education;
                $data->city_id = Auth::guard("hospital")->user()->city_id;
                $data->phone = implode(",", $request->phone);
                $data->first_fee = $request->first_fee;
                $data->second_fee = $request->second_fee;
                $data->description = $request->description;
                $data->concentration = $request->concentration;
                $data->hospital_id = Auth::guard("hospital")->user()->id;
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
