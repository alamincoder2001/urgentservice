<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ChamberDiagnosticHospital;
use App\Models\DayTime;
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

    public function fetch($id)
    {
        $doctor = Doctor::with("city", "department")->find($id);
        $carts = DB::select("SELECT cdh.*,
                    d.name AS doctor_name,
                    h.name AS hospital_name, 
                    h.address AS hospital_address,
                    diag.name AS diagnostic_name, 
                    diag.address AS diagnostic_address
                FROM chamber_diagnostic_hospitals cdh
                JOIN doctors d ON d.id = cdh.doctor_id
                LEFT JOIN hospitals h ON h.id = cdh.hospital_id
                LEFT JOIN diagnostics diag ON diag.id = cdh.diagnostic_id
                WHERE cdh.doctor_id = '$id'");

        foreach($carts as $cart){
            $cart->daywiseTimeArray = DB::select("SELECT dt.* FROM day_times dt WHERE dt.type_id = '$cart->id'");
        }

        return response()->json(["doctor" => $doctor, "carts" => $carts]);
    }

    public function create($id = null)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("doctor.create", $access)) {
            return view("admin.unauthorize");
        }
        return view("admin.doctor.create", compact("id"));
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
                'departments' => "required",
                'city_id'       => "required",
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
                $data->address          = $request->address;
                $data->appointment_text = $request->appointment_text;
                $data->phone            = $request->phone;
                $data->first_fee        = $request->first_fee;
                $data->second_fee       = $request->second_fee;
                $data->concentration    = $request->concentration;
                $data->description      = $request->description;
                $data->save();


                foreach (json_decode($request->carts) as $key => $cart) {
                    $details                  = new ChamberDiagnosticHospital();
                    $details->doctor_id       = $data->id;
                    $details->type            = $cart->selectby;
                    if ($cart->selectby == 'chamber') {
                        $details->chamber_name    = $cart->chamber_name;
                        $details->chamber_address = $cart->chamber_address;
                    }
                    if ($cart->selectby == 'hospital') {
                        $details->hospital_id     = $cart->hospital_id;
                    }
                    if ($cart->selectby == 'diagnostic') {
                        $details->diagnostic_id   = $cart->diagnostic_id;
                    }
                    $details->save();
                    foreach($cart->daywiseTimeArray as $item){
                        $t           = new DayTime();
                        $t->type_id  = $details->id;
                        $t->day      = $item->day;
                        $t->fromTime = $item->fromTime;
                        $t->toTime   = $item->toTime;
                        $t->save();
                    }

                }

                if (!empty($request->departments)) {
                    foreach (json_decode($request->departments) as $item) {
                        $s                = new Specialist();
                        $s->doctor_id     = $data->id;
                        $s->department_id = $item->id;
                        $s->save();
                    }
                }
                return response()->json("Doctor addedd successfully");
            }
        } catch (\Throwable $e) {
            return "Opps! something went wrong";
        }
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'          => "required|max:255",
                'email'         => "required|email",
                'education'     => "required",
                'username'      => "required",
                'departments'   => "required",
                'city_id'       => "required",
                'concentration' => "required",
                'first_fee'     => "required|numeric",
                'second_fee'    => "required|numeric",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Doctor::find($request->id);
                if ($request->hasFile('image')) {
                    $old  = $data->image;
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
                $data->education        = $request->education;
                $data->city_id          = $request->city_id;
                $data->address          = $request->address;
                $data->appointment_text = $request->appointment_text;
                $data->phone            = $request->phone;
                $data->first_fee        = $request->first_fee;
                $data->second_fee       = $request->second_fee;
                $data->concentration    = $request->concentration;
                $data->description      = $request->description;
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
                foreach (json_decode($request->carts) as $key => $cart) {
                    $details                  = new ChamberDiagnosticHospital();
                    $details->doctor_id       = $request->id;
                    $details->type            = $cart->selectby;
                    if ($cart->selectby == 'chamber') {
                        $details->chamber_name    = $cart->chamber_name;
                        $details->chamber_address = $cart->chamber_address;
                    }
                    if ($cart->selectby == 'hospital') {
                        $details->hospital_id     = $cart->hospital_id;
                    }
                    if ($cart->selectby == 'diagnostic') {
                        $details->diagnostic_id   = $cart->diagnostic_id;
                    }
                    $details->save();
                    foreach($cart->daywiseTimeArray as $item){
                        $t = new DayTime();
                        $t->type_id = $details->id;
                        $t->day = $item->day;
                        $t->fromTime = $item->fromTime;
                        $t->toTime = $item->toTime;
                        $t->save();
                    }

                }
                return response()->json("Doctor updated successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong ");
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


}
