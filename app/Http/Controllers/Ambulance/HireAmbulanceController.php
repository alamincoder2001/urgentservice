<?php

namespace App\Http\Controllers\Ambulance;

use App\Http\Controllers\Controller;
use App\Models\ContactAmbulance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HireAmbulanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:ambulance');
    }

    public function index()
    {
        $id = Auth::guard("ambulance")->user()->id;
        $data["hireambulance"] = ContactAmbulance::where("ambulance_id", $id)->get();
        return view("ambulance.hireambulance.index", compact("data"));
    }

    public function comment(Request $request)
    {
        try{
            $data = ContactAmbulance::where("id", $request->id)->first();
            $data->comment = $request->comment;
            $data->update();
            return response()->json("Comment on Ambulance clients");
        }catch(\Throwable $e){
            return response()->json("Something went wrong");
        }
    }
}
