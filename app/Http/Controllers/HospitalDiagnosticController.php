<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticComment;
use App\Models\HospitalComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalDiagnosticController extends Controller
{
    public function diagnosticcomment(Request $request)
    {
        if(Auth::guard("diagnostic")->check()){
            try{
                $check = DiagnosticComment::where("contact_id", $request->id)->first();
                if($check){
                    $data = DiagnosticComment::where("contact_id", $request->id)->first();
                }else{
                    $data = new DiagnosticComment();
                }
                $data->diagnostic_id = $request->diagnostic_id;
                $data->contact_id = $request->id;
                $data->diagnostic_comment = $request->diagnostic_comment;
                $data->save();
                return response()->json("Comment Send");
            }catch(\Throwable $e){
                return response()->json("Something went wrong");
            }
        }
    }
    public function hospitalcomment(Request $request)
    {
        if(Auth::guard("hospital")->check()){
            try{
                $check = HospitalComment::where("contact_id", $request->id)->first();
                if($check){
                    $data = HospitalComment::where("contact_id", $request->id)->first();
                }else{
                    $data = new HospitalComment();
                }
                $data->hospital_id = $request->hospital_id;
                $data->contact_id = $request->id;
                $data->hospital_comment = $request->hospital_comment;
                $data->save();
                return response()->json("Comment Send");
            }catch(\Throwable $e){
                return response()->json("Something went wrong".$e->getMessage());
            }
        }
    }
}
