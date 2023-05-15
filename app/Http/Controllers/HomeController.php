<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Slider;
use App\Models\Cartype;
use App\Models\Partner;
use App\Models\Hospital;
use App\Models\Ambulance;
use App\Models\Department;
use App\Models\Diagnostic;
use App\Models\Privatecar;
use App\Models\Specialist;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryWisePrivatecar;
use Illuminate\Support\Facades\Validator;
use Devfaysal\BangladeshGeocode\Models\Upazila;

class HomeController extends Controller
{

    // frontend section
    public function index()
    {
        $data['slider'] = Slider::latest()->limit(4)->get();
        $data['partner'] = Partner::latest()->get();
        $data["specialist"] = Specialist::with("doctor", "specialist")->groupBy("doctor_id")->latest()->limit(8)->get();
        return view('website', compact("data"));
    }
    //doctor
    public function doctor($any = null)
    {
        $department = null;
        $city_id = null;
        if ($any != null) {
            if ($any == 'department') {
                $dept = Department::where("name", $_GET['name'])->first();
                $department .= $dept->name;
                $data["specialist"] = Specialist::where("department_id", $dept->id)->with("doctor", "specialist")->groupBy("doctor_id")->latest()->paginate(24);
            } else if ($any == "city") {
                $city_id .= $_GET['id'];
                $data['specialist'] = Specialist::with("doctor", "specialist")->groupBy("doctor_id")->orderBy('id', 'desc')->get()->filter(function ($data, $key) {
                    return $data->doctor->city_id == $_GET['id'];
                });
            } else {
                return redirect("/");
            }
        } else {
            $data["specialist"] = Specialist::with("doctor", "specialist")->groupBy("doctor_id")->orderBy('id', 'desc')->paginate(24);
        }
        return view('doctor_details', compact("data", "department", "city_id"));
    }
    //hospital
    public function hospital($city_id = null)
    {
        if ($city_id == null) {
            $total_hospital = Hospital::get()->count();
            $data['hospital'] = Hospital::with('city')->orderBy('id', 'DESC')->paginate(24);
        } else {
            $total_hospital = Hospital::where('city_id', $city_id)->get()->count();
            $data['hospital'] = Hospital::with('city')->where('city_id', $city_id)->orderBy('id', 'DESC')->paginate(24);
        }
        return view('hospital_details', compact("data", "total_hospital", "city_id"));
    }
    //diagnostic
    public function diagnostic($city_id = null)
    {
        if ($city_id == null) {
            $total_diagnostic = Diagnostic::get()->count();
            $data['diagnostic'] = Diagnostic::with('city')->orderBy('id', 'DESC')->paginate(24);
        } else {
            $total_diagnostic = Diagnostic::where('city_id', $city_id)->get()->count();
            $data['diagnostic'] = Diagnostic::with('city')->where('city_id', $city_id)->orderBy('id', 'DESC')->paginate(24);
        }
        return view('diagnostic_details', compact("data", "total_diagnostic", "city_id"));
    }
    //ambulance
    public function ambulance($any = null)
    {
        $type = null;
        $city_id = null;
        $data['ambulance_types'] = Ambulance::groupBy('ambulance_type')->get();
        if ($any != null) {
            if ($any == 'type') {
                $type .= $_GET['type_name'];
                $data['ambulance'] = Ambulance::with('city')->where('ambulance_type', $_GET['type_name'])->orderBy('id', 'DESC')->paginate(24);
            } else if ($any == "city") {
                $city_id .= $_GET['id'];
                $data['ambulance'] = Ambulance::with('city')->where('city_id', $_GET['id'])->orderBy('id', 'DESC')->paginate(24);
            } else {
                return redirect("/");
            }
        } else {
            $data['ambulance'] = Ambulance::with('city')->orderBy('id', 'DESC')->paginate(24);
        }
        return view('ambulance_details', compact("data", 'type', 'city_id'));
    }

    //ambulance
    public function privatecar($any = null)
    {
        $categories = Cartype::with('typewiseprivatecar')->latest()->get();

        $type_id = null;
        $city_id = null;
        if ($any != null) {
            if ($any == 'type') {
                $type_id .= $_GET['id'];
                $data['privatecar'] = CategoryWisePrivatecar::with('privatecar', 'cartype')->where('cartype_id', $_GET['id'])->paginate(24);
            } else if ($any == "city") {
                $city_id .= $_GET['id'];
                $data['privatecar'] = CategoryWisePrivatecar::with('privatecar', 'cartype')->get()->filter(function ($data) {
                    return $data->privatecar->city_id == $_GET['id'];
                });
            } else {
                return redirect("/");
            }
        } else {
            $data['privatecar'] = CategoryWisePrivatecar::with('privatecar', 'cartype')->paginate(24);
        }
        $cartypes = Cartype::orderBy("name", "ASC")->get();
        return view('privatecar_details', compact("data", "cartypes", "categories", "type_id", "city_id"));
    }

    // single doctor
    public function singledoctor($id = null)
    {
        $data = Doctor::with("department")->find($id);
        $related = Specialist::with('doctor')->where("department_id", $data->department[0]->department_id)->get();
        $filtered = [];

        foreach ($related as $value) {
            if ($value->doctor_id != $id) {
                array_push($filtered, $value);
            }
            if (count($filtered) == 4) {
                break;
            }
        }

        $doctor_details = $this->fetchDoctorDetails($id);

        return view("doctor_single_page", compact("data", "filtered", "doctor_details"));
    }

    public function fetchDoctorDetails($id)
    {
        $carts = DB::select("SELECT cdh.*,
                    d.name AS doctor_name,
                    h.name AS hospital_name, 
                    h.address AS hospital_address,
                    h.discount_amount AS hospital_discount,
                    diag.name AS diagnostic_name, 
                    diag.address AS diagnostic_address,
                    diag.discount_amount AS diagnostic_discount
                FROM chamber_diagnostic_hospitals cdh
                JOIN doctors d ON d.id = cdh.doctor_id
                LEFT JOIN hospitals h ON h.id = cdh.hospital_id
                LEFT JOIN diagnostics diag ON diag.id = cdh.diagnostic_id
                WHERE cdh.doctor_id = '$id'");

        foreach ($carts as $cart) {
            $cart->daywiseTimeArray = DB::select("SELECT dt.* FROM day_times dt WHERE dt.type_id = '$cart->id' GROUP BY dt.day");
        }

        return $carts;
    }

    // single hospital
    public function singlehospital($id = null)
    {
        $data = Hospital::with('hospital_wise_doctor')->find($id);
        return view("hospital_single_page", compact("data"));
    }
    // single diagnostic
    public function singlediagnostic($id = null)
    {
        $data = Diagnostic::with('diagnostic_wise_doctor')->find($id);
        return view("diagnostic_single_page", compact("data"));
    }
    // single ambulance
    public function singleambulance($id = null)
    {
        $data = Ambulance::find($id);
        return view("ambulance_single_page", compact("data"));
    }
    // single ambulance
    public function singleprivatecar($id = null)
    {
        $data = Privatecar::with('typewisecategory')->find($id);
        return view("privatecar_single_page", compact("data"));
    }

    public function pathology()
    {
        return view("pathology");
    }


    // home filter
    public function filter(Request $request)
    {
        try {
            if ($request->department_id) {
                $data = Specialist::with("doctor", "specialist")->where("department_id", $request->department_id)->get();
            } else {
                $data = Specialist::with("doctor", "specialist")->groupBy("doctor_id")->latest()->limit(8)->get();
            }
            return response()->json($data);
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function prescription(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "image" => "required|mimes:jpg,png,pdf"
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            }
            $data = new Prescription();
            $data->image = $this->imageUpload($request, 'image', 'uploads/patient') ?? '';
            $data->save();
            return "Prescription send successfully";
        } catch (\Throwable $e) {
            return "Opps! something went wrong";
        }
    }

    public function getupazila($id)
    {
        return Upazila::where("district_id", $id)->get();
    }
}
