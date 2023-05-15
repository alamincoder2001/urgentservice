<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CartypeController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UpazilaController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\AmbulanceController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DiagnosticController;
use App\Http\Controllers\Admin\PrivatecarController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\InvestigationController;
use App\Http\Controllers\Admin\NotificationController;

//admin authentication
Route::group(['prefix' => 'admin'], function () {
    Route::get("/", [LoginController::class, 'showAdminLoginForm']);
    Route::post("/login", [LoginController::class, "adminLogin"])->name("admin.login");
    Route::get("/dashboard", [AdminController::class, "index"])->name("admin.dashboard");

    // Admin profile route
    Route::get('/profile', [AdminController::class, "profile"])->name("admin.profile");
    Route::get('/get-profile', [AdminController::class, "getProfile"])->name("getadmin.profile");
    Route::post('/save-profile', [AdminController::class, "saveProfile"])->name("saveadmin.profile");
    // Admin Password route
    Route::get("/password", [AdminController::class, "password"])->name("admin.password");
    Route::post("/password", [AdminController::class, "passwordChange"])->name("changeadmin.password");
    // Setting route
    Route::get("/setting", [SettingController::class, "index"])->name('setting.index');
    Route::get("/setting-data", [SettingController::class, "getData"])->name('setting.get');
    Route::post("/setting", [SettingController::class, "store"])->name('setting.store');
    // Doctor route
    Route::get("/doctor", [DoctorController::class, 'index'])->name("admin.doctor.index");
    Route::get("/doctor-create/{id?}", [DoctorController::class, 'create'])->name("admin.doctor.create");
    Route::post("/doctor", [DoctorController::class, 'store'])->name("admin.doctor.store");
    Route::get("/doctor-fetch/{id}", [DoctorController::class, 'fetch'])->name("admin.doctor.fetch");
    Route::post("/doctor-update", [DoctorController::class, 'update'])->name("admin.doctor.update");
    Route::post("/doctor-delete", [DoctorController::class, 'destroy'])->name("admin.doctor.destroy");
    // chamber remove
    Route::get("/doctor/chamber-delete/{id}", [DoctorController::class, 'Chamber_Destroy']);
    // hospital route
    Route::get("/hospital", [HospitalController::class, 'index'])->name("admin.hospital.index");
    Route::get("/hospital-get", [HospitalController::class, "getHospital"])->name("admin.hospital.get");
    Route::get("/hospital-create", [HospitalController::class, 'create'])->name("admin.hospital.create");
    Route::get("/hospital-create", [HospitalController::class, 'create'])->name("admin.hospital.create");
    Route::post("/hospital", [HospitalController::class, 'store'])->name("admin.hospital.store");
    Route::get("/hospital-edit/{id}", [HospitalController::class, 'edit'])->name("admin.hospital.edit");
    Route::post("/hospital-update", [HospitalController::class, 'update'])->name("admin.hospital.update");
    Route::post("/hospital-delete", [HospitalController::class, 'destroy'])->name("admin.hospital.destroy");
    // diagnostic route
    Route::get("/diagnostic", [DiagnosticController::class, 'index'])->name("admin.diagnostic.index");
    Route::get("/diagnostic-get", [DiagnosticController::class, "getDiagnostic"])->name("admin.diagnostic.get");
    Route::get("/diagnostic-create", [DiagnosticController::class, 'create'])->name("admin.diagnostic.create");
    Route::post("/diagnostic", [DiagnosticController::class, 'store'])->name("admin.diagnostic.store");
    Route::get("/diagnostic-edit/{id}", [DiagnosticController::class, 'edit'])->name("admin.diagnostic.edit");
    Route::post("/diagnostic-update", [DiagnosticController::class, 'update'])->name("admin.diagnostic.update");
    Route::post("/diagnostic-delete", [DiagnosticController::class, 'destroy'])->name("admin.diagnostic.destroy");
    // ambulance route
    Route::get("/ambulance", [AmbulanceController::class, 'index'])->name("admin.ambulance.index");
    Route::get("/ambulance-create", [AmbulanceController::class, 'create'])->name("admin.ambulance.create");
    Route::post("/ambulance", [AmbulanceController::class, 'store'])->name("admin.ambulance.store");
    Route::get("/ambulance-edit/{id}", [AmbulanceController::class, 'edit'])->name("admin.ambulance.edit");
    Route::post("/ambulance-update", [AmbulanceController::class, 'update'])->name("admin.ambulance.update");
    Route::post("/ambulance-delete", [AmbulanceController::class, 'destroy'])->name("admin.ambulance.destroy");
    // cartype route
    Route::get("/cartype", [CartypeController::class, "index"])->name("cartype.index");
    Route::get("/cartype/fetch", [CartypeController::class, "fetch"])->name("cartype.fetch");
    Route::get("/cartype/{id}/edit", [CartypeController::class, "edit"])->name("cartype.edit");
    Route::post("/cartype", [CartypeController::class, "store"])->name("cartype.store");
    Route::post("/cartype/delete", [CartypeController::class, "destroy"])->name("cartype.destroy");
    // ambulance route
    Route::get("/privatecar", [PrivatecarController::class, 'index'])->name("admin.privatecar.index");
    Route::get("/privatecar-create", [PrivatecarController::class, 'create'])->name("admin.privatecar.create");
    Route::post("/privatecar", [PrivatecarController::class, 'store'])->name("admin.privatecar.store");
    Route::get("/privatecar-edit/{id}", [PrivatecarController::class, 'edit'])->name("admin.privatecar.edit");
    Route::post("/privatecar-update", [PrivatecarController::class, 'update'])->name("admin.privatecar.update");
    Route::post("/privatecar-delete", [PrivatecarController::class, 'destroy'])->name("admin.privatecar.destroy");
    //contact route
    Route::get("/contact", [ContactController::class, "index"])->name("admin.contact.index");
    Route::post("/contact", [ContactController::class, "store"])->name("admin.contact.store");
    // department route
    Route::get("/department", [DepartmentController::class, 'index'])->name("department.index");
    Route::get("/department-get", [DepartmentController::class, "getData"])->name("department.get");
    Route::post("/department", [DepartmentController::class, "store"])->name("department.store");
    Route::post("/department-edit", [DepartmentController::class, "edit"])->name("department.edit");
    Route::post("/department-update", [DepartmentController::class, "update"])->name("department.update");
    Route::post("/department-delete", [DepartmentController::class, "destroy"])->name("department.destroy");
    // slider route
    Route::resource("/slider", SliderController::class)->except(["show", "update", "destroy"]);
    Route::post("slider/update", [SliderController::class, "update"])->name("slider.update");
    Route::post("slider/delete", [SliderController::class, "destroy"])->name("slider.destroy");
    // partner route
    Route::get("/partner", [PartnerController::class, "index"])->name("partner.index");
    Route::get("/partner/fetch", [PartnerController::class, "fetch"])->name("partner.fetch");
    Route::get("/partner/{id}/edit", [PartnerController::class, "edit"])->name("partner.edit");
    Route::post("/partner", [PartnerController::class, "store"])->name("partner.store");
    Route::post("/partner/delete", [PartnerController::class, "destroy"])->name("partner.destroy");
    // test route
    Route::get("/test", [TestController::class, "index"])->name("test.index");
    Route::get("/test/fetch", [TestController::class, "fetch"])->name("test.fetch");
    Route::post("/test/store", [TestController::class, "store"])->name("test.store");
    Route::get("/test/edit/{id}", [TestController::class, "edit"])->name("test.edit");
    Route::post("/test/delete", [TestController::class, "destroy"])->name("test.destroy");
    // add investigation
    Route::get("/investigation", [InvestigationController::class, "index"])->name("investigation.index");
    Route::get("/fetch-investigation", [InvestigationController::class, "fetchInvestigation"]);
    Route::post("/investigation", [InvestigationController::class, "investigation"]);
    Route::get("/investigation-delete/{id}", [InvestigationController::class, "destroy"]);
    Route::get("/investigation-show/{id}", [InvestigationController::class, "show"]);
    // blood donar add
    Route::get("/blood-donor/show", [AdminController::class, "blooddonor"])->name("admin.blood.donor");
    Route::post("/blood-donor/delete", [AdminController::class, "donordestroy"])->name("admin.donor.destroy");
    //prescription
    Route::get("/prescription", [AdminController::class, "showprescription"])->name("admin.prescription.index");
    Route::post("/delete-prescription", [AdminController::class, "deletePrescription"])->name("admin.prescription.destroy");

    // city add
    Route::get("/city", [CityController::class, 'index'])->name("city.index");
    Route::get("/city-get", [CityController::class, 'fetch'])->name("city.get");
    Route::post("/city", [CityController::class, 'store'])->name("city.store");
    Route::get("/city-edit/{id}", [CityController::class, 'edit'])->name("city.edit");
    Route::get("/city-delete/{id}", [CityController::class, 'destroy'])->name("city.destroy");
    // city add
    Route::get("/upazila", [UpazilaController::class, 'index'])->name("upazila.index");
    Route::get("/upazila-get", [UpazilaController::class, 'fetch'])->name("upazila.get");
    Route::post("/upazila", [UpazilaController::class, 'store'])->name("upazila.store");
    Route::get("/upazila-edit/{id}", [UpazilaController::class, 'edit'])->name("upazila.edit");
    Route::get("/upazila-delete/{id}", [UpazilaController::class, 'destroy'])->name("upazila.destroy");

    //user permission
    Route::get('/user', [UserAccessController::class, 'create'])->name('admin.user.create');
    Route::get('/user-fetch', [UserAccessController::class, 'fetch'])->name('admin.user.fetch');
    Route::get('/user/edit/{id}', [UserAccessController::class, 'edit'])->name('admin.user.edit');
    Route::post('/user/store', [UserAccessController::class, 'store'])->name('admin.user.store');
    Route::post('/user/delete', [UserAccessController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('/user/permission/{id}', [UserAccessController::class, 'permission_edit'])->name('user.permission');
    Route::post('/store-permission', [UserAccessController::class, 'store_permission'])->name('store.permission');

    // notification
    Route::get("/patient-notification", [NotificationController::class, 'patient'])->name("admin.patient.notification");
    Route::get("/ambulance-notification", [NotificationController::class, 'hireAmbulance'])->name("admin.ambulance.notification");
    Route::get("/privatecar-notification", [NotificationController::class, 'hirePrivatecar'])->name("admin.privatecar.notification");
});
