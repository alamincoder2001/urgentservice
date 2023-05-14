<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Privatecar\PrivatecarController;

//privatecar authentication
Route::group(['prefix' => 'privatecar'], function () {
    Route::get("/", [LoginController::class, 'showPrivatecarLoginForm']);
    Route::post("/login", [LoginController::class, "privatecarLogin"])->name("privatecar.login");
    Route::get("/dashboard", [PrivatecarController::class, "index"])->name("privatecar.dashboard");
    Route::get("/profile", [PrivatecarController::class, "profile"])->name("privatecar.profile");
    Route::post("/profile-update", [PrivatecarController::class, "update"])->name("privatecar.profile.update");
    Route::get("/password", [PrivatecarController::class, "password"])->name("privatecar.password");
    Route::post("/password-update", [PrivatecarController::class, "updatePassword"])->name("privatecar.password.update");
    Route::post("/image-update", [PrivatecarController::class, "updateImage"])->name("privatecar.image.update");
});
