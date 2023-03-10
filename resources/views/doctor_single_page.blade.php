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
                            @if($data->chamber_name)
                            {{$data->address}}, {{$data->city->name}}
                            @else
                            @if($data->hospital_id || $data->diagnostic_id)
                            {{$data->hospital_id?$data->hospital->address:$data->diagnostic->address}}, {{$data->hospital_id?$data->hospital->city->name:$data->diagnostic->city->name}}
                            @endif
                            @endif
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
                    <div class="card-body">
                        <div class="row">
                            <h5 style="font-size:14px; font-family:cursive;">
                                @if(count($data->chamber) != 0)
                                @foreach($data->chamber->take(1) as $chamber)
                                <i class="fa fa-home"></i> {{$chamber->name}}, $chamber->address
                                @endforeach
                                @endif
                                @if($data->hospital_id)
                                <br>
                                <i class='fa fa-hospital-o'></i> {{$data->hospital_id?$data->hospital->name.", ".$data->hospital->city->name:""}}{{$data->hospital->discount_amount>0?' ('.$data->hospital->discount_amount.'%)':''}}
                                @endif
                                @if($data->diagnostic_id)
                                <br>
                                <i class="fa fa-plus-square-o"></i> {{$data->diagnostic_id?$data->diagnostic->name.", ".$data->diagnostic->city->name:""}} {{$data->diagnostic->discount_amount>0?' ('.$data->diagnostic->discount_amount.'%)':''}}
                                @endif
                            </h5>
                            <hr style="margin-bottom: 0;">
                            @foreach($data->time as $day)
                            <div class="col-12">
                                <div class="card border-0">
                                    <div class="card-body" style="padding: 7px 15px !important;">
                                        <div class="day">
                                            <i class="fa fa-calendar-check-o"></i> {{$day->day}}
                                        </div>
                                        <span class="text-uppercase">{{(date("h:i a", strtotime($day->from)))}} - {{date("h:i a", strtotime($day->to))}}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-12 mt-3">
                <div class="form-group text-center">
                    <button class="btn btn-success w-100 border-0" style="border-radius: 0;padding: 10px;background:#035b64;"><i class="fa fa-money"></i> Consultation Fee</button>
                </div>
                <div class="d-flex justify-content-center gap-2 mt-2" style="font-family: cursive; font-size:13px;">
                    <div class="d-flex align-items-center badge px-3 py-2 rounded-pill" style="background: #035b64;border-radius:0;">First Visit: ??? {{$data->first_fee}}</div>
                    <div class="d-flex align-items-center badge px-3 py-2 rounded-pill" style="background: #035b64;border-radius:0;">Second Visit: ??? {{$data->second_fee}}</div>
                </div>
            </div>
            <div class="col-lg-5 col-12 mt-3">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="py-2">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" autocomplete="off" placeholder="example@gmail.com">
                                </div>
                            </div>
                            <div class="col-md-7 col-6">
                                <div class="form-group">
                                    <label for="changeName" class="py-2">Select Chamber or Hospital or Diagnostic</label>
                                    <select id="changeName" data-id="{{$data->id}}" name="changeName" class="form-control">
                                        <option value="">Select Name</option>
                                        <option value="chamber">Chamber</option>
                                        <option value="hospital">Hospital</option>
                                        <option value="diagnostic">Diagnostic</option>
                                    </select>
                                    <span class="error-changeName error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-5 d-none Chamber_Name">
                                <label for="chamber_name" class="py-2">Select Chamber Name</label>
                                <select id="chamber_name" disabled name="chamber_name" class="form-control">
                                    <option value="">Select Chamber</option>
                                </select>
                                <span class="chamber_id text-danger"></span>
                            </div>
                            <div class="col-md-5 d-none Hospital_Name">
                                <label for="hospital_id" class="py-2">Select Hospital Name</label>
                                <select id="hospital_id" disabled name="hospital_id" class="form-control">
                                    <option value="">Select Hospital</option>
                                </select>
                                <span class="hospital_id text-danger"></span>
                            </div>
                            <div class="col-md-5 d-none Diagnostic_Name">
                                <label for="diagnostic_id" class="py-2">Select Diagnostic Name</label>
                                <select id="diagnostic_id" disabled name="diagnostic_id" class="form-control">
                                    <option value="">Select Diagnostic</option>
                                </select>
                                <span class="diagnostic_id text-danger"></span>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label for="appointment_date" class="py-2">Appointment Date</label>
                                    <input type="text" name="appointment_date" id="appointment_date" class="form-control" value="{{date('d-m-Y')}}">
                                    <span class="error-appointment_date error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label for="problem" class="py-2">Problem</label>
                                    <textarea name="problem" class="form-control" id="problem" placeholder="Decribe your problem"></textarea>
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

        function gethosdig(id, name, selector) {
            $.ajax({
                url: "{{route('filter.singlehospitaldiagnostic')}}",
                method: "POST",
                data: {
                    id: id,
                    name: name
                },
                beforeSend: () => {
                    $("#chamber_name").html(`<option value="">Select Chamber</option>`)
                    $("#diagnostic_id").html(`<option value="">Select Diagnostic</option>`)
                    $("#hospital_id").html(`<option value="">Select Hospital</option>`)
                },
                success: (response) => {
                    if (response.null) {} else {
                        $.each(response, (index, value) => {
                            if (value.null == 0) {
                                $(selector).append(`<option value="${value.id}">${value.name}</option>`)
                            } else {
                                $(selector).append(`<option value="${value.id}">${value.name}</option>`)
                            }
                        })
                    }
                }
            })
        }
        $("#changeName").on("change", (event) => {
            if (event.target.value == "chamber") {
                $(".Chamber_Name").removeClass("d-none");
                $(".Hospital_Name").addClass("d-none");
                $(".Diagnostic_Name").addClass("d-none");
                $("#chamber_name").attr("disabled", false);
                $("#diagnostic_id").attr("disabled", true);
                $("#hospital_id").attr("disabled", true);
                var id = $("#changeName").attr("data-id");
                gethosdig(id, event.target.value, "#chamber_name")
            } else if (event.target.value == "hospital") {
                $(".Chamber_Name").addClass("d-none");
                $(".Hospital_Name").removeClass("d-none");
                $(".Diagnostic_Name").addClass("d-none");
                $("#chamber_name").attr("disabled", true);
                $("#diagnostic_id").attr("disabled", true);
                $("#hospital_id").attr("disabled", false);
                var id = $("#changeName").attr("data-id");
                gethosdig(id, event.target.value, "#hospital_id")
            } else if (event.target.value == "diagnostic") {
                $(".Chamber_Name").addClass("d-none");
                $(".Hospital_Name").addClass("d-none");
                $(".Diagnostic_Name").removeClass("d-none");
                $("#chamber_name").attr("disabled", true);
                $("#diagnostic_id").attr("disabled", false);
                $("#hospital_id").attr("disabled", true);
                var id = $("#changeName").attr("data-id");
                gethosdig(id, event.target.value, "#diagnostic_id")
            } else {
                $(".Chamber_Name").addClass("d-none");
                $(".Hospital_Name").addClass("d-none");
                $(".Diagnostic_Name").addClass("d-none");
                $("#chamber_name").attr("disabled", true);
                $("#diagnostic_id").attr("disabled", true);
                $("#hospital_id").attr("disabled", true);
            }
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

            var contact = $("#Appointment").find("#contact").val()
            if (!Number(contact)) {
                $("#Appointment").find(".error-contact").text("Must be a number value")
                return;
            }
            var changeName = $("#Appointment").find("#changeName").val()
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('appointment')}}",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#Appointment").find(".error").text("");
                    $("#Appointment").find(".chamber_id").text("");
                    $("#Appointment").find(".hospital_id").text("");
                    $("#Appointment").find(".diagnostic_id").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#Appointment").find(".error-" + index).text(value);
                        })
                    } else if (response.errors) {
                        if (changeName === "chamber") {
                            $("#Appointment").find(".chamber_id").text("Select Chamber Name")
                        } else if (changeName === "hospital") {
                            $("#Appointment").find(".hospital_id").text("Select Hospital Name")
                        } else {
                            $("#Appointment").find(".diagnostic_id").text("Select Diagnostic Name")
                        }
                    } else {
                        $("#Appointment").trigger('reset')
                        DoctorAppointmentClose()
                        $.notify(response, "success");
                        Swal.fire(
                            'Thanks your Appointment!',
                            '?????????????????????????????? ??????????????? ?????????????????? ???????????? ??????????????????????????? ??????????????? ???????????? ????????????????????? ???????????????',
                            'success'
                        )
                        $(".Chamber_Name").addClass("d-none");
                        $(".Hospital_Name").addClass("d-none");
                        $(".Diagnostic_Name").addClass("d-none");
                        $("#chamber_name").attr("disabled", true);
                        $("#diagnostic_id").attr("disabled", true);
                        $("#hospital_id").attr("disabled", true);
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
        concentration.style.overflow = "scroll"
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
        description.style.overflow = "scroll"
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