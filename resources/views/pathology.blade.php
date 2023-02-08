@extends("layouts.master")
@push("style")
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

    .contact-heading {
        background-image: url("{{asset('frontend')}}/img/contactus.jpg");
        background-size: 100% 100%;
        background-position: center;
        background-repeat: no-repeat;
        height: 235px;
    }

    #contact-us .contact-body i {
        font-size: 35px;
        font-weight: 900;
    }

    #contact-us .contact-body .fa-phone {
        color: #00aba3;
    }

    #contact-us .contact-body .fa-map-marker {
        color: #F60002;
    }

    #contact-us .contact-body .fa-envelope-o {
        color: #168BE4;
    }

    #contact-us .contact-body small {
        color: #8d8d8dcf;
    }
</style>
@endpush
@section("content")
@php
$data = App\Models\Test::orderBy("name")->get();
@endphp
<section id="contact-us">
    <div class="contact-heading d-flex align-items-center justify-content-start text-white" style="background: url('{{asset('frontend/img/pathology.jpg')}}');">
        <div class="container">
            <h2 class="text-uppercase text-dark">Pathology Section</h2>
        </div>
    </div>

    <div class="contact-form" style="background: #f3f3f3;">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-7 col-12 mb-3">
                    <div class="card p-3" style="background:#f5f5f5;box-shadow:1px 1px 1px 2px #1b6c93ba;">
                        <div class="card-header border-0 text-white" style="background: #035b64 !important;">
                            <h4 class="fs-6 text-uppercase">Appointment</h4>
                        </div>
                        <div class="card-body" id="appointment">
                            <form id="Appointment">
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
                                    <div class="col-12 col-lg-6">
                                        <label for="doctor">Select Doctor</label>
                                        <select class="form-control" name="doctor_id" id="doctorNamechange">
                                            <option value="">Select Doctor Name</option>
                                            @foreach($doctors as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-6 d-none changeSection">
                                        <div class="form-group">
                                            <label for="changeName" class="py-2">Select Chamber or Hospital or Diagnostic</label>
                                            <select id="changeName" name="changeName" class="form-control">
                                                <option value="">Select Name</option>
                                                <option value="chamber">Chamber</option>
                                                <option value="hospital">Hospital</option>
                                                <option value="diagnostic">Diagnostic</option>
                                            </select>
                                            <span class="error-changeName error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-none Chamber_Name">
                                        <label for="chamber_name" class="py-2">Select Chamber Name</label>
                                        <select id="chamber_name" disabled name="chamber_name" class="form-control">
                                            <option value="">Select Chamber</option>
                                        </select>
                                        <span class="chamber_id text-danger"></span>
                                    </div>
                                    <div class="col-md-6 d-none Hospital_Name">
                                        <label for="hospital_id" class="py-2">Select Hospital Name</label>
                                        <select id="hospital_id" disabled name="hospital_id" class="form-control">
                                            <option value="">Select Hospital</option>
                                        </select>
                                        <span class="hospital_id text-danger"></span>
                                    </div>
                                    <div class="col-md-6 d-none Diagnostic_Name">
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
                <div class="col-lg-5 col-12 mb-3">
                    <div class="card">
                        <div class="card-header border-0 text-white" style="background: #035b64 !important;">
                            <h4 class="fs-6 text-uppercase">Pathology List</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-sm">
                                </tr>
                                <thead>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>৳ {{$item->amount}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <form onsubmit="addPathology(event)">
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="d-flex" style="background: radial-gradient(#ffffffb8, #000000a1);width:100%;padding: 5px 8px;border-radius: 0.2rem;">
                                    <div style="width: 20%;display: flex;align-items: center;">
                                        <img src="{{asset('noimage.jpg')}}" class="img" width="100">
                                    </div>
                                    <div class="form-group py-2 py-md-3" style="width:80%">
                                        <label for="image" class="text-white">Prescription Image <span class="text-danger fs-4">*</span></label>
                                        <input type="file" class="form-control" name="image" id="image" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                                        <span class="error-image error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group py-2 py-md-3">
                                    <button type="submit" class="btn btn-outline-success shadow-none">Send Prescription</button>
                                </div>
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
    $("#appointment_date").datepicker({
        format: "dd-mm-yyyy",
        startDate: new Date(),
        orientation: 'bottom'
    })
    $("#doctorNamechange").on("change", event => {
        if (event.target.value) {
            $(".changeSection").removeClass("d-none")
        } else {
            $(".changeSection").addClass("d-none")
        }
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
            var id = $("#doctorNamechange option:selected").val();
            gethosdig(id, event.target.value, "#chamber_name")
        } else if (event.target.value == "hospital") {
            $(".Chamber_Name").addClass("d-none");
            $(".Hospital_Name").removeClass("d-none");
            $(".Diagnostic_Name").addClass("d-none");
            $("#chamber_name").attr("disabled", true);
            $("#diagnostic_id").attr("disabled", true);
            $("#hospital_id").attr("disabled", false);
            var id = $("#doctorNamechange option:selected").val();
            gethosdig(id, event.target.value, "#hospital_id")
        } else if (event.target.value == "diagnostic") {
            $(".Chamber_Name").addClass("d-none");
            $(".Hospital_Name").addClass("d-none");
            $(".Diagnostic_Name").removeClass("d-none");
            $("#chamber_name").attr("disabled", true);
            $("#diagnostic_id").attr("disabled", false);
            $("#hospital_id").attr("disabled", true);
            var id = $("#doctorNamechange option:selected").val();
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

    // appointment send
    $("#Appointment").on("submit", (event) => {
        event.preventDefault();

        var contact = $("#Appointment").find("#contact").val()
        if (!Number(contact)) {
            $("#Appointment").find(".error-contact").text("Must be a number value")
            return;
        }
        if ($("#doctorNamechange option:selected").val() == "") {
            alert("select doctor name")
            return
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
                    $.notify(response, "success");
                    Swal.fire(
                        'Thanks your Appointment!',
                        'কিছুক্ষণের মধ্যে আমাদের একজন প্রতিনিধী আপনার সাথে যোগাযোগ করবে।',
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

    function addPathology(event) {
        event.preventDefault();
        var formdata = new FormData(event.target)
        $.ajax({
            url: location.origin + "/send-prescription",
            method: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $(".error").text("");
            },
            success: res => {
                if (res.error) {
                    $.each(res.error, (index, value) => {
                        $(".error-" + index).text(value)
                    })
                } else {
                    $.notify(res, "success")
                    $(".img").prop("src", location.origin + "/noimage.jpg")
                }
            }
        })
    }
</script>
@endpush