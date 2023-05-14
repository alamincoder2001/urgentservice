<?php

use App\Http\Controllers\Ambulance\AmbulanceController;
use App\Http\Controllers\Ambulance\HireAmbulanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

//ambulance authentication
Route::group(['prefix' => 'ambulance'], function () {
    Route::get("/", [LoginController::class, 'showAmbulanceLoginForm']);
    Route::post("/login", [LoginController::class, "ambulanceLogin"])->name("ambulance.login");
    Route::get("/dashboard", [AmbulanceController::class, "index"])->name("ambulance.dashboard");
    Route::get("/profile", [AmbulanceController::class, "profile"])->name("ambulance.profile");
    Route::post("/profile-update", [AmbulanceController::class, "update"])->name("ambulance.profile.update");
    Route::get("/password", [AmbulanceController::class, "password"])->name("ambulance.password");
    Route::post("/password-update", [AmbulanceController::class, "updatePassword"])->name("ambulance.password.update");
    Route::post("/image-update", [AmbulanceController::class, "updateImage"])->name("ambulance.image.update");

    // ambulance hire route
    Route::get("/hire-ambulance", [HireAmbulanceController::class, "index"])->name("ambulance.hire.ambulance");
    Route::post("/comment-on-clints", [HireAmbulanceController::class, "comment"])->name("ambulance.hire.comment");
});
