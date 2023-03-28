<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\AppoinmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CartypeController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HireAmbulanceController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\CompanyContactController;
use App\Http\Controllers\Admin\AmbulanceController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DiagnosticController;
use App\Http\Controllers\Admin\PrivatecarController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\HospitalDiagnosticController;
use App\Http\Controllers\Admin\InvestigationController;
use App\Http\Controllers\Admin\UpazilaController;
use App\Http\Controllers\Hospital\AppointmentController;
use App\Http\Controllers\Doctor\DoctorController as DoctorDoctorController;
use App\Http\Controllers\Hospital\DoctorController as HospitalDoctorController;
use App\Http\Controllers\Diagnostic\DoctorController as DiagnosticDoctorController;
use App\Http\Controllers\Hospital\HospitalController as HospitalHospitalController;
use App\Http\Controllers\Ambulance\AmbulanceController as AmbulanceAmbulanceController;
use App\Http\Controllers\Diagnostic\DiagnosticController as DiagnosticDiagnosticController;
use App\Http\Controllers\Diagnostic\AppointmentController as DiagnosticAppointmentController;
use App\Http\Controllers\Ambulance\HireAmbulanceController as AmbulanceHireAmbulanceController;
use App\Http\Controllers\Privatecar\PrivatecarController as PrivatecarPrivatecarController;

Auth::routes(['login' => false]);
// Normal User login
Route::get("/login", [RegisterController::class, "showlogin"])->name("showlogin")->middleware("user");
Route::get("/register", [RegisterController::class, "showregister"])->name("showregister")->middleware("user");
Route::post("/register", [RegisterController::class, "create"])->name("register");
Route::post("/userlogin", [RegisterController::class, "userlogin"])->name("user.login");
Route::post("/user-update", [RegisterController::class, "userupdate"])->name("user.update");
Route::delete("/logout", [RegisterController::class, "userlogout"])->name("logout.user");

// Filter route
Route::post("/filtersingleservice", [FilterController::class, "filtersingleservice"])->name("filtersingleservice"); 
Route::post("/city", [FilterController::class, "cityappointment"])->name("filter.cityappoinment");
Route::post("/filter-city", [FilterController::class, "City"])->name("filter.city");
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
Route::get("/doctor-details/{id?}", [HomeController::class, "doctor"])->name("doctor.details");
Route::get("/hospital-details", [HomeController::class, "hospital"])->name("hospital.details");
Route::get("/diagnostic-details", [HomeController::class, "diagnostic"])->name("diagnostic.details");
Route::get("/ambulance-details", [HomeController::class, "ambulance"])->name("ambulance.details");
Route::get("/privatecar-details/{id?}", [HomeController::class, "privatecar"])->name("privatecar.details");
Route::get("/single-details-doctor/{id}", [HomeController::class, "singledoctor"])->name("singlepagedoctor");
Route::get("/single-details-hospital/{id}", [HomeController::class, "singlehospital"])->name("singlepagehospital");
Route::get("/single-details-diagnostic/{id}", [HomeController::class, "singlediagnostic"])->name("singlepagediagnostic");
Route::get("/single-details-ambulance/{id}", [HomeController::class, "singleambulance"])->name("singlepageambulance");
Route::get("/single-details-privatecar/{id}", [HomeController::class, "singleprivatecar"])->name("singlepageprivatecar");
Route::get("/pathology", [HomeController::class, "pathology"])->name("pathology");
Route::post("/send-prescription", [HomeController::class, "prescription"]);
Route::get("/donor-list/{any?}", [DonorController::class, "index"])->name("donor");
Route::post("/donor-store", [DonorController::class, "store"])->name("donor.store");

// about us route
Route::get("/about-us", function () {
    return view("aboutus");
})->name("aboutus");
Route::get("/user-profile", function () {
    return view("userprofile");
})->name("userprofile")->middleware("auth");
// about us route
Route::get("/contact-us", function () {
    return view("contactus");
})->name("contactus");

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

//====== Backend Route section ======= 

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
    Route::get("/doctor-create", [DoctorController::class, 'create'])->name("admin.doctor.create");
    Route::post("/doctor", [DoctorController::class, 'store'])->name("admin.doctor.store");
    Route::get("/doctor-edit/{id}", [DoctorController::class, 'edit'])->name("admin.doctor.edit");
    Route::post("/doctor-update", [DoctorController::class, 'update'])->name("admin.doctor.update");
    Route::post("/doctor-delete", [DoctorController::class, 'destroy'])->name("admin.doctor.destroy");
    Route::get("/doctor/appointment/{id}", [DoctorController::class, 'appointment'])->name("admin.doctor.appointment");
    // chamber remove
    Route::get("/doctor/chamber-delete/{id}", [DoctorController::class, 'Chamber_Destroy']);
    // hospital route
    Route::get("/hospital", [HospitalController::class, 'index'])->name("admin.hospital.index");
    Route::get("/hospital-create", [HospitalController::class, 'create'])->name("admin.hospital.create");
    Route::post("/hospital", [HospitalController::class, 'store'])->name("admin.hospital.store");
    Route::get("/hospital-edit/{id}", [HospitalController::class, 'edit'])->name("admin.hospital.edit");
    Route::post("/hospital-update", [HospitalController::class, 'update'])->name("admin.hospital.update");
    Route::post("/hospital-delete", [HospitalController::class, 'destroy'])->name("admin.hospital.destroy");
    // diagnostic route
    Route::get("/diagnostic", [DiagnosticController::class, 'index'])->name("admin.diagnostic.index");
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

});

//doctor authentication
Route::group(['prefix' => 'doctor'], function () {
    Route::get("/", [LoginController::class, 'showDoctorLoginForm']);
    Route::post("/login", [LoginController::class, "doctorLogin"])->name("doctor.login");
    Route::get("/dashboard", [DoctorDoctorController::class, "index"])->name("doctor.dashboard");

    //doctor update profile
    Route::get("/doctor-profile", [DoctorDoctorController::class, "doctor"])->name("doctor.profile");
    Route::post("/doctor-update", [DoctorDoctorController::class, "update"])->name("doctor.doctor.update");
    Route::get("/doctor-password", [DoctorDoctorController::class, "password"])->name("doctor.doctor.password");
    Route::post("/doctor-password-update", [DoctorDoctorController::class, "passwordUpdate"])->name("doctor.doctor.passwordupdate");
    Route::post("/doctor-image-update", [DoctorDoctorController::class, "imageUpdate"])->name("doctor.doctor.imageUpdate");
    // patient appointment
    Route::get("/doctor-appointment-today", [DoctorDoctorController::class, "todayAppointment"])->name("today.doctor.appointment");
    Route::get("/doctor-appointment", [DoctorDoctorController::class, "doctorAppointment"])->name("doctor.appointment");
    Route::get("/doctor-patient-show/{id}", [DoctorDoctorController::class, "doctorPatient"])->name("doctor.patient");
    Route::post("/comment/store", [DoctorDoctorController::class, "comment"])->name("comment.store");
});

//hospital authentication
Route::group(['prefix' => 'hospital'], function () {
    Route::get("/", [LoginController::class, 'showHospitalLoginForm']);
    Route::post("/login", [LoginController::class, "hospitalLogin"])->name("hospital.login");
    Route::get("/dashboard", [HospitalHospitalController::class, "index"])->name("hospital.dashboard");
    Route::get("/profile", [HospitalHospitalController::class, "profile"])->name("hospital.profile");
    Route::get("/password", [HospitalHospitalController::class, "password"])->name("hospital.password");
    Route::post("/password-update", [HospitalHospitalController::class, "passwordUpdate"])->name("hospital.password.update");
    Route::post("/image-update", [HospitalHospitalController::class, "imageUpdate"])->name("hospital.image.update");
    Route::post("/hospital/update", [HospitalHospitalController::class, "update"])->name("hospital.hospital.update");

    // hospital doctor route
    Route::get("/doctor", [HospitalDoctorController::class, 'index'])->name("hospital.doctor.index");
    Route::get("/doctor-create", [HospitalDoctorController::class, 'create'])->name("hospital.doctor.create");
    Route::post("/doctor", [HospitalDoctorController::class, 'store'])->name("hospital.doctor.store");
    Route::get("/doctor-edit/{id}", [HospitalDoctorController::class, 'edit'])->name("hospital.doctor.edit");
    Route::post("/doctor-update", [HospitalDoctorController::class, 'update'])->name("hospital.doctor.update");
    Route::post("/doctor-delete", [HospitalDoctorController::class, 'destroy'])->name("hospital.doctor.destroy");
    // hospital appointment
    Route::get("/hospital-patient-appointment", [AppointmentController::class, "index"])->name("hospital.appointment.index");
    Route::get("/hospital-patient-show/{id}", [AppointmentController::class, "patient"])->name("hospital.patient.show");
    Route::post("/hospital/comment/store", [AppointmentController::class, "comment"])->name("hospital.comment.store");
    // dignostic comment
    Route::post("/hospital/clients/comment", [HospitalDiagnosticController::class, "hospitalcomment"])->name("hospital.client.comment");
});

//diagnostic authentication
Route::group(['prefix' => 'diagnostic'], function () {
    Route::get("/", [LoginController::class, 'showDiagnosticLoginForm']);
    Route::post("/login", [LoginController::class, "diagnosticLogin"])->name("diagnostic.login");
    Route::get("/dashboard", [DiagnosticDiagnosticController::class, "index"])->name("diagnostic.dashboard");
    Route::get("/profile", [DiagnosticDiagnosticController::class, "profile"])->name("diagnostic.profile");
    Route::post("/profile-update", [DiagnosticDiagnosticController::class, "update"])->name("diagnostic.profile.update");
    Route::get("/password", [DiagnosticDiagnosticController::class, "password"])->name("diagnostic.password");
    Route::post("/password-update", [DiagnosticDiagnosticController::class, "updatePassword"])->name("diagnostic.password.update");
    Route::post("/image-update", [DiagnosticDiagnosticController::class, "updateImage"])->name("diagnostic.image.update");

    // diagnostic doctor route
    Route::get("/doctor", [DiagnosticDoctorController::class, 'index'])->name("diagnostic.doctor.index");
    Route::get("/doctor-create", [DiagnosticDoctorController::class, 'create'])->name("diagnostic.doctor.create");
    Route::post("/doctor", [DiagnosticDoctorController::class, 'store'])->name("diagnostic.doctor.store");
    Route::get("/doctor-edit/{id}", [DiagnosticDoctorController::class, 'edit'])->name("diagnostic.doctor.edit");
    Route::post("/doctor-update", [DiagnosticDoctorController::class, 'update'])->name("diagnostic.doctor.update");
    Route::post("/doctor-delete", [DiagnosticDoctorController::class, 'destroy'])->name("diagnostic.doctor.destroy");
    // diagnostic patient list
    Route::get("/patient/list", [DiagnosticAppointmentController::class, "index"])->name("diagnostic.appointment");
    Route::get("/diagnostic-patient-show/{id}", [DiagnosticAppointmentController::class, "patient"])->name("diagnostic.patient.show");
    Route::post("/diagnostic/comment/store", [DiagnosticAppointmentController::class, "comment"])->name("diagnostic.comment.store");
    // dignostic comment
    Route::post("/diagnostic/clients/comment", [HospitalDiagnosticController::class, "diagnosticcomment"])->name("diagnostic.client.comment");
});

//ambulance authentication
Route::group(['prefix' => 'ambulance'], function () {
    Route::get("/", [LoginController::class, 'showAmbulanceLoginForm']);
    Route::post("/login", [LoginController::class, "ambulanceLogin"])->name("ambulance.login");
    Route::get("/dashboard", [AmbulanceAmbulanceController::class, "index"])->name("ambulance.dashboard");
    Route::get("/profile", [AmbulanceAmbulanceController::class, "profile"])->name("ambulance.profile");
    Route::post("/profile-update", [AmbulanceAmbulanceController::class, "update"])->name("ambulance.profile.update");
    Route::get("/password", [AmbulanceAmbulanceController::class, "password"])->name("ambulance.password");
    Route::post("/password-update", [AmbulanceAmbulanceController::class, "updatePassword"])->name("ambulance.password.update");
    Route::post("/image-update", [AmbulanceAmbulanceController::class, "updateImage"])->name("ambulance.image.update");

    // ambulance hire route
    Route::get("/hire-ambulance", [AmbulanceHireAmbulanceController::class, "index"])->name("ambulance.hire.ambulance");
    Route::post("/comment-on-clints", [AmbulanceHireAmbulanceController::class, "comment"])->name("ambulance.hire.comment");
});
//privatecar authentication
Route::group(['prefix' => 'privatecar'], function () {
    Route::get("/", [LoginController::class, 'showPrivatecarLoginForm']);
    Route::post("/login", [LoginController::class, "privatecarLogin"])->name("privatecar.login");
    Route::get("/dashboard", [PrivatecarPrivatecarController::class, "index"])->name("privatecar.dashboard");
    Route::get("/profile", [PrivatecarPrivatecarController::class, "profile"])->name("privatecar.profile");
    Route::post("/profile-update", [PrivatecarPrivatecarController::class, "update"])->name("privatecar.profile.update");
    Route::get("/password", [PrivatecarPrivatecarController::class, "password"])->name("privatecar.password");
    Route::post("/password-update", [PrivatecarPrivatecarController::class, "updatePassword"])->name("privatecar.password.update");
    Route::post("/image-update", [PrivatecarPrivatecarController::class, "updateImage"])->name("privatecar.image.update");
});