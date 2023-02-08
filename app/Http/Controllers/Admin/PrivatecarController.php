<?php

namespace App\Http\Controllers\Admin;

use App\Models\Privatecar;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PrivatecarController extends Controller
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
        if (!in_array("privatecar.index", $access)) {
            return view("admin.unauthorize");
        }

        $privatecars = Privatecar::latest()->get();
        return view("admin.privatecar.index", compact("privatecars"));
    }

    public function create()
    {
        return view("admin.privatecar.create");
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name"           => "required",
                "email"          => "required|email",
                "phone"          => "required|min:11|max:15",
                "city_id"        => "required",
                "cartype_id"     => "required",
                "address"        => "required",
                "car_license"    => "required",
                "driver_license" => "required",
                "driver_nid"     => "required",
                "driver_address" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data                 = new Privatecar;
                $data->image          = $this->imageUpload($request, 'image', 'uploads/privatecar') ?? '';
                $data->name           = $request->name;
                $data->email          = $request->email;
                $data->cartype_id     = implode(",", $request->cartype_id);
                $data->phone          = $request->phone;
                $data->city_id        = $request->city_id;
                $data->address        = $request->address;
                $data->map_link       = $request->map_link;
                $data->car_license    = $request->car_license;
                $data->driver_license = $request->driver_license;
                $data->driver_nid     = $request->driver_nid;
                $data->driver_address = $request->driver_address;
                $data->number_of_seat = $request->number_of_seat;
                $data->description    = $request->description;

                $data->save();
                return response()->json("Privatecar added successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function edit($id)
    {
        $data = Privatecar::find($id);
        return view("admin.privatecar.edit", compact('data'));
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name"           => "required",
                "email"          => "required|email",
                "phone"          => "required|min:11|max:15",
                "city_id"        => "required",
                "cartype_id"     => "required",
                "address"        => "required",
                "car_license"    => "required",
                "driver_license" => "required",
                "driver_nid"     => "required",
                "driver_address" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Privatecar::find($request->id);
                $old = $data->image;
                if ($request->hasFile('image')) {
                    if (File::exists($old)) {
                        File::delete($old);
                    }
                    $data->image = $this->imageUpload($request, 'image', 'uploads/privatecar') ?? '';
                }
                $data->name           = $request->name;
                $data->email          = $request->email;
                $data->cartype_id     = implode(",", $request->cartype_id);
                $data->phone          = $request->phone;
                $data->city_id        = $request->city_id;
                $data->address        = $request->address;
                $data->map_link       = $request->map_link;
                $data->car_license    = $request->car_license;
                $data->driver_license = $request->driver_license;
                $data->driver_nid     = $request->driver_nid;
                $data->driver_address = $request->driver_address;
                $data->number_of_seat = $request->number_of_seat;
                $data->description    = $request->description;

                $data->update();
                return response()->json("Privatecar updated successfully");
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
        if (!in_array("privatecar.destroy", $access)) {
            return view("admin.unauthorize");
        }

        try {
            $data = Privatecar::find($request->id);
            $old  = $data->image;
            if (File::exists($old)) {
                File::delete($old);
            }
            $data->delete();
            return response()->json("Privatecar Deleted successfully");
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }
}
