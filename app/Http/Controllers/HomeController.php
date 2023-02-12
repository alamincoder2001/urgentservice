<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Slider;
use App\Models\Partner;
use App\Models\Hospital;
use App\Models\Ambulance;
use App\Models\Chamber;
use App\Models\Department;
use App\Models\Diagnostic;
use App\Models\Prescription;
use App\Models\Privatecar;
use App\Models\Specialist;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function doctor($id = null)
    {
        if($id != null){
            $dept_id = Department::where("name", $id)->first()->id;
            $data["specialist"] = Specialist::where("department_id", $dept_id)->with("doctor", "specialist")->groupBy("doctor_id")->latest()->paginate(24);
            
        }else{
            $data["specialist"] = Specialist::with("doctor", "specialist")->groupBy("doctor_id")->latest()->paginate(24);
        }
        return view('doctor_details', compact("data"));
    }
    //hospital
    public function hospital()
    {
        $data['hospital'] = Hospital::latest("id")->paginate(15);
        return view('hospital_details', compact("data"));
    }
    //diagnostic
    public function diagnostic()
    {
        $data['diagnostic'] = Diagnostic::latest("id")->paginate(15);
        return view('diagnostic_details', compact("data"));
    }
    //ambulance
    public function ambulance()
    {
        $data['ambulance'] = Ambulance::latest("id")->paginate(15);
        return view('ambulance_details', compact("data"));
    }
    //ambulance
    public function privatecar()
    {
        $data['privatecar'] = Privatecar::latest("id")->paginate(15);
        return view('privatecar_details', compact("data"));
    }


    // single doctor
    public function singledoctor($id = null)
    {
        $data = Doctor::with("time", "chamber", "department")->find($id);
        $related = Specialist::with('doctor')->where("department_id", $data->department[0]->department_id)->get();
        $filtered = [];

        foreach($related as $value) {
            if($value->doctor_id != $id) {
                array_push($filtered, $value);
            }
            if(count($filtered) == 4){
                break;
            }
        }
        return view("doctor_single_page", compact("data", "filtered"));
    }
    // single hospital
    public function singlehospital($id = null)
    {
        $data = Hospital::with('doctor')->find($id);
        return view("hospital_single_page", compact("data"));
    }
    // single diagnostic
    public function singlediagnostic($id = null)
    {
        $data = Diagnostic::with('doctor')->find($id);
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
        $data = Privatecar::find($id);
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
        try{
            $validator = Validator::make($request->all(), [
                "image" => "required|mimes:jpg,png,pdf"
            ]);

            if($validator->fails()){
                return response()->json(["error" => $validator->errors()]);
            }
            $data = new Prescription();
            $data->image = $this->imageUpload($request, 'image', 'uploads/patient') ?? '';
            $data->save();
            return "Prescription send successfully";
        }catch(\Throwable $e){
            return "Opps! something went wrong";
        }
    }

    public function getupazila($id)
    {
        return Upazila::where("district_id", $id)->get();
    }
}
