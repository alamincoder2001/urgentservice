<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Ambulance;
use App\Models\Diagnostic;
use App\Models\Donor;
use App\Models\Privatecar;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Devfaysal\BangladeshGeocode\Models\District;

class FilterController extends Controller
{
    // appoinment page filltering
    public function cityappointment(Request $request)
    {
        try {
            $data = Upazila::where("district_id", $request->id)->orderBy('name')->get();
            if (count($data) !== 0) {
                return response()->json($data);
            } else {
                return response()->json(["null" => "Not Found Data"]);
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function City(Request $request)
    {
        try {
            if ($request->doctor || $request->service == "Doctor") {
                $data = Doctor::with("department", "chamber")->where("city_id", $request->id)->orderBy('name')->get();
            } elseif ($request->hospital || $request->service == "Hospital") {
                $data = Hospital::with("city")->where("city_id", $request->id)->orderBy('name')->get();
            } elseif ($request->diagnostic || $request->service == "Diagnostic") {
                $data = Diagnostic::with("city")->where("city_id", $request->id)->orderBy('name')->get();
            } elseif ($request->ambulance || $request->service == "Ambulance") {
                $data = Ambulance::with("city")->where("city_id", $request->id)->orderBy('name')->get();
            } else {
                $data = Privatecar::with("city")->where("city_id", $request->id)->orderBy('name')->get();
            }
            if (isset($data) !== 0) {
                return response()->json($data);
            } else {
                return response()->json(["null" => "Not Found Data"]);
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function doctor(Request $request)
    {
        try {
            if (!empty($request->city) && !empty($request->department)) {
                $doctor = Specialist::with("doctor", "specialist")->where("department_id", $request->department)->get();
                $data = [];
                foreach($doctor as $value) {
                    if($value->doctor->city_id == $request->city) {
                        array_push($data, $value);
                    }
                }
            } else if (!empty($request->doctor_name)) {
                $data = Doctor::with("city", "time", "department", "hospital", "diagnostic", "chamber")->where('name', 'like', '%' . $request->doctor_name . '%')->orderBy('name', 'ASC')->get();
            } else {
                $doctor = Specialist::with("doctor", "specialist")->get();
                $data = [];
                foreach($doctor as $value) {
                    if($value->doctor->city_id == $request->city) {
                        array_push($data, $value);
                    }
                }
            }
            if (count($data) !== 0) {
                return response()->json($data);
            } else {
                return response()->json(["null" => "Not Found Data"]);
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong".$e->getMessage());
        }
    }

    // doctor single change
    public function doctorsinglechange(Request $request)
    {
        try {
            $data = Doctor::with("city", "department", "hospital", "diagnostic", "chamber")->where("id", $request->id)->orderBy('name')->get();
            if (!empty($data)) {
                return response()->json($data);
            } else {
                return response()->json(["null" => "Not Found Data"]);
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function diagnostic(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "city" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $dataArry = ["city_id" => $request->city, "name" => $request->diagnostic_name];
                if (!empty($request->diagnostic_name)) {
                    $data = Diagnostic::with("city")->where($dataArry)->orderBy('name')->get();
                } else {
                    $data = Diagnostic::with("city")->where("city_id", $request->city)->orderBy('name')->get();
                }
                if (count($data) !== 0) {
                    return response()->json($data);
                } else {
                    return response()->json(["null" => "Not Found Data"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function ambulance(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "city" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $dataArry = ["city_id" => $request->city, "name" => $request->ambulance_name];
                if (!empty($request->ambulance_name)) {
                    $data = Ambulance::with("city")->where($dataArry)->orderBy('name')->get();
                } else {
                    $data = Ambulance::with("city")->where("city_id", $request->city)->orderBy('name')->get();
                }
                if (count($data) !== 0) {
                    return response()->json($data);
                } else {
                    return response()->json(["null" => "Not Found Data"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function privatecar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "city" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $dataArry = ["city_id" => $request->city, "name" => $request->privatecar_name];
                if (!empty($request->privatecar_name)) {
                    $data = Privatecar::with("city", "typewisecategory")->where($dataArry)->orderBy('name')->get();
                } else {
                    $data = Privatecar::with("city", "typewisecategory")->where("city_id", $request->city)->orderBy('name')->get();
                }
                if (count($data) !== 0) {
                    return response()->json($data);
                } else {
                    return response()->json(["null" => "Not Found Data"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong".$e->getMessage());
        }
    }
    public function hospital(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "city" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $dataArry = ["city_id" => $request->city, "name" => $request->hospital_name];
                if (!empty($request->hospital_name)) {
                    $data = Hospital::with("city")->where($dataArry)->orderBy('name')->orderBy('name')->get();
                } else {
                    $data = Hospital::with("city")->where("city_id", $request->city)->orderBy('name')->get();
                }
                if (count($data) !== 0) {
                    return response()->json($data);
                } else {
                    return response()->json(["null" => "Not Found Data"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }
    public function hospitaldiagnosticdoctor(Request $request)
    {
        try {
            if (empty($request->department)) {
                $data = Specialist::with("doctor", "specialist")->get();
            } else {
                $data = Specialist::with("doctor", "specialist")->where("department_id", $request->department)->get();
            }

            if (count($data) !== 0) {
                return response()->json($data);
            } else {
                return response()->json(["null" => "Not Found Data"]);
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function cityall()
    {
        $data = District::all();
        return response()->json($data);
    }

    // donor filter
    public function filterdonor(Request $request)
    {
        try {
            if ($request->group) {
                $data = Donor::with('city', 'group')->where("blood_group", $request->group)->orderBy('name')->get();
            }elseif($request->city){
                $data = Donor::with('city', 'group')->where('city_id', $request->city)->latest()->get();
            } else {
                $data = Donor::with('city', 'group')->latest()->get();
            }
            if (count($data) !== 0) {
                return response()->json($data);
            } else {
                return response()->json(["null" => "Not Found Data"]);
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    // single doctor,diagnostic,hospital,privatecar,ambulance
    public function filtersingleservice(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "service" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }

            if ($request->service == "Doctor") {
                if ($request->service == "Doctor" && $request->name) {
                    return response()->json(Doctor::with("city", "department", "hospital", "time", "chamber")->where("id", $request->name)->get());
                } else {
                    return response()->json(Doctor::with("city", "department", "hospital", "time", "chamber")->get());
                }
            } else if ($request->service == "Hospital") {
                if ($request->service == "Hospital" && $request->name) {
                    return Hospital::with("city")->where("id", $request->name)->get();
                } else {
                    return Hospital::with("city")->get();
                }
            } else if ($request->service == "Diagnostic") {
                if ($request->service == "Diagnostic" && $request->name) {
                    return Diagnostic::with("city")->where("id", $request->name)->get();
                } else {
                    return Diagnostic::with("city")->get();
                }
            } else if ($request->service == "Ambulance") {
                if ($request->service == "Ambulance" && $request->name) {
                    return Ambulance::with("city")->where("id", $request->name)->get();
                } else {
                    return Ambulance::with("city")->get();
                }
            } else {
                if ($request->service == "Privatecar" && $request->name) {
                    return Privatecar::with("city")->where("id", $request->name)->get();
                } else {
                    return Privatecar::with("city")->get();
                }
            }
        } catch (\Throwable $e) {
            return "Opps! something went wrong";
        }
    }
}
