<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\AppoinmentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HireAmbulanceController;
use App\Http\Controllers\CompanyContactController;

Auth::routes(['login' => false]);
// Normal User login
Route::get("/login", [RegisterController::class, "showlogin"])->name("showlogin")->middleware("user");
Route::get("/register", [RegisterController::class, "showregister"])->name("showregister")->middleware("user");
Route::post("/register", [RegisterController::class, "create"])->name("register");
Route::post("/userlogin", [RegisterController::class, "userlogin"])->name("user.login");
Route::post("/user-update", [RegisterController::class, "userupdate"])->name("user.update");
Route::delete("/logout", [RegisterController::class, "userlogout"])->name("logout.user");
Route::get("/user-profile", function () {
    return view("userprofile");
})->name("userprofile")->middleware("auth");

// Filter route
Route::post("/city", [FilterController::class, "cityappointment"])->name("filter.cityappoinment");
Route::post("/filter-hospital", [FilterController::class, "hospital"])->name("filter.hospital");
Route::post("/filter-hospitaldiagnosticdoctor", [FilterController::class, "hospitaldiagnosticdoctor"])->name("filter.hospitaldiagnosticdoctor");
Route::post("/filter-doctor", [FilterController::class, "doctor"])->name("filter.doctor");
Route::post("/filter-doctorsinglechange", [FilterController::class, "doctorsinglechange"])->name("filter.doctorsinglechange");
Route::post("/filter-diagnostic", [FilterController::class, "diagnostic"])->name("filter.diagnostic");
Route::post("/filter-ambulance", [FilterController::class, "ambulance"])->name("filter.ambulance");
Route::post("/filter-privatecar", [FilterController::class, "privatecar"])->name("filter.privatecar");
Route::get("/get/city/all", [FilterController::class, "cityall"])->name("get.city.all");
Route::post("/home-filter", [HomeController::class, "filter"])->name("home.filter");
Route::get("/getupazila/{id}", [HomeController::class, "getupazila"]);
Route::post("/donor-filter", [FilterController::class, "filterdonor"])->name("filter.donor");

// =========== Frontend route ========= //
Route::get("/", [HomeController::class, "index"])->name("website");
Route::get("/doctor-details/{department?}", [HomeController::class, "doctor"])->name("doctor.details");
Route::get("/hospital-details/{city?}", [HomeController::class, "hospital"])->name("hospital.details");
Route::get("/diagnostic-details/{city?}", [HomeController::class, "diagnostic"])->name("diagnostic.details");
Route::get("/ambulance-details/{type?}", [HomeController::class, "ambulance"])->name("ambulance.details");
Route::get("/privatecar-details/{type?}", [HomeController::class, "privatecar"])->name("privatecar.details");
Route::get("/single-details-doctor/{id}", [HomeController::class, "singledoctor"])->name("singlepagedoctor");
Route::get("/single-details-hospital/{id}", [HomeController::class, "singlehospital"])->name("singlepagehospital");
Route::get("/single-details-diagnostic/{id}", [HomeController::class, "singlediagnostic"])->name("singlepagediagnostic");
Route::get("/single-details-ambulance/{id}", [HomeController::class, "singleambulance"])->name("singlepageambulance");
Route::get("/single-details-privatecar/{id}", [HomeController::class, "singleprivatecar"])->name("singlepageprivatecar");
Route::get("/pathology", [HomeController::class, "pathology"])->name("pathology");
Route::post("/send-prescription", [HomeController::class, "prescription"]);
Route::get("/donor-list/{any?}", [DonorController::class, "index"])->name("donor");
Route::post("/donor-store", [DonorController::class, "store"])->name("donor.store");

// Appointment route
Route::post("/appointment", [AppoinmentController::class, "appointment"])->name("appointment");
Route::get("/doctorwise-organization/{id}", [AppoinmentController::class, "organization"])->name("organization");
Route::post("/get-patient-details", [AppoinmentController::class, "getDetails"])->name("get.patient.details");
// Hire Ambulance
Route::post("/hire-ambulance", [HireAmbulanceController::class, "store"])->name("hire.ambulance");
// Hire Ambulance
Route::post("/hire-privatecar", [HireAmbulanceController::class, "privatecar"])->name("hire.privatecar");
// company contact route
Route::get("/admin/companycontact", [CompanyContactController::class, "index"])->name("admin.contactcompany.index");
Route::post("/companycontact/store", [CompanyContactController::class, "store"])->name("companycontact");
Route::get("admin/delete_companycontact/{id}", [CompanyContactController::class, "destroy"]);
// hospital && diagnostic contact send route
Route::post("/hospitaldiagnosticcontact/contact", [CompanyContactController::class, "hospitaldiagnosticcontact"])->name("hospitaldiagnosticcontact");
// hospital contact index route
Route::get("/hospital/contactpage", [CompanyContactController::class, "hospitalcontact"])->name("hospital.contact.index");
// diagnostic contact index route
Route::get("/diagnostic/contactpage", [CompanyContactController::class, "diagnosticcontact"])->name("diagnostic.contact.index");
