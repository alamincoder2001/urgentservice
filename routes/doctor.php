<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Doctor\DoctorController;

//doctor authentication
Route::group(['prefix' => 'doctor'], function () {
    Route::get("/", [LoginController::class, 'showDoctorLoginForm']);
    Route::post("/login", [LoginController::class, "doctorLogin"])->name("doctor.login");
    Route::get("/dashboard", [DoctorController::class, "index"])->name("doctor.dashboard");

    //doctor update profile
    Route::get("/doctor-profile", [DoctorController::class, "doctor"])->name("doctor.profile");
    Route::post("/doctor-update", [DoctorController::class, "update"])->name("doctor.doctor.update");
    Route::get("/doctor-password", [DoctorController::class, "password"])->name("doctor.doctor.password");
    Route::post("/doctor-password-update", [DoctorController::class, "passwordUpdate"])->name("doctor.doctor.passwordupdate");
    Route::post("/doctor-image-update", [DoctorController::class, "imageUpdate"])->name("doctor.doctor.imageUpdate");
    // patient appointment
    Route::get("/doctor-appointment-today", [DoctorController::class, "todayAppointment"])->name("today.doctor.appointment");
    Route::get("/doctor-appointment", [DoctorController::class, "doctorAppointment"])->name("doctor.appointment");
    Route::get("/doctor-patient-show/{id}", [DoctorController::class, "doctorPatient"])->name("doctor.patient");
    Route::post("/comment/store", [DoctorController::class, "comment"])->name("comment.store");

    Route::get("/doctor-fetch/{id}", [DoctorController::class, 'fetchDoctor']);

    Route::get("/city-get", [DoctorController::class, 'fetch']);
    Route::get("/department-get", [DoctorController::class, "getDepartment"]);
    Route::get("/hospital-get", [DoctorController::class, "getHospital"]);
    Route::get("/diagnostic-get", [DoctorController::class, "getDiagnostic"]);
});
