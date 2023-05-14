<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Diagnostic\DoctorController;
use App\Http\Controllers\HospitalDiagnosticController;
use App\Http\Controllers\Diagnostic\DiagnosticController;
use App\Http\Controllers\Diagnostic\AppointmentController;

//diagnostic authentication
Route::group(['prefix' => 'diagnostic'], function () {
    Route::get("/", [LoginController::class, 'showDiagnosticLoginForm']);
    Route::post("/login", [LoginController::class, "diagnosticLogin"])->name("diagnostic.login");
    Route::get("/dashboard", [DiagnosticController::class, "index"])->name("diagnostic.dashboard");
    Route::get("/profile", [DiagnosticController::class, "profile"])->name("diagnostic.profile");
    Route::post("/profile-update", [DiagnosticController::class, "update"])->name("diagnostic.profile.update");
    Route::get("/password", [DiagnosticController::class, "password"])->name("diagnostic.password");
    Route::post("/password-update", [DiagnosticController::class, "updatePassword"])->name("diagnostic.password.update");
    Route::post("/image-update", [DiagnosticController::class, "updateImage"])->name("diagnostic.image.update");

    // diagnostic doctor route
    Route::get("/doctor", [DoctorController::class, 'index'])->name("diagnostic.doctor.index");
    Route::get("/doctor-create/{id?}", [DoctorController::class, 'create'])->name("diagnostic.doctor.create");
    Route::post("/doctor", [DoctorController::class, 'store'])->name("diagnostic.doctor.store");
    Route::get("/doctor-fetch/{id}", [DoctorController::class, 'fetch'])->name("diagnostic.doctor.fetch");
    Route::post("/doctor-update", [DoctorController::class, 'update'])->name("diagnostic.doctor.update");
    Route::post("/doctor-delete", [DoctorController::class, 'destroy'])->name("diagnostic.doctor.destroy");
    // diagnostic patient list
    Route::get("/patient/list", [AppointmentController::class, "index"])->name("diagnostic.appointment");
    Route::get("/patient/today", [AppointmentController::class, "todayPatient"])->name("diagnostic.appointment.today");
    Route::get("/diagnostic-patient-show/{id}", [AppointmentController::class, "patient"])->name("diagnostic.patient.show");
    Route::post("/diagnostic/comment/store", [AppointmentController::class, "comment"])->name("diagnostic.comment.store");
    // dignostic comment
    Route::post("/diagnostic/clients/comment", [HospitalDiagnosticController::class, "diagnosticcomment"])->name("diagnostic.client.comment");

    Route::get("/city-get", [DiagnosticController::class, 'fetch']);
    Route::get("/department-get", [DiagnosticController::class, "getDepartment"]);
});