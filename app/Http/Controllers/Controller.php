<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Chamber;
use App\Models\Hospital;
use App\Models\Diagnostic;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function imageUpload($request, $image, $directory)
    {
        $doUpload = function ($image) use ($directory) {
            $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extention = $image->getClientOriginalExtension();
            $imageName = $name . '_' . uniqId() . '.' . $extention;
            $image->move($directory, $imageName);
            return $directory . '/' . $imageName;
        };
        if (!empty($image) && $request->hasFile($image)) {
            $file = $request->file($image);
            if (is_array($file) && count($file)) {
                $imagesPath = [];
                foreach ($file as $key => $image) {
                    $imagesPath[] = $doUpload($image);
                }
                return $imagesPath;
            } else {
                return $doUpload($file);
            }
        }

        return false;
    }

    // public function allOrganization($id)
    // {
    //     $doctor = Doctor::find($id);
    //     $data = [];

    //     if ($doctor->hospital_id != null) {
    //         //hospital
    //         $hosp_id = explode(",", $doctor->hospital_id);
    //         foreach ($hosp_id as $key => $h) {
    //             array_push($data, Hospital::where("id", $h)->first());
    //         }
    //     }
    //     if($doctor->diagnostic_id != null){
    //         //diagnostic
    //         $diag_id = explode(",", $doctor->diagnostic_id);
    //         foreach ($diag_id as $key => $d) {
    //             array_push($data, Diagnostic::where("id", $d)->first());
    //         }
    //     }

    //     $chamber = Chamber::where("doctor_id", $id)->get();
    //     if (count($chamber) > 0) {
    //         foreach($chamber as $c){
    //             array_push($data, $c);
    //         }
    //     }

    //     return $data;
    // }
}
