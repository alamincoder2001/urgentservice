@extends("layouts.master")

@push('style')

<style>
    #appointment input[type="text"] {
        padding: 7px 8px;
        font-size: 13px;
        width: 100%;
        outline: none;
        border: 0;
        border-bottom: 1px solid #b7b7b7;
        font-family: cursive;
    }

    #appointment input[type="text"]:focus {
        box-shadow: none;
        border-color: green;
    }

    #appointment select {
        padding: 7px 8px;
        font-size: 14px;
        width: 100%;
        outline: none;
        border: 0;
        border-bottom: 1px solid #b7b7b7;
        cursor: pointer;
        font-family: cursive;
    }

    #appointment select:focus {
        box-shadow: none;
        border-color: green;
    }

    #appointment textarea {
        padding: 7px 8px;
        font-size: 14px;
        width: 100%;
        outline: none;
        border: 0;
        border-bottom: 1px solid #b7b7b7;
        font-family: cursive;
    }

    #appointment textarea:focus {
        box-shadow: none;
        border-color: green;
    }

    #appointment input[type="number"] {
        padding: 7px 8px;
        font-size: 14px;
        width: 100%;
        outline: none;
        border: 0;
        border-bottom: 1px solid #b7b7b7;
        font-family: cursive;
    }

    #appointment input[type="number"]:focus {
        box-shadow: none;
        border-color: green;
    }

    #appointment button {
        text-transform: uppercase;
        font-size: 13px;
        font-weight: 600;
        font-family: cursive;
        box-shadow: none;
    }

    #appointment label {
        font-family: cursive;
        font-size: 14px;
    }

    .goog-te-menu-value span {
        display: none;
        margin: 6px !important;
    }

    .daytimescrollbar::-webkit-scrollbar {
        display: none;
    }
</style>
@endpush

@section("content")
<section id="appointment" style="padding: 25px 0;">
    <div class="container">
        <div class="doctordetail-header mb-2" style="background: #fff; border:2px solid #035b64 !important;">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="{{asset($data->image != '0'?$data->image:'frontend/nodoctorimage.png')}}" style="width:150px;height:150px;" class="rounded border border-1 p-2" alt="">
                </div>
                <div class="col-md-4 d-flex align-items-center text-center justify-content-md-start justify-content-center">
                    <div class="d-flex align-items-center" style="flex-direction:column;">
                        <h4>{{$data->name}}</h4>
                        <h5 style="font-size: 14px;font-weight: 300;font-family: serif;word-spacing: 3px;">{{$data->education}}</h5>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="border-start p-2">
                        <h6 id="DoctorInfo" style="font-family: math;font-weight: 900;">
                            @foreach($data->department as $dept)
                            <span>{{$dept->specialist->name}},</span>
                            @endforeach
                        </h6>
                        <p>
                            <span class="fs-5" style="font-size: 15px !important;font-weight: 500;font-family: math;">Address:</span>
                            {{$data->address}}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="card border-0" style="box-shadow: 1px 1px 1px 2px #035b64;height:552px;border-radius:0;">
                    <div class="card-header text-center text-white" style="background: #035b64 !important;border-radius:0;">
                        <h4 class="fs-6 text-uppercase m-0 p-1">The diseases that are treated</h4>
                    </div>
                    <div class="card-body">
                        <div class="concentration">
                            <div style="font-size: 13px; font-family:cursive;" id="concentration">{!!$data->concentration!!}</div>
                        </div>
                        <hr>
                        <div class="details-status">
                            <div style="text-align: justify; font-family:cursive;" id="description">{!!$data->description!!}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-0" style="box-shadow: 1px 1px 1px 2px #035b64; height:552px;border-radius:0;">
                    <div class="card-header text-center text-white" style="background: #035b64 !important;border-radius:0;">
                        <h4 class="fs-6 text-uppercase m-0 p-1">Availability Time & Location</h4>
                    </div>
                    <div class="card-body daytimescrollbar" style="overflow-y: scroll;">
                        @foreach($doctor_details as $item)
                        <div class="daytime" style="margin-bottom: 15px;">
                            <div class="daytime-header" style="background: gainsboro;padding: 5px;">
                                <h5 style="font-size:14px; font-family:cursive;margin:0;">
                                    @if($item->type == 'chamber')
                                    <i class="fa fa-home"></i> {{$item->chamber_name}}
                                    @endif
                                    @if($item->type == 'hospital')
                                    <i class='fa fa-hospital-o'></i> {{$item->hospital_name}}{{$item->hospital_discount>0?' ('.$item->hospital_discount.'%)':''}}
                                    @endif
                                    @if($item->type == 'diagnostic')
                                    <i class="fa fa-plus-square-o"></i> {{$item->diagnostic_name}}{{$item->diagnostic_discount>0?' ('.$item->diagnostic_discount.'%)':''}}
                                    @endif
                                </h5>
                                <p class="m-0" style="margin-left:20px !important">
                                    (
                                    @if($item->type == 'chamber')
                                    {{$item->chamber_address}}
                                    @endif
                                    @if($item->type == 'hospital')
                                    {{$item->hospital_address}}
                                    @endif
                                    @if($item->type == 'diagnostic')
                                    {{$item->diagnostic_address}}
                                    @endif
                                    )
                                </p>
                            </div>
                            <div class="daytime-body">

                                @foreach($item->daywiseTimeArray as $day)
                                <ul class="m-0" style="list-style: none;">
                                    <li class="position-relative">
                                        <i style="left: -15px;top: 7px;font-size: 12px;" class="fa fa-calendar-check-o position-absolute"></i>
                                        <span style="font-size: 11px;font-weight: 500;" class="text-uppercase">
                                            {{$day->day}}
                                        </span>
                                        @foreach(\App\Models\DayTime::daygroup($day->type_id, $day->day) as $time)
                                        <p>{{ date("h:i a", strtotime($time->fromTime))}} - {{date("h:i a", strtotime($time->toTime)) }}</p>
                                        @endforeach
                                    </li>
                                </ul>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-12 mt-3">
                <div class="form-group text-center">
                    <button class="btn btn-success w-100 border-0" style="border-radius: 0;padding: 10px;background:#035b64;"><i class="fa fa-money"></i> Consultation Fee</button>
                </div>
                <div class="d-flex justify-content-center gap-2 mt-2" style="font-family: cursive; font-size:13px;">
                    <div class="d-flex align-items-center badge px-3 py-2 rounded-pill" style="background: #035b64;border-radius:0;">First Visit: ৳ {{$data->first_fee}}</div>
                    <div class="d-flex align-items-center badge px-3 py-2 rounded-pill" style="background: #035b64;border-radius:0;">Second Visit: ৳ {{$data->second_fee}}</div>
                </div>
            </div>
            <div class="col-lg-5 col-12 mt-3">
                <div style="background: #035b64;color: white;padding: 0 5px;text-align: center;margin-bottom: 5px;">{{$data->appointment_text}}</div>
                <div class="form-group d-flex align-items-center justify-content-center">
                    <button onclick="DoctorAppointment(event)" value="1" class="rounded-pill btn text-white w-75" style="background: #035b64 !important;"><i class="fa fa-edit"></i> Take Appointment</button>
                </div>
                <div class="text-center">
                    <span style="font-size: 22px;font-family: cursive;">Or Make a call</span>
                    @php
                    $phoneall = explode(",", $contact->phone);
                    @endphp
                    @foreach($phoneall as $item)
                    <p style="font-size: 18px;font-family: cursive;">{{$item}}</p>
                    @endforeach
                </div>
            </div>

            <div class="col-12 col-lg-12 mt-3">
                <div class="card border-0" style="border-radius: 0;box-shadow: 1px 1px 1px 2px #035b64;">
                    <div class="card-header text-center text-white" style="background: #035b64 !important;border-radius:0;">
                        <h4 class="fs-6 text-uppercase m-0 p-1">Related Doctor</h4>
                    </div>
                    <div class="card-body">
                        <div class="row doctor_details">
                            @if(count($filtered) > 0)
                            @foreach($filtered as $item)
                            <div class="col-12 col-lg-6 mb-3">
                                <a href="{{route('singlepagedoctor', $item->doctor->id)}}" target="_blank" class="text-decoration-none text-secondary" title="{{$item->doctor->name}}">
                                    <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                        <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                            <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                                <img src="{{asset($item->doctor->image? $item->doctor->image:'/uploads/nouserimage.png')}}" width="100" height="100%">
                                            </div>
                                            <div class="info" style="padding-right:5px;">
                                                <h6>{{$item->doctor->name}}</h6>
                                                <p style="color:#c99913;">{{$item->specialist->name}}, {{$item->doctor->city->name}}</p>
                                                <p style="border-top: 2px dashed #dddddd85;text-align:justify;">{{mb_strimwidth($item->doctor->education, 0, 100, "...")}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                            @else
                            <div class="text-center">Not Found Data</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center mt-4">
        <div class="col-md-6 d-none showDoctorAppointment" style="position: fixed;top: 25px;z-index: 99999;left: 25%;">
            <div class="card p-3" style="border-radius:0;background:#f5f5f5;box-shadow:1px 1px 1px 2px #035b64;">
                <div class="card-header border-0 text-white d-flex justify-content-between" style="background: #035b64 !important;">
                    <h4 class="fs-6 text-uppercase">Appointment</h4>
                    <button class="btn btn-danger" value="0" onclick="DoctorAppointmentClose(event)">Close</button>
                </div>
                <div class="card-body">
                    <form id="Appointment">
                        <input type="hidden" id="doctor_id" name="doctor_id" value="{{$data->id}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact" class="py-2">Contact</label>
                                    <input type="text" name="contact" id="contact" autocomplete="off" class="form-control" placeholder="Contact Number">
                                    <span class="error-contact error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="appointment_date" class="py-2">Appointment Date</label>
                                    <input type="text" name="appointment_date" id="appointment_date" class="form-control" value="{{date('d-m-Y')}}">
                                    <span class="error-appointment_date error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="py-2">Doctor Chamber</label>
                                    <select name="organization_id" id="organization_id" class="form-control">
                                        <option value="">Select Doctor Chamber</option>
                                        @foreach($doctor_details as $item)
                                        @if($item->type == 'chamber')
                                        <option data-id="{{$item->type}}" value="{{$item->chamber_name}}">{{$item->chamber_name}}</option>
                                        @endif
                                        @if($item->type == 'hospital')
                                        <option data-id="{{$item->type}}" value="{{$item->hospital_id}}">{{$item->hospital_name}}</option>
                                        @endif
                                        @if($item->type == 'diagnostic')
                                        <option data-id="{{$item->type}}" value="{{$item->diagnostic_id}}">{{$item->diagnostic_name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <span class="error-organization_id error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label class="py-2">Patient Type</label><br>
                                    <input type="radio" id="new_patient" name="patient_type" value="new_patient">
                                    <label for="new_patient">New Patient</label>
                                    <br>
                                    <input type="radio" id="old_patient" name="patient_type" value="old_patient">
                                    <label for="old_patient">Old Patient</label>
                                    <br>
                                    <span class="error-patient_type error text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="py-2">Patient Name</label>
                                    <input type="text" name="name" id="name" class="form-control" autocomplete="off" placeholder="Patient Name">
                                    <span class="error-name error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="age" class="py-2">Patient Age</label>
                                    <input type="number" name="age" id="age" class="form-control" placeholder="Age">
                                    <span class="error-age error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="district" class="py-2">Ditrict</label>
                                    <select name="district" id="district" class="form-control">
                                        <option value="">Select District</option>
                                    </select>
                                    <span class="error-district error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="upozila" class="py-2">Upazila</label>
                                    <select name="upozila" id="upozila" class="form-control" style="color:#8f8a8a">
                                        <option value="">Select Upazila</option>
                                    </select>
                                    <span class="error-upozila error text-danger"></span>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="rounded-pill px-4 w-50 btn btn-outline-secondary mt-4">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push("js")
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(() => {
        $("#appointment_date").datepicker({
            format: "dd-mm-yyyy",
            startDate: new Date(),
            orientation: 'bottom'
        })

        // get city
        $("#district").on("change", (event) => {
            if (event.target.value) {
                $.ajax({
                    url: "{{route('filter.cityappoinment')}}",
                    method: "POST",
                    data: {
                        id: event.target.value
                    },
                    beforeSend: () => {
                        $("#upozila").html(`<option value="">Select Upozila</option>`)
                    },
                    success: (response) => {
                        if (response.null) {} else {
                            $.each(response, (index, value) => {
                                $("#upozila").append(`<option value="${value.id}">${value.name}</option>`)
                            })
                        }
                    }
                })
            }
        })

        // appointment send
        $("#Appointment").on("submit", (event) => {
            event.preventDefault();

            let contact = $("#Appointment").find("#contact").val()
            if (contact == '') {
                $("#Appointment").find(".error-contact").text("Contact Number is empty")
                return;
            } else if (!Number(contact)) {
                $("#Appointment").find(".error-contact").text("Must be a number value")
                return;
            }
            let formdata = new FormData(event.target)
            formdata.append("organization_name", $("#organization_id option:selected").attr("data-id"))
            $.ajax({
                url: "{{route('appointment')}}",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#Appointment").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#Appointment").find(".error-" + index).text(value);
                        })
                    } else if (response.errors) {
                        $.notify(response.errors, "error");
                        location.reload()
                    } else {
                        $("#Appointment").trigger('reset')
                        DoctorAppointmentClose()
                        $.notify(response, "success");
                        Swal.fire(
                            'Thanks your Appointment!',
                            'কিছুক্ষণের মধ্যে আমাদের একজন প্রতিনিধী আপনার সাথে যোগাযোগ করবে।',
                            'success'
                        )
                    }
                }
            })
        })
        getCity();
        // old patient get details by phone
        $("#Appointment #contact").on("input", (event) => {
            var phoneno = "(?:\\+88|88)?(01[3-9]\\d{8})";
            if (event.target.value) {
                if (event.target.value.match(phoneno)) {
                    $("#Appointment").find(".error-contact").text("")
                    $("#Appointment").find("#contact").css({
                        borderBottom: "1px solid #b7b7b7"
                    })
                    $.ajax({
                        url: "{{route('get.patient.details')}}",
                        method: "POST",
                        data: {
                            number: event.target.value
                        },
                        beforeSend: () => {
                            $("#email").val("")
                            $("#name").val("")
                            $("#age").val("")
                            $("#upozila").html("")
                            getCity();
                        },
                        success: (response) => {
                            if (response) {
                                $("#email").val(response.email)
                                $("#name").val(response.name)
                                $("#age").val(response.age)
                                $("#upozila").html(`<option value="${response.upozila}">${response.upazila.name}</option>`)
                                $("#district").html(`<option value="${response.district}">${response.city.name}</option>`)
                            }
                        }
                    })
                } else {
                    $("#Appointment").find("#contact").css({
                        borderBottom: "1px solid red"
                    })
                    $("#Appointment").find(".error-contact").text("Not valid Number")
                }
            } else {
                $("#Appointment").find(".error-contact").text("")
                $("#Appointment").find("#contact").css({
                    borderBottom: "1px solid #b7b7b7"
                })
                $("#email").val("")
                $("#name").val("")
                $("#age").val("")
                $("#upozila").html("")
                $("#district").html("")
                getCity();
                $(".select2").select2({
                    placeholder: "Select City"
                })
            }
        })
    })

    var concentration = document.getElementById("concentration");
    concentration.setAttribute('data-full', concentration.innerHTML);
    if (concentration.innerText.length > 50) {
        concentration.innerHTML = `${concentration.innerHTML.slice(0, 700)}...`;

        const btn = document.createElement('button');
        btn.innerText = 'Read more...';
        btn.style.border = "none"
        btn.style.float = "right"
        btn.style.background = "none"
        btn.setAttribute('onclick', 'displayConcentration(event)');
        concentration.appendChild(btn);
    }
    const displayConcentration = (elem) => {
        concentration.innerHTML = concentration.getAttribute('data-full');
        concentration.style.height = "250px"
        concentration.style.overflowY = "scroll"
        elem.target.remove();
    };
    // description
    var description = document.getElementById("description");
    description.setAttribute('data-full', description.innerHTML);
    if (description.innerText.length > 50) {
        description.innerHTML = `${description.innerHTML.slice(0, 300)}...`;

        const btn = document.createElement('button');
        btn.innerText = 'Read more...';
        btn.style.border = "none"
        btn.style.float = "right"
        btn.style.background = "none"
        btn.setAttribute('onclick', 'displayDescription(event)');
        description.appendChild(btn);
    }
    const displayDescription = (elem) => {
        description.innerHTML = description.getAttribute('data-full');
        description.style.height = "150px"
        description.style.overflowY = "scroll"
        elem.target.remove();
    };

    function DoctorAppointment(event) {
        $(".showDoctorAppointment").removeClass("d-none")
    }

    function DoctorAppointmentClose(event) {
        $(".showDoctorAppointment").addClass("d-none")
    }
</script>
@endpush