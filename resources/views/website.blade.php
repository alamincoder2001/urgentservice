@extends("layouts.master")

@push("style")
<style>
    /* =========== doctor card design ============ */
    .doctor_details .card {
        transition: 2ms ease-in-out;
    }

    .doctor_details .card:hover {
        border: 1px solid #d9d9d9 !important;
        box-shadow: 5px 3px 0px 3px #81818130 !important;
    }

    .doctor_department {
        text-decoration: none;
        display: block;
        list-style: none;
        padding: 4px;
        font-family: auto;
        margin-bottom: 5px;
        border-bottom: 1px dashed #d1d1d1;
        color: #626262;
        transition: 2ms ease-in-out;
    }

    .doctor_department:hover {
        color: red !important;
    }
    .carbtn {
        width: 12px !important;
        height: 12px !important;
        border-radius: 50%;
        background: transparent !important;
        border: 1px solid #fff !important;
    }

    .homeBtn:focus {
        background: green;
    }

    .message-body .image {
        width: 150px;
        height: 150px;
        background: gray;
        border-radius: 50%;
        overflow: hidden;
        margin: 10px auto;
    }

    #testmonial .message-body {
        width: 500px;
        margin: 30px auto;
    }

    .departments {
        background: linear-gradient(45deg, #0718e7, #00a10c) !important;
    }

    .department {
        border: none;
        border-radius: 15px;
        width: 100%;
        height: 110px;
        display: flex;
        align-items: center;
        background: #050d6ceb;
        text-align: center;
        color: white;
        cursor: pointer;
        text-transform: uppercase;
        font-family: sans-serif;
        transition: all ease-in-out;
    }
    .department:hover{
        background: linear-gradient(201deg, #0694cb, #09581edb) !important;
    }

    /* service section design */
    .card .card-img {
        width: 110px;
        margin: auto;
        height: 100px;
        background: #23ebff;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        box-shadow: 5px -5px 0px 0px #aba6a6;
    }

    #service .card {
        padding-top: 15px;
        color: #7c7c7c;
        border-radius: 0;
        transition: 0.1s ease-in-out;
    }

    #service .card:hover {
        color: #ff3939;
        box-shadow: 1px 0px 0px 3px #6c6c6c47 !important;
    }

    /* blood donor list */
    .blooddonor .card .card-img {
        width: 90px;
        margin: auto;
        height: 85px;
        background: #93939305;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0px 4px 0px 1px whitesmoke;
    }

    .blooddonor .card {
        padding-top: 15px;
        background: none;
        border-radius: 5px;
        transition: all ease-in-out;
        box-shadow: 0px 0px 0px 1px #d9d9d9;
    }

    .blooddonor .card:hover .card-img {
        box-shadow: 1px 2px 0px 0px #919191;
    }

    .blooddonor .card:hover {
        color: orangered;
        box-shadow: 1px 1px 1px 1px #7a7a7a;
    }
</style>

@endpush

@section("content")

<!-- carousel part -->
<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @foreach($data["slider"] as $key => $item)
        <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{$key}}" class="{{$key==0?'active':''}}" aria-current="{{$key==0?'true':''}}" aria-label="{{$key}}"></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($data["slider"] as $key => $item)
        <div class="carousel-item {{$key==0?'active':''}}" ata-bs-interval="10000" style="background: url('{{asset($item->image)}}');">
            <!-- <div class="carousel-caption d-md-block">
                <h5>{{$item->title}}</h5>
                <p>{{$item->short_text}}</p>
            </div> -->
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" style="opacity: unset;" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <!-- <span class="carousel-control-prev-icon" aria-hidden="true"></span> -->
        <i class="fa fa-chevron-left" style="display: flex;align-items: center;background: #283290;padding: 10px 13px;"></i>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" style="opacity: unset;" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
        <i class="fa fa-chevron-right" style="display: flex;align-items: center;background: #283290;padding: 10px 13px;"></i>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<section id="search">
    <div class="container">
        <div class="search">
            <div class="row">
                <div class="col-md-12 col-12">
                    <form id="fillterWebsite">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6 col-lg-3 col-6">
                                <div class="form-group mb-4 mb-md-0">
                                    <label for="city" class="d-lg-block d-none">City</label>
                                    <select name="city" id="city" class="rounded-pill city">
                                        <option label="Select City"></option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-city text-white"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 col-6">
                                <div class="form-group mb-4 mb-md-0">
                                    <label for="service" class="d-lg-block d-none">Service</label>
                                    <select name="service" id="country" class="service rounded-pill">
                                        <option label="Select Service"></option>
                                    </select>
                                    <span class="error-service text-white"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 col-6">
                                <div class="form-group">
                                    <label for="country" class="d-lg-block d-none">Select <span id="Name"></span> Name</label>
                                    <select name="country" id="country" class="Name rounded-pill">
                                        <option label="Select Name"></option>
                                    </select>
                                    <span class="error-country text-white"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 col-6 mt-0 mt-md-4">
                                <div class="form-group text-center">
                                    <button type="submit" class="btn text-white homeBtn rounded-pill">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- header section end -->

<!-- service section -->
<div id="show">
    <div class="container">
        <div class="row main-show d-flex justify-content-center doctor_details">
        </div>
    </div>
</div>

<section id="service">
    <div class="container">
        <div class="service-header text-center">
            <h2 class="text-uppercase">Our Services</h2>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-lg-3 mb-3">
                <a href="{{route('doctor.details')}}" class="text-decoration-none">
                    <div class="card border-0">
                        <div class="card-img">
                        <img src="{{asset('frontend/img/doctor.png')}}" width="90" />
                        </div>
                        <div class="card-body text-center">
                            <h6 class="text-uppercase">Find Specialist Doctors</h6>
                            <p>Find specialist doctors any where in Bangladesh</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 mb-3">
                <a href="{{route('hospital.details')}}" class="text-decoration-none">
                    <div class="card border-0">
                        <div class="card-img">
                            <img src="{{asset('frontend/img/hospital.png')}}" width="90" />
                        </div>
                        <div class="card-body text-center">
                            <h6 class="text-uppercase">Find Your Hospital</h6>
                            <p>Find good hospital any where in Bangladesh</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 mb-3">
                <a href="{{route('diagnostic.details')}}" class="text-decoration-none">
                    <div class="card border-0">
                        <div class="card-img">
                            <img src="{{asset('frontend/img/diagnostic.png')}}" width="90" />
                        </div>
                        <div class="card-body text-center">
                            <h6 class="text-uppercase">Find Your Diagnostic</h6>
                            <p>Find good diagnostic any where in Bangladesh</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 mb-3">
                <a href="{{route('ambulance.details')}}" class="text-decoration-none">
                    <div class="card border-0">
                        <div class="card-img">
                            <img src="{{asset('frontend/img/ambulance.png')}}" width="90" />
                        </div>
                        <div class="card-body text-center">
                            <h6 class="text-uppercase">Find Your Ambulance</h6>
                            <p>Find ambulance service any where in Bangladesh</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 mb-3">
                <a href="{{route('privatecar.details')}}" class="text-decoration-none">
                    <div class="card border-0">
                        <div class="card-img">
                            <img src="{{asset('frontend/img/privatecar.png')}}" width="90" />
                        </div>
                        <div class="card-body text-center">
                            <h6 class="text-uppercase">Find Your Private car</h6>
                            <p>Find Private car service any where in Bangladesh</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 mb-3">
                <a href="{{route('pathology')}}" class="text-decoration-none">
                    <div class="card border-0">
                        <div class="card-img">
                            <img src="{{asset('frontend/img/pathology.png')}}" width="90" />
                        </div>
                        <div class="card-body text-center">
                            <h6 class="text-uppercase">Goto Pathology Page</h6>
                            <p>Go to Pathology page and Test at low cost</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- doctor section -->

<section style="padding:55px 0; background: #f7f7f7;">
    <div class="container">
        <div class="doctor-header text-center">
            <h2 class="text-uppercase mb-5">Specialist Wise Doctor</h2>
        </div>
        <div class="row">
            @foreach($departments as $item)
            <div class="col-6 col-lg-2">
                <a href="{{url('/doctor-details', $item->name)}}" class="text-decoration-none">
                    <div class="card department mb-4 position-relative">
                        <span style="position: absolute;top: -15px;right: 0;background: #ff0000;padding: 3px 6px;border-radius: 50%;font-size: 12px;">{{$item->specialistdoctor->count()}}</span>
                        <div class="card-body d-flex align-items-center">
                            <p>{{$item->name}}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="borderShow d-none" style="border-top: 3px dotted #c5c3c3;padding-top: 5px;"></div>
        <div class="row d-flex justify-content-center addDepartment">
        </div>
    </div>
</section>

<!-- all Donor -->
<section id="corporate" style="padding: 55px 0;background:#ffffff;">
    <div class="container blooddonor">
        <div class="doctor-header text-center">
            <h2 class="text-uppercase mb-5">Blood Donor</h2>
        </div>
        <div class="row">
            @foreach($bloodgroup as $item)
            <div class="col-12 col-lg-3 mb-3">
                <a href="{{route('donor', $item->id)}}" class="text-decoration-none">
                    <div class="position-relative card border-0">
                        <div class="card-img">
                            <img src="{{asset('frontend/img/donor.png')}}" width="90" />
                        </div>
                        <span style="position: absolute;top:0;right:0;padding:1px 8px;border-radius:50%;background:red;color:white;">{{count($item->donor)}}</span>
                        <div class="card-body text-center">
                            <h6>{{$item->blood_group}}ve</h6>
                            <p class="text-uppercase" style="font-style:italic;font-size:10px;">Find {{$item->blood_group}}ve blood donor list</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- corporate partner -->
<section id="corporate" style="padding: 25px 0;background:#ffffff;">
    <div class="container">
        <div class="doctor-header text-center">
            <h2 class="text-uppercase mb-5">Our Corporate Partner</h2>
        </div>
        @if($data["partner"]->count() > 0)
        <div class="corporate owl-carousel owl-theme owl-loaded">
            @foreach($data["partner"] as $item)
            <div class="item">
                <img src="{{asset($item->image)}}" width="100" alt="">
            </div>
            @endforeach
        </div>
        @else
        <p class='text-center m-0'>Not Found Data</p>
        @endif
    </div>
</section>

@endsection


@push("js")
<script>
    $(document).ready(() => {

        $(".city").select2({
            placeholder: "Select city"
        });
        $(".Name").select2({
            placeholder: "Select Name"
        });

        $("#city").on("change", (event) => {
            var arr = ["Doctor", "Hospital", "Diagnostic", "Ambulance", "Privatecar"]
            $(".service").html(`<option value="">Select Service</option>`)
            $("#Name").html("")
            $(".Name").html(`<option value="">Select Name</option>`)
            if (event.target.value) {
                $.each(arr, (index, value) => {
                    $(".service").append(`<option value="${value}">${value}</option>`)
                })
            }
        })
        $(document).on("change", ".service", (event) => {
            if (event.target.value) {
                $.ajax({
                    url: "{{route('filter.city')}}",
                    method: "POST",
                    data: {
                        id: $("#city").val(),
                        service: $(".service").val()
                    },
                    beforeSend: () => {
                        $(".Name").html(`<option value="">Select ${event.target.value} Name</option>`)
                        $("#Name").html(event.target.value)
                    },
                    success: (response) => {
                        if (response.null) {} else {
                            $.each(response, (index, value) => {
                                var row = `<option value="${value.name}">${value.name}</option>`;
                                $(".Name").append(row)
                            })
                        }
                    }
                })
            } else {
                $("#Name").html(event.target.value)
                $(".Name").html(`<option value="">Select ${event.target.value} Name</option>`)
            }
        })

        $("#fillterWebsite").on("submit", (event) => {
            event.preventDefault();
            var ci = $("#city").val();
            var city = $(".service").val();
            $(".error-city").text("")
            $(".error-service").text("")
            if (ci !== "") {
                if (city !== "") {
                    if (city == "Doctor") {
                        var url = "{{route('filter.doctor')}}"
                        var formdata = {
                            city: ci,
                            doctor_name: $(".Name").val()
                        }
                        Filter(formdata, url, city)
                    } else if (city == "Hospital") {
                        var url = "{{route('filter.hospital')}}"
                        var formdata = {
                            city: ci,
                            hospital_name: $(".Name").val()
                        }
                        Filter(formdata, url, city)
                    } else if (city == "Diagnostic") {
                        var url = "{{route('filter.diagnostic')}}"
                        var formdata = {
                            city: ci,
                            diagnostic_name: $(".Name").val()
                        }
                        Filter(formdata, url, city)
                    } else if (city == "Privatecar") {
                        var url = "{{route('filter.privatecar')}}"
                        var formdata = {
                            city: ci,
                            privatecar_name: $(".Name").val()
                        }
                        Filter(formdata, url, city)
                    } else {
                        var url = "{{route('filter.ambulance')}}"
                        var formdata = {
                            city: ci,
                            ambulance_name: $(".Name").val()
                        }
                        Filter(formdata, url, city)
                    }
                } else {
                    $(".error-service").text("Must be select service")
                }
            } else {
                $(".error-city").text("Select city first")
            }
        })

        function Filter(formdata, url, city) {
            $.ajax({
                url: url,
                method: "POST",
                data: formdata,
                beforeSend: () => {
                    ClearAll()
                    $("#fillterWebsite").find(".error").text("")
                    $(".error-city").text("")
                    $(".error-service").text("")
                    $(".main-show").html("");
                    $(".Loading").removeClass("d-none")
                },
                success: (response) => {
                    if (response.error) {
                        $(".error-city").text(response.error.city)
                    } else {
                        if (response.null) {
                            $(".main-show").html(`<p>${response.null}</p>`);
                        } else {
                            $.each(response, (index, value) => {
                                $(".main-show").css({
                                    padding: "55px 0"
                                })
                                if (city == "Doctor") {
                                    Doctor(index, value)
                                } else if (city == "Diagnostic") {
                                    Diagnostic(index, value)
                                } else if (city == "Hospital") {
                                    Hospital(index, value)
                                } else if (city == "Privatecar") {
                                    Privatecar(index, value)
                                } else {
                                    Ambulance(index, value)
                                }
                            })
                        }
                    }
                },
                complete: () => {
                    $(".Loading").addClass("d-none")
                }
            })
        }
    })

    function Doctor(index, value) {
        var row = `
                <div class="col-12 col-lg-4 mb-3">
                    <a href="/single-details-doctor/${value.id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                        <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:150px;">
                            <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                    <img height="100%" src="${value.image != 0?location.origin+"/"+value.image:location.origin+'/uploads/nouserimage.png'}" width="100">
                                </div>
                                <div class="info" style="padding-right:5px;">
                                    <h6>${value.name}</h6>
                                    <p style="color:#c99913;">${value.department.length > 0 ? value.department[0].specialist.name:''}, ${value.city.name}</p>
                                    <p style="border-top: 2px dashed #dddddd85;text-align:justify;">${value.education.substring(0, 100)}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            `;
        $(".main-show").append(row)
    }

    function Diagnostic(index, value) {
        var row = `
            <div class="col-md-6 col-10 col-sm-6 col-lg-4 diagnosticbody">
                <div class="card border-0 mb-4" style="background: #ffffff;box-shadow:0px 0px 7px 2px #c1c1c1;">
                    <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                        <img src="${value.image?value.image:'frontend/img/hospital.jpg'}" style="width: 100%; height:160px;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center" style="font-size: 15px;">${value.name}</h5>
                        <p class="card-text text-primary text-center mb-2"><span>${value.diagnostic_type.toUpperCase()}</span> | <span>+880 ${value.phone.substr(1)}</span></p>
                        <ul style="list-style: none;padding:0 0 0 5px;">
                            <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span style="font-size: 13px;">${value.address}, ${value.city.name}</span></li>
                            <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span style="font-size: 13px;">${value.email}</span></li>
                        </ul>
                    </div>
                    <a class="text-decoration-none text-white text-uppercase" target="_blank" href="${'/single-details-diagnostic/'+value.id}">
                    <div class="card-footer border-0 text-center py-3">
                        View Details
                    </div>
                    </a>
                    ${value.discount_amount!=0?"<div class='discount'>-"+value.discount_amount+"%</div>":""}
                </div>
            </div>
        `;
        $(".main-show").append(row)
    }

    function Hospital(index, value) {
        var row = `
                <div class="col-md-6 col-10 col-sm-6 col-lg-4 hospitalbody">
                    <div class="card border-0 mb-4" style="background: #ffffff;box-shadow:0px 0px 7px 2px #c1c1c1;">
                        <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                            <img src="${value.image?value.image:'frontend/img/hospital.jpg'}" style="width: 100%; height:160px;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center" style="font-size: 15px;">${value.name}</h5>
                            <p class="card-text text-primary text-center mb-2"><span>${value.hospital_type.toUpperCase()}</span> | <span>+880 ${value.phone.substr(1)}</span></p>
                            <ul style="list-style: none;padding:0 0 0 5px;">
                                <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span style="font-size: 13px;">${value.address}, ${value.city.name}</span></li>
                                <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span style="font-size: 13px;">${value.email}</span></li>
                            </ul>
                        </div>
                        <a class="text-decoration-none text-white text-uppercase" target="_blank" href="${'/single-details-hospital/'+value.id}">
                        <div class="card-footer border-0 text-center py-3">
                            View Details
                        </div>
                        </a>
                        ${value.discount_amount!=0?"<div class='discount'>-"+value.discount_amount+"%</div>":""}
                    </div>
                </div>
        `;
        $(".main-show").append(row)
    }

    function Ambulance(index, value) {
        var row = `
            <div class="col-md-6 col-10 col-sm-6 col-lg-4 ambulancebody">
                <div class="card border-0 mb-4" style="background: #ffffff;box-shadow:0px 0px 7px 2px #c1c1c1;height:400px;font-size-adjust: 0.58;">
                    <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                        <img src="${value.image}" style="width: 100%; height:160px;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center" style="font-size: 15px;">${value.name}</h5>
                        <p class="card-text text-primary text-center mb-2"><span>${value.ambulance_type.replaceAll(",", " | ")}</span></p>
                        <ul style="list-style: none;padding:0 0 0 5px;">
                            <li><i style="width: 15px;height:15px;" class="fa fa-phone text-info"></i> <span style="font-size: 13px;">+880 ${value.phone.substr(1)}</span></li>
                            <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span style="font-size: 13px;">${value.address}, ${value.city.name}</span></li>
                            <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span style="font-size: 13px;">${value.email}</span></li>
                        </ul>
                    </div>
                    <a href="${'single-details-ambulance/'+value.id}" target="_blank" class="text-uppercase text-white text-decoration-none text-center">
                        <div class="card-footer border-0 py-3">
                            View Details
                        </div>
                    </a>
                </div>
            </div>
        `;
        $(".main-show").append(row)
    }

    function Privatecar(index, value) {
        var row = `
            <div class="col-md-6 col-10 col-sm-6 col-lg-4 privatecarbody">
                <div class="card border-0 mb-4" style="background: #ffffff;box-shadow:0px 0px 7px 2px #c1c1c1;">
                    <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                        <img src="${value.image}" style="width: 100%; height:160px;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center" style="font-size: 15px;">${value.name}</h5>
                        <p class="card-text text-primary text-center mb-2"><span>${value.cartype_id.replaceAll(",", " | ")}</span></p>
                        <ul style="list-style: none;padding:0 0 0 5px;">
                            <li><i style="width: 15px;height:15px;" class="fa fa-phone text-info"></i> <span style="font-size: 13px;">+880 ${value.phone.substr(1)}</span></li>
                            <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span style="font-size: 13px;">${value.address}, ${value.city.name}</span></li>
                            <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span style="font-size: 13px;">${value.email}</span></li>
                        </ul>
                    </div>
                    <a href="${'single-details-privatecar/'+value.id}" target="_blank" class="text-uppercase text-white text-decoration-none text-center">
                        <div class="card-footer border-0 py-3">
                            View Details
                        </div>
                    </a>
                </div>
            </div>
            `;
        $(".main-show").append(row)

    }

    function ClearAll() {
        $("#service").addClass("d-none")
        $("#doctor").addClass("d-none")
        $("#facilities").addClass("d-none")
        $("#testmonial").addClass("d-none")
        $("#corporate").addClass("d-none")
    }
</script>
@endpush