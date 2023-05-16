@php
$contact = \App\Models\Contact::first();
@endphp
<section class="top-header">
    <div class="container-fluid">
        <div class="row d-flex align-item-center">
            <div class="col-md-6 col-4">
                <p>Address: {{ucfirst($contact->address)}}</p>
            </div>
            <div class="col-md-6 col-8">
                <p class="text-end"><span>Opening Hours:</span> Monday to Saturday - 8am to 10pm, <span>Contact: </span> +880 {{str_replace('0','', $contact->phone)}}</p>
            </div>
        </div>
    </div>
</section>


<nav class="navbar navbar-expand-lg sticky-top min-high">
    <div class="container p-0">
        <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{asset($setting->logo)}}" style="width: 215px;height:60px;" />
        </a>
        <button style="outline: 0;box-shadow: none;background: #fff;" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto text-center mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{Route::is('website')?'activ':''}}" href="{{url('/')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{Route::is('doctor.details')?'activ':''}}" href="{{route('doctor.details')}}">Doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{Route::is('hospital.details')?'activ':''}}" href="{{route('hospital.details')}}">Hospital</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{Route::is('diagnostic.details')?'activ':''}}" href="{{route('diagnostic.details')}}">Diagnostic</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{Route::is('ambulance.details')?'activ':''}}" href="{{route('ambulance.details')}}">Ambulance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{Route::is('privatecar.details')?'activ':''}}" href="{{route('privatecar.details')}}">Privatecar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{Route::is('pathology')?'activ':''}}" href="{{route('pathology')}}">Pathology</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{Route::is('donor')?'activ':''}}" href="{{route('donor')}}">Blood Donor</a>
                </li>
            </ul>
        </div>
        <div id="google_translate_element" style="margin-left: 8px;"></div>
        <button type="button" value="0" class="SearchBtn btn btn-dark py-1 fa fa-search" style="box-shadow: none;"></button>
    </div>
</nav>
<div class="ShowSearchBtn d-none">
    <div class="container p-0">
        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2">
                <form class="d-flex" onsubmit="searchSubmit(event)">
                    <div class="input-group">
                        <select name="service" class="form-control" id="services" style="box-shadow: none;border-radius:0;">
                            <option value="">Select Service Name</option>
                            <option value="Doctor">Doctor</option>
                            <option value="Hospital">Hospital</option>
                            <option value="Diagnostic">Diagnostic</option>
                            <option value="Ambulance">Ambulance</option>
                            <option value="Privatecar">Private Car</option>
                        </select>
                        <input type="text" name="name" class="form-control searchName" style="box-shadow: none;border-radius:0;" autocomplete="off"/>
                        <button type="submit" class="btn btn-success px-4" style="font-weight:500;box-shadow: none; border-radius:0;">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>