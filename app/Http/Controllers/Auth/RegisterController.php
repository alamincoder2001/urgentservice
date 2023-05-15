<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // user login section
    public function showregister()
    {
        if (!Auth::guard("web")->check()) {
            return view("auth.register");
        } else {
            return back();
        }
    }
    public function showlogin()
    {
        if (!Auth::guard("web")->check()) {
            return view("auth.login");
        } else {
            return back();
        }
    }

    public function userlogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required',
            'password' => 'required'
        ], ["email.required" => "Username is required"]);

        try {
            if (Auth::guard('web')->attempt(["email" => $request->email, "password" => $request->password])) {
                return redirect("/user-profile");
            } else {
                return back()->with(["errors" => "Password or Email Not Match"]);
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong", $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:1', 'confirmed'],
        ]);

        $data =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($data) {
            if (Auth::guard("web")->attempt(["email" => $request->email, "password" => $request->password])) {
                return redirect("/user-profile");
            }
        }
    }

    public function userupdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.Auth::guard('web')->user()->id,
        ]);

        try {
            $data            = User::find(Auth::guard('web')->user()->id);
            $data->name      = $request->name;
            $data->email     = $request->email;
            $data->phone     = $request->phone;
            $data->city_name = $request->city_name;
            $data->address   = $request->address;
            $data->update();
            return response()->json("Profile updated successfully");
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    public function userlogout()
    {
        if (Auth::guard("web")->check()) {
            Auth::guard("web")->logout();
            return redirect("/");
        }
    }
}
