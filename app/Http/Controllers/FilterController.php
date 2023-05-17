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
use Illuminate\Support\Facades\DB;

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

    public function doctor(Request $request)
    {
        try {
            $clauses = "";
            if (!empty($request->city)) {
                $clauses .= " AND doc.city_id='$request->city'";
            }
            if (!empty($request->doctor_name)) {
                $clauses .= " AND doc.name LIKE '%$request->doctor_name%'";
            }

            if (!empty($request->department)) {
                $clauses .= " AND sp.department_id LIKE '%$request->department%'";
            }

            $doctor = DB::select("SELECT
                                        sp.*,
                                        doc.name,
                                        doc.username,
                                        doc.phone,
                                        doc.address,
                                        doc.city_id,
                                        doc.description,
                                        doc.education,
                                        doc.email,
                                        doc.image,
                                        dept.name as department_name,
                                        d.name as city_name
                                    FROM specialists sp
                                    LEFT JOIN doctors doc ON doc.id = sp.doctor_id
                                    LEFT JOIN departments dept ON dept.id = sp.department_id
                                    LEFT JOIN districts d ON d.id = doc.city_id
                                    WHERE 1 = 1 $clauses ORDER BY doc.name ASC");

            $data = ["status" => true, "message" => $doctor];
            return $data;
        } catch (\Throwable $th) {
            $data = ["status" => false, "message" => $th->getMessage()];
            return $data;
        }
    }

    // doctor single change
    public function doctorsinglechange(Request $request)
    {
        try {
            $clauses = "";
            if (!empty($request->city)) {
                $clauses .= " AND doc.city_id='$request->city'";
            }
            if (!empty($request->doctor_name)) {
                $clauses .= " AND doc.name LIKE '%$request->doctor_name%'";
            }

            $doctor = DB::select("SELECT
                                        sp.*,
                                        doc.name,
                                        doc.username,
                                        doc.phone,
                                        doc.address,
                                        doc.city_id,
                                        doc.education,
                                        doc.description,
                                        doc.email,
                                        doc.image,
                                        dept.name as department_name,
                                        d.name as city_name
                                    FROM specialists sp
                                    LEFT JOIN doctors doc ON doc.id = sp.doctor_id
                                    LEFT JOIN departments dept ON dept.id = sp.department_id
                                    LEFT JOIN districts d ON d.id = doc.city_id
                                    WHERE 1 = 1 $clauses ORDER BY doc.name ASC");

            $data = ["status" => true, "message" => $doctor];
            return $data;
        } catch (\Throwable $th) {
            $data = ["status" => false, "message" => $th->getMessage()];
            return $data;
        }
    }

    public function diagnostic(Request $request)
    {
        try {
            $clauses = "";
            if (!empty($request->city)) {
                $clauses .= " AND diag.city_id='$request->city'";
            }
            if (!empty($request->diagnostic_name)) {
                $clauses .= " AND diag.name LIKE '%$request->diagnostic_name%'";
            }

            $diagnostic = DB::select("SELECT
                                        diag.id,
                                        diag.name,
                                        diag.username,
                                        diag.phone,
                                        diag.address,
                                        diag.city_id,
                                        diag.description,
                                        diag.diagnostic_type,
                                        diag.email,
                                        diag.discount_amount,
                                        diag.image,
                                    d.name as city_name
                                    FROM diagnostics diag
                                    LEFT JOIN districts d ON d.id = diag.city_id 
                                    WHERE 1 = 1 $clauses ORDER BY diag.name ASC");

            $data = ["status" => true, "message" => $diagnostic];
            return $data;
        } catch (\Throwable $th) {
            $data = ["status" => false, "message" => $th->getMessage()];
            return $data;
        }
    }

    public function ambulance(Request $request)
    {
        try {
            $clauses = "";
            if (!empty($request->city)) {
                $clauses .= " AND amb.city_id='$request->city'";
            }
            if (!empty($request->ambulance_name)) {
                $clauses .= " AND amb.name LIKE '%$request->ambulance_name%'";
            }
            if (!empty($request->ambulance_type)) {
                $clauses .= " AND amb.ambulance_type='$request->ambulance_type'";
            }

            $ambulance = DB::select("SELECT
                                        amb.*,
                                    d.name as city_name
                                    FROM ambulances amb
                                    LEFT JOIN districts d ON d.id = amb.city_id 
                                    WHERE 1 = 1 $clauses ORDER BY amb.name ASC");

            $data = ["status" => true, "message" => $ambulance];
            return $data;
        } catch (\Throwable $th) {
            $data = ["status" => false, "message" => $th->getMessage()];
            return $data;
        }
    }

    public function privatecar(Request $request)
    {
        try {
            $clauses = "";
            if (!empty($request->city)) {
                $clauses .= " AND p.city_id='$request->city'";
            }
            if (!empty($request->privatecar_name)) {
                $clauses .= " AND p.name LIKE '%$request->privatecar_name%'";
            }
            if (!empty($request->privatecar_type)) {
                $clauses .= " AND cwp.cartype_id='$request->privatecar_type'";
            }

            $privatecar = DB::select("SELECT
                                        cwp.*,
                                        p.id as privatecar_id,
                                        p.name,
                                        p.username,
                                        p.phone,
                                        p.email,
                                        p.city_id,
                                        p.address,
                                        p.image,
                                        ct.name as cartype,
                                        d.name as city_name
                                    FROM category_wise_privatecars cwp
                                    LEFT JOIN privatecars p ON p.id = cwp.privatecar_id
                                    LEFT JOIN cartypes ct ON ct.id = cwp.cartype_id
                                    LEFT JOIN districts d ON d.id = p.city_id
                                    WHERE 1 = 1 $clauses ORDER BY p.name ASC");

            $data = ["status" => true, "message" => $privatecar];
            return $data;
        } catch (\Throwable $th) {
            $data = ["status" => false, "message" => $th->getMessage()];
            return $data;
        }
    }
    public function hospital(Request $request)
    {
        try {
            $clauses = "";
            if (!empty($request->city)) {
                $clauses .= " AND hosp.city_id='$request->city'";
            }
            if (!empty($request->hospital_name)) {
                $clauses .= " AND hosp.name LIKE '%$request->hospital_name%'";
            }

            $hospital = DB::select("SELECT
                                        hosp.id,
                                        hosp.name,
                                        hosp.username,
                                        hosp.phone,
                                        hosp.address,
                                        hosp.city_id,
                                        hosp.description,
                                        hosp.hospital_type,
                                        hosp.email,
                                        hosp.discount_amount,
                                        hosp.image,
                                    d.name as city_name
                                    FROM hospitals hosp
                                    LEFT JOIN districts d ON d.id = hosp.city_id 
                                    WHERE 1 = 1 $clauses ORDER BY hosp.name ASC");

            $data = ["status" => true, "message" => $hospital];
            return $data;
        } catch (\Throwable $th) {
            $data = ["status" => false, "message" => $th->getMessage()];
            return $data;
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
            } elseif ($request->city) {
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
}
