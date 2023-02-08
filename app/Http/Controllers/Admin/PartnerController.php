<?php

namespace App\Http\Controllers\Admin;

use App\Models\Partner;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
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
        if (!in_array("partner.index", $access)) {
            return view("admin.unauthorize");
        }

        return view("admin.partner.index");
    }

    public function fetch()
    {
        $data = Partner::latest()->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if ($request->partner_id == null) {
                    $data = new Partner();
                } else {
                    $data = Partner::find($request->partner_id);
                    $old = $data->image;
                }
                $data->name = $request->name;
                if ($request->hasFile("image")) {
                    if (isset($old)) {
                        if (File::exists($old)) {
                            File::delete($old);
                        }
                    }
                    $data->image = $this->imageUpload($request, 'image', 'uploads/partner') ?? '';
                }
                $data->save();
                if ($request->partner_id) {
                    return response()->json("Partner updated successfully");
                } else {
                    return response()->json("Partner added successfully");
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function edit($id)
    {
        $data = Partner::find($id);
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        try {
            $data = Partner::find($request->id);
            $old = $data->image;
            if (File::exists($old)) {
                File::delete($old);
            }
            $data->delete();
            return response()->json("Partner delete successfully");
        } catch (\Throwable $e) {
            return response()->json("something went wrong");
        }
    }
}
