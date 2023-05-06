<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Department;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
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
        if (!in_array("department.index", $access)) {
            return view("admin.unauthorize");
        }

        return view("admin.department.index");
    }

    public function getData()
    {
        $data = Department::latest()->get();
        return response()->json(["data" => $data]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required"
            ], ["name.required" => "Department name required"]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $dept = new Department();
                $dept->name = $request->name;
                if ($request->hasFile('image')) {
                    $dept->image = $this->imageUpload($request, 'image', 'uploads/department');
                }
                $dept->save();
                $id = $dept->id;
                return response()->json(["msg" => "Department added successfully", "id" => $id]);
            }
        } catch (\Throwable $e) {
            return response()->json(['msg' => "Something went wrong"]);
        }
    }
    public function edit(Request $request)
    {
        try {
            $data = DB::table("departments")->where("id", $request->id)->first();
            return response()->json($data);
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required"
            ], ["name.required" => "Department name required"]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Department::find($request->id);
                $data->name = $request->name;
                $data->updated_at = Carbon::now();
                if ($request->hasFile('image')) {
                    if (File::exists($data->image)) {
                        File::delete($data->image);
                    }
                    $data->image = $this->imageUpload($request, 'image', 'uploads/department');
                }
                $data->update();
                return response()->json("Department updated successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Department::find($request->id);
            if (File::exists($data->image)) {
                File::delete($data->image);
            }
            $data->delete();
            return response()->json("Department delete successfully");
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }
}
