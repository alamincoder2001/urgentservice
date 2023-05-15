<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Devfaysal\BangladeshGeocode\Models\District;

class CityController extends Controller
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
        if (!in_array("city.index", $access)) {
            return view("admin.unauthorize");
        }

        return view("admin.city.index");
    }

    public function fetch()
    {
        $data = DB::select("SELECT * FROM districts");
        return response()->json(["data" => $data]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required"
            ], ["name.required" => "City name required"]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if (empty($request->id)) {
                    $data = new District();
                } else {
                    $data = District::find($request->id);
                }
                $data->name = $request->name;
                $data->save();
                $city_id = $data->id;
                if (empty($request->id)) {
                    return response()->json(["msg" => "City added successfully", "id" => $city_id]);
                } else {
                    return response()->json(["msg" => "City update successfully", "id" => $city_id]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }
    public function edit($id)
    {
        try {
            $data = DB::table("districts")->where("id", $id)->first();
            return response()->json($data);
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function destroy($id)
    {
        District::find($id)->delete();
        return response()->json("City delete successfully");
    }
}
