<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $data = Contact::first();
        return view("admin.contact.index", compact('data'));
    }
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
                "phone" => "required",
                "address" => "required",
                "map_link" => "required"
            ]);
            if($validator->fails()){
                return response()->json(["error"=> $validator->errors()]);
            }else{
                $data = Contact::first();
                $old = $data->image;
                if ($request->hasFile('image')) {
                    if (File::exists($old)) {
                        File::delete($old);
                    }
                    $data->image = $this->imageUpload($request, 'image', 'uploads/contact') ?? '';
                }
                $data->email = $request->email;
                $data->phone = implode(",", $request->phone);
                $data->address = $request->address;
                $data->map_link = $request->map_link;
                $data->update();
                return response()->json("Contact Page updated successfully");
            }
        }catch(\Throwable $e){
            return response()->json("Something went wrong");
        }
    }
}
