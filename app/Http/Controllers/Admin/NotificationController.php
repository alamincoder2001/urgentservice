<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactAmbulance;
use App\Models\ContactPrivatecar;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // doctor patient appointment
    public function patient()
    {
        $patients = Appointment::with('hospital', 'diagnostic')->latest('id')->get();
        return view("admin.notification.patient", compact("patients"));
    }

    public function hireAmbulance()
    {
        $contactambulances = ContactAmbulance::with('ambulance')->latest('id')->get();
        return view("admin.notification.hireambulance", compact("contactambulances"));
    }

    public function hirePrivatecar()
    {
        $contactprivatecars = ContactPrivatecar::with('privatecar', 'cartype')->latest('id')->get();
        return view("admin.notification.hireprivatecar", compact("contactprivatecars"));
    }
}
