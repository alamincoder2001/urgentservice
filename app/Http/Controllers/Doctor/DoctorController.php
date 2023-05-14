<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Doctor;
use App\Models\Chamber;
use App\Models\DayTime;
use App\Models\Sittime;
use App\Models\Hospital;
use App\Models\Department;
use App\Models\Diagnostic;
use App\Models\Specialist;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\ChamberDiagnosticHospital;
use Illuminate\Support\Facades\Validator;
use Devfaysal\BangladeshGeocode\Models\District;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        $doctor = Auth::guard("doctor")->user();
        $data["all"] = Appointment::where(["doctor_id" => $doctor->id])->get();
        $data["new"] = Appointment::where(["doctor_id" => $doctor->id, "appointment_date" => date("d-m-Y")])->get();
        return view("doctor.dashboard", compact("data"));
    }
    public function doctor()
    {
        $doctor = Auth::guard("doctor")->user();
        $data['department'] = Department::all();
        $data['hospital_id'] = explode(",", $doctor->hospital_id);
        $data['diagnostic_id'] = explode(",", $doctor->diagnostic_id);
        $hospitals = Hospital::all();
        $diagnostics = Diagnostic::all();
        $data["new"] = Appointment::where(["doctor_id" => $doctor->id, "appointment_date" => date("d-m-Y")])->get();
        return view("doctor.profile", compact("data", "diagnostics", "hospitals"));
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
                $data->education     = $request->education;
                $data->city_id       = $request->city_id;
                $data->address       = $request->address;
                $data->phone         = $request->phone;
                $data->first_fee     = $request->first_fee;
                $data->second_fee    = $request->second_fee;
                $data->concentration = $request->concentration;
                $data->description   = $request->description;
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
                    foreach ($cart->daywiseTimeArray as $item) {
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
            return response()->json("Something went wrong" . $e->getMessage());
        }
    }

    public function password()
    {
        $doctor = Auth::guard("doctor")->user();
        $data["new"] = Appointment::where(["doctor_id" => $doctor->id, "appointment_date" => date("d/m/Y")])->get();
        return view("doctor.password", compact("data"));
    }


    public function passwordUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "password" => "required",
                "new_password" => "required|same:confirm_password",
                "confirm_password" => "required"
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Auth::guard("doctor")->user();
                $hashpass = $data->password;
                if (Hash::check($request->password, $hashpass)) {
                    $data->password = Hash::make($request->new_password);
                    $data->update();
                    return response()->json("Password Change Successfully");
                } else {
                    return response()->json(['errors' => "Current Password does not match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function imageUpdate(Request $request)
    {
        try {
            $data = Auth::guard("doctor")->user();
            $old  = $data->image;
            if ($request->hasFile('image')) {
                if (File::exists($old)) {
                    File::delete($old);
                }
                $data->image = $this->imageUpload($request, 'image', 'uploads/doctor') ?? '';
                $data->update();
                return response()->json("Doctor Image updated");
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function doctorAppointment()
    {
        $id = Auth::guard("doctor")->user()->id;
        $data["all"] = Appointment::with('chamber', 'hospital', 'diagnostic')->where(["doctor_id" => $id])->get();
        $data["new"] = Appointment::with('chamber', 'hospital', 'diagnostic')->where(["doctor_id" => $id, "appointment_date" => date("d-m-Y")])->get();
        return view("doctor.appointment.index", compact("data"));
    }

    public function todayAppointment()
    {
        $id = Auth::guard("doctor")->user()->id;
        $data["new"] = Appointment::with('chamber', 'hospital', 'diagnostic')->where(["doctor_id" => $id, "appointment_date" => date("d-m-Y")])->get();
        return view("doctor.appointment.today_patient", compact("data"));
    }

    public function doctorPatient($id)
    {
        $ids = Auth::guard("doctor")->user()->id;
        $data["new"] = Appointment::where(["doctor_id" => $ids, "appointment_date" => date("d/m/Y")])->get();
        $patients = Appointment::find($id);
        return view("doctor.appointment.patient", compact("data", "patients"));
    }

    public function comment(Request $request)
    {
        try {
            $data = Appointment::where("id", $request->id)->first();
            $data->comment = $request->comment;
            $data->update();
            return response()->json("Comment Send Successfully");
        } catch (\Throwable $e) {
            return response()->json("Something went wrong" . $e->getMessage());
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

    public function getHospital()
    {
        return Hospital::get();
    }

    public function getDiagnostic()
    {
        return Diagnostic::get();
    }

    public function fetchDoctor($id)
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

        foreach ($carts as $cart) {
            $cart->daywiseTimeArray = DB::select("SELECT dt.* FROM day_times dt WHERE dt.type_id = '$cart->id'");
        }

        return response()->json(["doctor" => $doctor, "carts" => $carts]);
    }
}
