<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAccessController extends Controller
{
    public function create()
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("user.index", $access)) {
            return view("admin.unauthorize");
        }

        return view("admin.user.create");
    }

    public function fetch()
    {
        $data = Admin::where("id", "!=", 1)->latest()->get();
        return response()->json(["data" => $data]);
    }

    public function edit($id)
    {
        return Admin::find($id);
    }

    public function store(Request $request)
    {
        try {
            if (empty($request->user_id)) {
                $validator = Validator::make($request->all(), [
                    "name"  => "required",
                    "username"  => "required|unique:admins",
                    "email" => "required",
                    "password" => "required"
                ]);
                $data = new Admin();
            } else {
                $validator = Validator::make($request->all(), [
                    "username"  => "required|unique:admins,username," . $request->user_id,
                    "email" => "required|unique:admins,email," . $request->user_id
                ]);
                $data = Admin::find($request->user_id);
            }
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->role = $request->role;
            if (!empty($request->password)) {
                $data->password = Hash::make($request->password);
            }
            $data->save();
            if (empty($request->user_id)) {
                return "User created successfull";
            } else {
                return "User updated successfull";
            }
        } catch (\Throwable $e) {
            return "Opps! something went wrong";
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user_id = Admin::find($request->id);
            $old = $user_id->image;
            if (File::exists($old)) {
                File::delete($old);
            }
            $user_id->delete();
            return "User Delete successfully";
        } catch (\Throwable $e) {
            return "Opps! something went wrong";
        }
    }


    // permission
    public function permission_edit($id)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("user.index", $access)) {
            return view("admin.unauthorize");
        }

        $user = Admin::find($id);
        $userAccess = UserAccess::where('user_id', $id)->pluck('permissions')->toArray();
        $group_name = Permission::pluck('group_name')->unique();
        $permissions = Permission::all();
        return view('admin.user.permission', compact('user', 'userAccess', 'group_name', 'permissions'));
    }

    public function store_permission(Request $request)
    {
        $access = UserAccess::where('user_id', Auth::guard('admin')->user()->id)
            ->pluck('permissions')
            ->toArray();
        if (!in_array("user.index", $access)) {
            return view("admin.unauthorize");
        }

        try {
            UserAccess::where('user_id', $request->user_id)->delete();
            $permissions = Permission::all();

            foreach ($permissions as $value) {
                if (in_array($value->id, $request->permissions)) {
                    UserAccess::create([
                        'user_id'     => $request->user_id,
                        'group_name'  => $value->group_name,
                        'permissions' => $value->permissions,
                    ]);
                }
            }
            return redirect()->route('admin.user.create')->with('success', 'Permissions added successfullly');
        } catch (\Throwable $e) {
            return redirect()->route('admin.user.create');
        }
    }
}
