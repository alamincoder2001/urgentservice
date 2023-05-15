<?php

namespace App\Http\Controllers\Privatecar;

use App\Models\Privatecar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PrivatecarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:privatecar');
    }

    public function index()
    {
        return view("privatecar.dashboard");
    }

    public function profile()
    {
        return view("privatecar.profile");
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name"            => "required",
                "username"        => "required|unique:privatecars,username," . $request->id,
                "email"           => "required|email",
                "phone"           => "required",
                "city_id"         => "required",
                "upazila_id"      => "required",
                "privatecar_type" => "required",
                "address"         => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data                  = Privatecar::find($request->id);
                $data->name            = $request->name;
                $data->username        = $request->username;
                $data->email           = $request->email;
                $data->privatecar_type = implode(",", $request->privatecar_type);
                $data->phone           = implode(",", $request->phone);
                $data->city_id         = $request->city_id;
                $data->upazila_id      = $request->upazila_id;
                $data->address         = $request->address;
                $data->description     = $request->description;
                $data->map_link        = $request->map_link;

                $data->update();
                return response()->json("Privatecar updated successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function password()
    {
        return view("privatecar.password");
    }

    public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "password"         => "required",
                "new_password"     => "required|same:confirm_password",
                "confirm_password" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Auth::guard("privatecar")->user();
                $hasPass = $data->password;
                if (Hash::check($request->password, $hasPass)) {
                    $data->password = Hash::make($request->new_password);
                    $data->update();
                    return response()->json("Password updated successfully");
                } else {
                    return response()->json(["errors" => "Current Password Not Match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }

    public function updateImage(Request $request)
    {
        try {
            $data = Auth::guard("privatecar")->user();
            $old = $data->image;
            if ($request->hasFile('image')) {
                if (File::exists($old)) {
                    File::delete($old);
                }
                $data->image = $this->imageUpload($request, 'image', 'uploads/privatecar') ?? '';
                $data->update();
                return response()->json("Privatecar image updated");
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }
}
