<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/user-profile";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:doctor')->except('logout');
        $this->middleware('guest:hospital')->except('logout');
        $this->middleware('guest:diagnostic')->except('logout');
        $this->middleware('guest:ambulance')->except('logout');
        $this->middleware('guest:privatecar')->except('logout');
    }

    //Admin Login method section

    public function showAdminLoginForm()
    {
        return view('auth.admin');
    }
    public function adminLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'   => 'required',
                'password' => 'required'
            ], ["email.required" => "Username is required"]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if (Auth::guard('admin')->attempt($this->credential($request->email, $request->password))) {
                    return response()->json("Successfully Login");
                } else {
                    return response()->json(["errors" => "Password or Email Not Match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }
    // end admin login

    // doctor Login
    public function showDoctorLoginForm()
    {
        return view('auth.doctor');
    }
    public function doctorLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'   => 'required',
                'password' => 'required'
            ], ["email.required" => "Username is required"]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if (Auth::guard('doctor')->attempt($this->credential($request->email, $request->password))) {
                    return response()->json("Successfully Login");
                } else {
                    return response()->json(["errors" => "Password or Email Not Match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }
    // end doctor login

    // hospital login
    public function showHospitalLoginForm()
    {
        return view('auth.hospital');
    }
    public function hospitalLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'   => 'required',
                'password' => 'required'
            ], ["email.required" => "Username is required"]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if (Auth::guard('hospital')->attempt($this->credential($request->email, $request->password))) {
                    return response()->json("Successfully Login");
                } else {
                    return response()->json(["errors" => "Password or Email Not Match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }
    // end hopital login

    // diagnostic login
    public function showDiagnosticLoginForm()
    {
        return view('auth.diagnostic');
    }

    public function diagnosticLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'   => 'required',
                'password' => 'required'
            ], ["email.required" => "Username is required"]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if (Auth::guard('diagnostic')->attempt($this->credential($request->email, $request->password))) {
                    return response()->json("Successfully Login");
                } else {
                    return response()->json(["errors" => "Password or Email Not Match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }
    // end diagnostic login

    // ambulance login
    public function showAmbulanceLoginForm()
    {
        return view('auth.ambulance');
    }
    public function ambulanceLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'   => 'required',
                'password' => 'required'
            ], ["email.required" => "Username is required"]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if (Auth::guard('ambulance')->attempt($this->credential($request->email, $request->password))) {
                    return response()->json("Successfully Login");
                } else {
                    return response()->json(["errors" => "Password or Email Not Match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong");
        }
    }

    // privatecar login
    public function showPrivatecarLoginForm()
    {
        return view('auth.privatecar');
    }
    public function privatecarLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'   => 'required',
                'password' => 'required'
            ], ["email.required" => "Username is required"]);

            if ($validator->fails()) {
                return response()->json(["error" => $validator->errors()]);
            } else {
                if (Auth::guard('privatecar')->attempt($this->credential($request->email, $request->password))) {
                    return response()->json("Successfully Login");
                } else {
                    return response()->json(["errors" => "Password or Email Not Match"]);
                }
            }
        } catch (\Throwable $e) {
            return response()->json("Something went wrong".$e->getMessage());
        }
    }

    public function credential($name, $pass)
    {
        if (is_numeric($name)) {
            return ['phone' => $name, 'password' => $pass];
        }
        return ['username' => $name, 'password' => $pass];
    }
}
