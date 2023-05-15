<?php

namespace App\Providers;

use App\Models\BloodGroup;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Devfaysal\BangladeshGeocode\Models\District;
use Devfaysal\BangladeshGeocode\Models\Upazila;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        View::share('setting', Setting::first());
        View::share('contact', Contact::first());
        View::share('cities', District::with('donor', 'doctor', 'hospital', 'diagnostic', 'ambulance', 'privatecar')->orderBy("name")->get());
        View::share('upazilas', Upazila::orderBy("name")->get());
        View::share('departments', Department::with('specialistdoctor')->orderBy("name", 'ASC')->get());
        View::share('doctors', Doctor::orderBy("name", 'ASC')->get());
        View::share("bloodgroup", BloodGroup::with('donor')->get());
    }
}
