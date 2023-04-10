<?php

namespace App\Http\Controllers\Diagnostic;

use App\Models\Test;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Investigation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:diagnostic');
    }

    public function index()
    {
        $diagnostic = Auth::guard("diagnostic")->user();
        $data["appointment"] = Appointment::where("diagnostic_id", $diagnostic->id)->get();
        return view("diagnostic.patient.index", compact("data"));
    }

    public function todayPatient()
    {
        $today = date('d-m-Y');
        $diagnostic = Auth::guard("diagnostic")->user();
        $data["appointment"] = Appointment::where("diagnostic_id", $diagnostic->id)->where('appointment_date', $today)->get();
        return view("diagnostic.patient.today_patient", compact("data"));
    }

    public function patient($id)
    {
        $patients = Appointment::find($id);
        return view("diagnostic.patient.patient", compact("patients"));
    }

    public function comment(Request $request)
    {
        try{
            $data = Appointment::find($request->id);
            $data->comment = $request->comment;
            $data->update();
            return response()->json("Diagnostic comment on patient successfull");
        }catch(\Throwable $e){
            return response()->json("Something went wrong");
        }
    }

     // send investigation

     public function investigation(Request $request)
     {
         try {
             foreach ($request->test_id as $id) {
                 $data = new Investigation();
                 $test = Test::find($id);
                 $data->appointment_id = $request->appointment_id;
                 $data->diagnostic_id = Auth::guard("diagnostic")->user()->id;
                 $data->test_id = $id;
                 $data->date = date("d-m-Y");
                 $data->unit_amount = $test->amount;
                 $data->discount = $request->discount;
                 $data->total_amount = $request->total;
                 $data->save();
             }
             return "Successfully investigation send";
         } catch (\Throwable $e) {
             return "Opps! something went wrong";
         }
     }
}
