<?php

namespace App\Http\Controllers\Diagnostic;

use App\Models\Doctor;
use App\Models\DayTime;
use App\Models\Sittime;
use App\Models\Department;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\ChamberDiagnosticHospital;
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
    public function create($id = null)
    {
        return view("diagnostic.doctor.create", compact("id"));
    }

    public function fetch($id)
    {
        $doctor           = Doctor::with("city", "department")->find($id);
        $auth_id          = Auth::guard('diagnostic')->user()->id;
        $diagnostic_id    = ChamberDiagnosticHospital::where("doctor_id", $id)->where('diagnostic_id', $auth_id)->first();
        $daywiseTimeArray = DB::select("SELECT dt.* FROM day_times dt WHERE dt.type_id = '$diagnostic_id->id'");

        return response()->json(["doctor" => $doctor, "daywiseTimeArray" => $daywiseTimeArray]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'          => "required|max:255",
                'username'      => "required|unique:doctors",
                'email'         => "required",
                'education'     => "required|max:255",
                'departments'   => "required",
                'password'      => "required",
                'concentration' => "required",
                'phone'         => "required",
                'first_fee'     => "required|numeric",
                'second_fee'    => "required|numeric",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data                   = new Doctor;
                $data->image            = $this->imageUpload($request, 'image', 'uploads/doctor') ?? '';
                $data->name             = $request->name;
                $data->username         = $request->username;
                $data->email            = $request->email;
                $data->password         = Hash::make($request->password);
                $data->education        = $request->education;
                $data->city_id          = $request->city_id;
                $data->phone            = $request->phone;
                $data->first_fee        = $request->first_fee;
                $data->second_fee       = $request->second_fee;
                $data->description      = $request->description;
                $data->address          = $request->address;
                $data->appointment_text = $request->appointment_text;
                $data->concentration    = $request->concentration;
                $data->save();

                if (!empty($request->departments)) {
                    foreach (json_decode($request->departments) as $item) {
                        $s                = new Specialist();
                        $s->doctor_id     = $data->id;
                        $s->department_id = $item->id;
                        $s->save();
                    }
                }

                $details              = new ChamberDiagnosticHospital();
                $details->doctor_id   = $data->id;
                $details->type        = 'diagnostic';
                $details->diagnostic_id = Auth::guard("diagnostic")->user()->id;
                $details->save();
                foreach (json_decode($request->daywiseTimeArray) as $key => $item) {
                    $t           = new DayTime();
                    $t->type_id  = $details->id;
                    $t->day      = $item->day;
                    $t->fromTime = $item->fromTime;
                    $t->toTime   = $item->toTime;
                    $t->save();
                }
                return response()->json("Doctor addedd successfully");
            }
        } catch (\Throwable $e) {
            return "Something went wrong";
        }
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'          => "required|max:255",
                'username'      => "required|unique:doctors,username," . $request->id,
                'email'         => "required",
                'education'     => "required|max:255",
                'departments'   => "required",
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
                $data->name     = $request->name;
                $data->username = $request->username;
                $data->email    = $request->email;
                if (!empty($request->password)) {
                    $data->email = Hash::make($request->password);
                }

                $data->education        = $request->education;
                $data->city_id          = $request->city_id;
                $data->phone            = $request->phone;
                $data->first_fee        = $request->first_fee;
                $data->second_fee       = $request->second_fee;
                $data->description      = $request->description;
                $data->address          = $request->address;
                $data->appointment_text = $request->appointment_text;
                $data->concentration    = $request->concentration;
                $data->update();

                Specialist::where("doctor_id", $request->id)->delete();
                if (!empty($request->departments)) {
                    foreach (json_decode($request->departments) as $item) {
                        $s                = new Specialist();
                        $s->doctor_id     = $request->id;
                        $s->department_id = $item->id;
                        $s->save();
                    }
                }

                ChamberDiagnosticHospital::where("doctor_id", $request->id)->delete();
                $details              = new ChamberDiagnosticHospital();
                $details->doctor_id   = $request->id;
                $details->type        = 'diagnostic';
                $details->diagnostic_id = Auth::guard("diagnostic")->user()->id;
                $details->save();
                foreach (json_decode($request->daywiseTimeArray) as $key => $item) {
                    $t           = new DayTime();
                    $t->type_id  = $details->id;
                    $t->day      = $item->day;
                    $t->fromTime = $item->fromTime;
                    $t->toTime   = $item->toTime;
                    $t->save();
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
