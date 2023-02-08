<?php

namespace App\Http\Controllers\Admin;

use App\Models\Test;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Models\Investigation;
use App\Http\Controllers\Controller;
use App\Models\InvestigationDetails;
use Illuminate\Support\Facades\Auth;

class InvestigationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("investigation.index", $access)) {
            return view("admin.unauthorize");
        }
        $tests = Test::orderBy("name")->get();
        return view("admin.investigation.index", compact("tests"));
    }

    public function fetchInvestigation()
    {
        $data = Investigation::latest()->get();
        return response()->json(["data" => $data]);
    }

    // send investigation

    public function investigation(Request $request)
    {
        try {
            $data = new Investigation;
            $data->date = date("d-m-Y");
            $data->admin_id = Auth::guard("admin")->user()->id;
            $data->patient_name = $request->patient_name;
            $data->patient_phone = $request->patient_phone;
            $data->discount = $request->discount;
            $data->total_amount = $request->total;
            $data->total = $request->alltotal;
            $data->save();

            $data_id = $data->id;
            foreach ($request->test_id as $id) {
                $details = new InvestigationDetails();
                $test = Test::find($id);
                $details->investigation_id = $data_id;
                $details->name = $test->name;
                $details->price = $test->amount;
                $details->save();
            }
            return "Successfully investigation send";
        } catch (\Throwable $e) {
            return "Opps! something went wrong";
        }
    }

    public function destroy($id)
    {
        Investigation::find($id)->delete();
        return "Investigation delete successfully";
    }

    public function show($id)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("investigation.index", $access)) {
            return view("admin.unauthorize");
        }
        $data = Investigation::with('investigationDetails')->find($id);
        return view("admin.investigation.show", compact("data"));
    }
}
