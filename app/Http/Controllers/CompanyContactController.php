<?php

namespace App\Http\Controllers;

use App\Models\CompanyContact;
use App\Models\DiagnosticContact;
use App\Models\HospitalContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CompanyContactController extends Controller
{
    public function index()
    {
        if (Auth::guard("admin")->check()) {
            $data = CompanyContact::latest()->get();
            return view("admin.companycontact.index", compact("data"));
        }
    }

    public function destroy($id){
        if(Auth::guard("admin")->check()){
            $data = CompanyContact::find($id);
            $old = $data->image;
            if(File::exists($old)){
                File::delete($old);
            }
            $data->delete();
            return "Contact delete successfull";
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email",
                "phone" => "required|numeric",
                "message" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            } else {
                $data = new CompanyContact;
                $data->name = $request->message;
                $data->email = $request->email;
                $data->phone = $request->phone;
                $data->message = $request->message;
                $data->save();
                return "Successfully send message";
            }
        } catch (\Throwable $e) {
            return response()->json();
        }
    }


    // hospital contact section
    public function hospitalcontact()
    {
        if (Auth::guard("hospital")->check()) {
            $id = Auth::guard("hospital")->user()->id;
            $data = HospitalContact::where("hospital_id", $id)->latest()->get();
            return view("hospital.contact.index", compact("data"));
        }
    }
    public function diagnosticcontact()
    {
        if (Auth::guard("diagnostic")->check()) {
            $id = Auth::guard("diagnostic")->user()->id;
            $data = DiagnosticContact::where("diagnostic_id", $id)->latest()->get();
            return view("diagnostic.contact.index", compact("data"));
        }
    }

    public function hospitaldiagnosticcontact(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email",
                "phone" => "required|numeric|min:11",
                "subject" => "required",
                "message" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            } else {
                if($request->hospital){
                    HospitalContact::create($request->all());
                }else{
                    DiagnosticContact::create($request->all());
                }
                return "Successfully send message";
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }
}
