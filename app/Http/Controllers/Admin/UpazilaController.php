<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UpazilaController extends Controller
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
        if (!in_array("upazila.index", $access)) {
            return view("admin.unauthorize");
        }

        return view("admin.upazila.index");
    }

    public function fetch()
    {
        $data = Upazila::with('district')->latest()->get();
        return response()->json(["data" => $data]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required"
            ], ["name.required" => "Upazila name required"]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if (empty($request->id)) {
                    $data = new Upazila();
                } else {
                    $data = Upazila::find($request->id);
                }
                $data->name = $request->name;
                $data->save();
                if (empty($request->id)) {
                    return response()->json(["msg" => "Upazila added successfully"]);
                } else {
                    return response()->json(["msg" => "Upazila update successfully"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }
    public function edit($id)
    {
        $data = Upazila::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Upazila::find($id)->delete();
        return response()->json("Upazila delete successfully");
    }
}
