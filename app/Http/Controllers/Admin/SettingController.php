<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view("admin.setting.index");
    }

    public function getData()
    {
        $setting = Setting::first();
        return response()->json($setting);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required"
            ]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $setting = Setting::first();
                $old = $setting->favicon;
                $old1 = $setting->logo;
                if ($request->logo !== null || $request->favicon) {
                    if (!empty($request->favicon)) {
                        if (File::exists($old)) {
                            File::delete($old);
                        }
                        $image = $_FILES['favicon']['name'];
                        $temp = $_FILES['favicon']['tmp_name'];
                        $ex = explode(".", $image);
                        $e = end($ex);
    
    
    
                        $filename = rand(1000000, 9999999) . "." . $e;
                        move_uploaded_file($temp, public_path('backend/images/favicon/' . $filename));
                        $img_url = "backend/images/favicon/" . $filename;
                        $setting->favicon = $img_url;
                    }
                    if (!empty($request->logo)) {
                        if (File::exists($old1)) {
                            File::delete($old1);
                        }
                        $image1 = $_FILES['logo']['name'];
                        $temp1 = $_FILES['logo']['tmp_name'];
                        $ex1 = explode(".", $image1);
                        $e1 = end($ex1);
                        $filename1 = rand(1000000, 9999999) . "." . $e1;
                        move_uploaded_file($temp1, public_path('backend/images/logo/' . $filename1));
                        $img_url1 = "backend/images/logo/" . $filename1;
                        $setting->logo = $img_url1;
                    }

                    if(empty($request->favicon)){
                        $setting->favicon = $old;
                    }
                    if(empty($request->logo)){
                        $setting->logo = $old1;
                    }
                    $setting->name             = $request->name;
                    $setting->appointment_text = $request->appointment_text;
                    $setting->update();
                    return response()->json("Setting Updated successfully");
                } else {
                    $setting->name             = $request->name;
                    $setting->appointment_text = $request->appointment_text;
                    $setting->favicon          = $old;
                    $setting->logo             = $old1;
                    $setting->update();
                    return response()->json("Setting Updated successfully");
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }
}
