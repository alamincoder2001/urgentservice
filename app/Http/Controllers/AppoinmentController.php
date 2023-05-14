<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Chamber;
use App\Models\Hospital;
use App\Models\Diagnostic;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Mail\PatientNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AppoinmentController extends Controller
{
    public function appointment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "appointment_date" => "required",
                "organization_id"  => "required",
                "name"             => "required",
                "age"              => "required|numeric",
                "district"         => "required",
                "upozila"          => "required",
                "contact"          => "required",
                "patient_type"     => "required",
            ],["organization_id.required" => "The chamber field is required."]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data                   = new Appointment();
                $data->appointment_date = $request->appointment_date;
                $data->name             = $request->name;
                $data->age              = $request->age;
                $data->district         = $request->district;
                $data->upozila          = $request->upozila;
                $data->contact          = $request->contact;
                $data->doctor_id        = $request->doctor_id;
                $data->patient_type     = $request->patient_type;
                $data->email            = $request->email;
                if (!isset($request->organization_name) || $request->organization_name == '') {
                    return response()->json(["errors" => "Organization is empty"]);
                }
                if ($request->organization_name == "hospital") {
                    $data->hospital_id = $request->organization_id;
                } elseif ($request->organization_name == "diagnostic") {
                    $data->diagnostic_id = $request->organization_id;
                } else {
                    $data->chamber_name = $request->organization_id;
                }
                $data->save();
                //send mail
                $mail = 'ialamin573@gmail.com';
                Mail::to($mail)->send(new PatientNotification($request->name, $request->contact, $request->problem));
                return response()->json("Appointment Send Successful");
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function getDetails(Request $request)
    {
        try {
            $data = Appointment::with("city", "upazila")->where("contact", $request->number)->first();
            if (!empty($data)) {
                return response()->json($data);
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function organization($id)
    {
        $data = DB::select("SELECT cdh.*,
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
                            
        return response()->json($data);
    }
}
