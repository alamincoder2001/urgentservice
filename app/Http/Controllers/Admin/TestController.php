<?php

namespace App\Http\Controllers\Admin;

use App\Models\Test;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
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
        if (!in_array("test.index", $access)) {
            return view("admin.unauthorize");
        }
        
        return view("admin.test.index");
    }

    public function fetch()
    {
        $id = Auth::guard("admin")->user()->id;
        $data = Test::where("admin_id", $id)->orderBy("name")->get();
        return response()->json(["data" => $data]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "amount" => "required|numeric"
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if ($request->test_id != "") {
                    $data = Test::find($request->test_id);
                } else {
                    $data = new Test();
                }

                $data->name = $request->name;
                $data->admin_id = Auth::guard("admin")->user()->id;
                $data->amount = $request->amount;
                $data->save();
                if ($request->test_id != "") {
                    return "Test updated successfull";
                } else {
                    return "Test create successfull";
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Opps! something went wrong");
        }
    }

    public function edit($id)
    {
        return Test::find($id);
    }

    public function destroy(Request $request)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("user.destroy", $access)) {
            return view("admin.unauthorize");
        }

        try {
            Test::find($request->id)->delete();
            return "Test successfully deleted";
        } catch (\Throwable $e) {
            return "Opps! something went wrong";
        }
    }
}
