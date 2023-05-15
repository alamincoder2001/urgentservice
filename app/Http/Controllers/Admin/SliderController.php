<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
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
        if (!in_array("slider.index", $access)) {
            return view("admin.unauthorize");
        }

        return view("admin.slider.index");
    }

    public function create()
    {
        $data = Slider::latest()->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "title" => "required",
                "short_text" => "required",
                "image" => ""
            ]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = new Slider();
                $data->image = $this->imageUpload($request, 'image', 'uploads/slider') ?? '';
                $data->title = $request->title;
                $data->short_text = $request->short_text;
                $data->save();
                return response()->json("Slider added successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function edit($id)
    {
        $data = Slider::find($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "title" => "required",
                "short_text" => "required"
            ]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                $data = Slider::find($request->id);
                if ($request->hasFile('image')) {
                    $old = $data->image;
                    if (File::exists($old)) {
                        File::delete($old);
                    }
                    $data->image = $this->imageUpload($request, 'image', 'uploads/slider') ?? '';
                }
                $data->title = $request->title;
                $data->short_text = $request->short_text;
                $data->update();
                return response()->json("Slider updated successfully");
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function destroy(Request $request)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("slider.destroy", $access)) {
            return view("admin.unauthorize");
        }

        try {
            $data = Slider::find($request->id);
            $old = $data->image;
            if (File::exists($old)) {
                File::delete($old);
            }
            $data->delete();
            return response()->json("Slider delete successfully");
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }
}
