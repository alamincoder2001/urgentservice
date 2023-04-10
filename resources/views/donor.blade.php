@extends("layouts.master")

@push('style')
<style>
    .donor_city {
        text-decoration: none;
        display: block;
        list-style: none;
        padding: 3px;
        font-family: auto;
        border-bottom: 1px dashed #d1d1d1;
        color: #626262;
        transition: 2ms ease-in-out;
    }

    .donor_city:hover {
        color: red !important;
    }
</style>
@endpush

@section("content")
<section id="donorlist" style="padding: 55px 0;">
    <div class="container" style="position: relative;">
        <div class="input-group" style="padding:8px;border-radius: 0;box-shadow: none;position: absolute;top: -55px;right: 10px;background: #283290;width: 135px;">
            <input type="checkbox" id="showAddDonor" class="me-2"> <label class="text-white text-uppercase" style="cursor: pointer" for="showAddDonor">Donor Add</label>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center mb-5">
            <div class="col-md-12" id="showDonor" class="d-none">
                <div class="d-none" id="maindonor" style="background: #283290;padding: 35px;">
                    <form id="formDonor" class="text-white">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="name">Donor Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" style="box-shadow: none;border-radius:0;">
                                    <span class="error-name error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="phone">Donor Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" style="box-shadow: none;border-radius:0;">
                                    <span class="error-phone error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="dob">Date of Birth</label>
                                    <input type="text" name="dob" id="dob" class="form-control datepicker" autocomplete="off" placeholder="dd-mm-YY" style="box-shadow: none;border-radius:0;">
                                    <span class="error-dob error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="email">Donor Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Nullable" style="box-shadow: none;border-radius:0;">
                                    <span class="error-email error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control" placeholder="Nullable" style="box-shadow: none;border-radius:0;">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select>
                                    <span class="error-gender error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="blood_group">Blood Group</label>
                                    <select name="blood_group" id="blood_group" class="form-control" placeholder="Nullable" style="box-shadow: none;border-radius:0;">
                                        <option value="">Select Blood Group</option>
                                        @foreach($bloodgroup as $item)
                                        <option value="{{$item->id}}">{{$item->blood_group}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-blood_group error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="city_id">City Name</label>
                                    <select name="city_id" id="city_id" class="form-control" style="box-shadow: none;border-radius:0;">
                                        <option value="">Select city name</option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-city_id error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" style="box-shadow: none;border-radius:0;height:10px;"></textarea>
                                    <span class="error-address error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="image">Donor Image</label>
                                    <input type="file" class="form-control" name="image" id="image" style="box-shadow: none;border-radius:0;">
                                    <span class="error-image error text-warning"></span>
                                    <i>Not Fillable this Field</i>
                                </div>
                            </div>
                            <div class="form-group text-center mt-1">
                                <button type="submit" class="btn border-0" style="background: green;border-radius: 0;color: white;">Save Donor</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row m-lg-0" style="border: 1px solid #e5e5e5;">
            <div class="col-12 col-lg-3 p-lg-0">
                <div class="card border-0" style="border-radius: 0;height:100%;border-right: 1px solid #e3e3e3 !important;">
                    <div class="card-header" style="border: none;border-radius: 0;background: #e3e3e3;">
                        <h6 class="card-title text-uppercase m-0" style="color:#832a00;">Blood Group List</h6>
                    </div>
                    <div class="card-body" style="padding-top: 3px;">
                        <a title="All" href="{{route('donor')}}" class="donor_city {{$blood_group != null ? '' : 'text-danger'}}">All</a>
                        @foreach($bloodgroup as $item)
                        <a title="{{$item->blood_group}}" href="{{route('donor', ['blood-group', 'id' => $item->id])}}" class="donor_city {{$blood_group == $item->id ? 'text-danger': ''}}">{{$item->blood_group}} <span class="text-danger" style="font-weight:700;">({{$item->donor->count()}})</span></a>
                        @endforeach

                        <!-- city list -->
                        <div class="mt-5" style="border: none;border-radius: 0;background: #e3e3e3;padding:7px;">
                            <h6 class="title text-uppercase m-0" style="color:#832a00;">City List</h6>
                        </div>
                        <div style="height: 400px;overflow-y: scroll;">
                            @foreach($cities as $item)
                            <a title="{{$item->name}}" href="{{route('donor', ['city', 'id' => $item->id])}}" class="donor_city {{$item->id == $city_id ? 'text-danger' : ''}}">{{$item->name}} <span class="text-danger" style="font-weight:700;">({{$item->donor->count()}})</span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9 doctor_details">
                <h5 class="m-0 totalDoctorcount" style="text-align: right;font-family: auto;font-style: italic;">Total: <span>{{$data->count()}}</span></h5>
                <div class="row py-2 donorbody">

                    @foreach($data as $item)
                    <div class="col-12 col-lg-6 mb-3">
                        <a href="" class="text-decoration-none text-secondary" title="{{$item->name}}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="{{asset($item->image != '0' ? $item->image:'/uploads/nouserimage.png')}}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>{{$item->name}}</h6>
                                        <p style="color:#c99913;"><i class="fa fa-phone"></i> {{$item->phone}}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-tint text-danger"></i> {{$item->group->blood_group}}</p>
                                        <p class="m-0"><i class="fa fa-map-marker"></i> {{mb_strimwidth($item->address, 0, 100, "...")}}, {{$item->city->name}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push("js")
<script>
    $("#showAddDonor").on("click", event => {
        if (event.target.checked) {
            $("#showDonor").removeClass("d-none").animate({
                height: "350px",
                padding: "10px"
            });
            $("#maindonor").removeClass("d-none");
        } else {
            $("#showDonor").animate({
                height: "0",
                padding: "0"
            });
            $("#maindonor").addClass("d-none");
        }
    })

    $("#formDonor").on("submit", event => {
        event.preventDefault()
        var formdata = new FormData(event.target)
        $.ajax({
            url: "{{route('donor.store')}}",
            method: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $("#formDonor").find(".error").text("")
            },
            success: response => {
                if (response.error) {
                    $.each(response.error, (index, value) => {
                        $("#formDonor").find(".error-" + index).text(value)
                    })
                } else {
                    $("#formDonor").trigger("reset");
                    $.notify(response, "success");
                    setTimeout(function() {
                        location.reload();
                    }, 500)
                }
            }
        })
    })

    function GroupwiseDonor(event, val) {
        let formdata;
        if (val == 'group') {
            formdata = {
                group: event.target.value
            }
        } else {
            formdata = {
                city: event.target.value
            }
        }
        $.ajax({
            url: "{{route('filter.donor')}}",
            method: "POST",
            dataType: "JSON",
            data: formdata,
            beforeSend: () => {
                $(".groupWiseDonorShow").html("")
                $(".Loading").removeClass("d-none")
            },
            success: response => {
                if (!response.null) {
                    $.each(response, (index, value) => {
                        let row = `
                                <div class="col-md-2 col-lg-2 col-12 mb-2">
                                    <div style="height:250px;" class="card" title="${value.name}">
                                        <div class="card-header p-0" style="background: 0;">
                                            <img style="width: 100%; height:110px;padding:6px;" src="${value.image > '0'?location.origin+"/"+value.image:"/uploads/nouserimage.png"}" class="card-img-top">
                                        </div>
                                        <div class="card-body py-1">
                                            <p><span style="font-weight:500;">Name:</span> ${value.name}</p>
                                            <p><span style="font-weight:500;">Blood Group:</span> ${value.group.blood_group}</p>
                                            <p><span style="font-weight:500;">Phone:</span> ${value.phone}</p>
                                            <p><span style="font-weight:500;">Gender:</span> ${value.gender.charAt().toUpperCase()+value.gender.slice(1)}</p>
                                            <p><span style="font-weight:500;">Address: </span>${value.address}, ${value.city.name}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        $(".groupWiseDonorShow").append(row)
                    })
                } else {
                    let row = `
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>${response.null}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    $(".groupWiseDonorShow").html(row)
                }
            },
            complete: () => {
                $(".Loading").addClass("d-none")
            }
        })
    }

    function changeOptions(event) {
        if (event.target.value == 'group') {
            $(".Group").removeClass("d-none");
            $(".City").addClass("d-none");
        } else if (event.target.value == 'city') {
            $(".Group").addClass("d-none");
            $(".City").removeClass("d-none");
        } else {
            GroupwiseDonor(event, 'city');
            $(".Group").addClass("d-none");
            $(".City").addClass("d-none");
        }
    }
</script>
@endpush