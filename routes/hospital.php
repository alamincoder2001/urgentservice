<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Hospital\DoctorController;
use App\Http\Controllers\Hospital\HospitalController;
use App\Http\Controllers\HospitalDiagnosticController;
use App\Http\Controllers\Hospital\AppointmentController;

//hospital authentication
Route::group(['prefix' => 'hospital'], function () {
    Route::get("/", [LoginController::class, 'showHospitalLoginForm']);
    Route::post("/login", [LoginController::class, "hospitalLogin"])->name("hospital.login");
    Route::get("/dashboard", [HospitalController::class, "index"])->name("hospital.dashboard");
    Route::get("/profile", [HospitalController::class, "profile"])->name("hospital.profile");
    Route::get("/password", [HospitalController::class, "password"])->name("hospital.password");
    Route::post("/password-update", [HospitalController::class, "passwordUpdate"])->name("hospital.password.update");
    Route::post("/image-update", [HospitalController::class, "imageUpdate"])->name("hospital.image.update");
    Route::post("/hospital/update", [HospitalController::class, "update"])->name("hospital.hospital.update");

    // hospital doctor route
    Route::get("/doctor", [DoctorController::class, 'index'])->name("hospital.doctor.index");
    Route::get("/doctor-create/{id?}", [DoctorController::class, 'create'])->name("hospital.doctor.create");
    Route::post("/doctor", [DoctorController::class, 'store'])->name("hospital.doctor.store");
    Route::get("/doctor-fetch/{id}", [DoctorController::class, 'fetch'])->name("hospital.doctor.fetch");
    Route::post("/doctor-update", [DoctorController::class, 'update'])->name("hospital.doctor.update");
    Route::post("/doctor-delete", [DoctorController::class, 'destroy'])->name("hospital.doctor.destroy");
    // hospital appointment
    Route::get("/hospital-patient-appointment", [AppointmentController::class, "index"])->name("hospital.appointment.index");
    Route::get("/hospital-patient-today-appointment", [AppointmentController::class, "todayAppointment"])->name("hospital.appointment.today");
    Route::get("/hospital-patient-show/{id}", [AppointmentController::class, "patient"])->name("hospital.patient.show");
    Route::post("/hospital/comment/store", [AppointmentController::class, "comment"])->name("hospital.comment.store");
    // dignostic comment
    Route::post("/hospital/clients/comment", [HospitalDiagnosticController::class, "hospitalcomment"])->name("hospital.client.comment");

    Route::get("/city-get", [HospitalController::class, 'fetch']);
    Route::get("/department-get", [HospitalController::class, "getDepartment"]);
});
