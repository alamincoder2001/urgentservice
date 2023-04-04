<?php

namespace App\Http\Controllers\Admin;

use App\Models\Diagnostic;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DiagnosticController extends Controller
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
        if (!in_array("diagnostic.index", $access)) {
            return view("admin.unauthorize");
        }
        
        $diagnostic = DB::table("diagnostics")->orderBy("id", 'DESC')->get();
        return view("admin.diagnostic.index", compact("diagnostic"));
    }

    public function create()
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("diagnostic.create", $access)) {
            return view("admin.unauthorize");
        }

        return view("admin.diagnostic.create");
    }

    public function store(Request $request)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("diagnostic.store", $access)) {
            return view("admin.unauthorize");
        }

        try {
            $validator = Validator::make($request->all(), [
                "name"            => "required",
                "username"        => "required|unique:diagnostics",
                "email"           => "required|email",
                "phone"           => "required",
                "city_id"         => "required",
                "discount_amount" => "required",
                "diagnostic_type" => "required",
                "address"         => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data                  = new Diagnostic;
                $data->image           = $this->imageUpload($request, 'image', 'uploads/diagnostic') ?? '';
                $data->name            = $request->name;
                $data->username        = $request->username;
                $data->email           = $request->email;
                $data->password        = Hash::make($request->password);
                $data->diagnostic_type = $request->diagnostic_type;
                $data->phone           = implode(",", $request->phone);
                $data->discount_amount = $request->discount_amount;
                $data->city_id         = $request->city_id;
                $data->address         = $request->address;
                $data->description     = $request->description;
                $data->map_link        = $request->map_link;

                $data->save();
                return response()->json("Diagnostic added successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function edit($id)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("diagnostic.edit", $access)) {
            return view("admin.unauthorize");
        }

        $data = Diagnostic::find($id);
        return view("admin.diagnostic.edit", compact('data'));
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name"            => "required",
                "username"        => "required|unique:diagnostics,username," . $request->id,
                "email"           => "required|email",
                "phone"           => "required",
                "city_id"         => "required",
                "discount_amount" => "required",
                "diagnostic_type" => "required",
                "address"         => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Diagnostic::find($request->id);
                $old = $data->image;
                if ($request->hasFile('image')) {
                    if (File::exists($old)) {
                        File::delete($old);
                    }
                    $data->image = $this->imageUpload($request, 'image', 'uploads/diagnostic') ?? '';
                }
                $data->name     = $request->name;
                $data->username = $request->username;
                $data->email    = $request->email;
                if (!empty($request->password)) {
                    $data->password = Hash::make($request->password);
                }
                $data->diagnostic_type = $request->diagnostic_type;
                $data->phone           = implode(",", $request->phone);
                $data->discount_amount = $request->discount_amount;
                $data->city_id         = $request->city_id;
                $data->address         = $request->address;
                $data->description     = $request->description;
                $data->map_link        = $request->map_link;

                $data->update();
                return response()->json("Diagnostic updated successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function destroy(Request $request)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("diagnostic.destroy", $access)) {
            return view("admin.unauthorize");
        }

        try {
            $data = Diagnostic::find($request->id);
            $old = $data->image;
            if (File::exists($old)) {
                File::delete($old);
            }
            $data->delete();
            return response()->json("Diagnostic Deleted successfully");
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function getDiagnostic()
    {
        $data = Diagnostic::get();
        return response()->json(["data" => $data]);
    }
}
