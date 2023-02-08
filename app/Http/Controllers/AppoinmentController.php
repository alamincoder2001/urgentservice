<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Mail\PatientNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AppoinmentController extends Controller
{
    public function appointment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "appointment_date" => "required",
                "name"             => "required",
                "age"              => "required|numeric",
                "district"         => "required",
                "upozila"          => "required",
                "changeName"       => "required",
                "contact"          => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if (!empty($request->chamber_name) || !empty($request->hospital_id) || !empty($request->diagnostic_id)) {
                    $data = new Appointment();
                    $data->appointment_date = $request->appointment_date;
                    $data->name = $request->name;
                    $data->age = $request->age;
                    $data->district = $request->district;
                    $data->upozila = $request->upozila;
                    $data->contact = $request->contact;
                    $data->doctor_id = $request->doctor_id;
                    if (!empty($request->hospital_id)) {
                        $data->hospital_id = $request->hospital_id;
                    }
                    if (!empty($request->diagnostic_id)) {
                        $data->diagnostic_id = $request->diagnostic_id;
                    }
                    if (!empty($request->problem)) {
                        $data->problem = $request->problem;
                    }
                    if (!empty($request->email)) {
                        $data->email = $request->email;
                    }
                    $data->save();
                    //send mail
                    $mail = 'ialamin573@gmail.com';
                    Mail::to($mail)->send(new PatientNotification($request->name, $request->contact, $request->problem));
                    return response()->json("Appointment Send");
                } else {
                    return response()->json(["errors" => "Must be select Chamber name Or Hospital name or Dignostic Name"]);
                }
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
}
