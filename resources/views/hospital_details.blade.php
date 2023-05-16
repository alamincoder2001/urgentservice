@extends("layouts.master")
@push("js")
<style>
    .hospitalbody .card .discount {
        position: absolute;
        left: 0;
        background: red;
        padding: 5px;
        color: white;
        border-radius: 100%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
    }

    .hospital_city {
        text-decoration: none;
        display: block;
        list-style: none;
        padding: 3px;
        font-family: auto;
        border-bottom: 1px dashed #d1d1d1;
        color: #626262;
        transition: 2ms ease-in-out;
    }

    .hospital_city:hover {
        color: red !important;
    }
</style>
@endpush
@section("content")
<section id="doctor-details" style="padding: 25px 0;">
    <div class="container">
        <div class="doctordetail-header mb-3">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-10 col-10">
                    <form id="formHospital" class="form">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4 col-10 col-sm-10">
                                <div class="form-group mb-4 mb-md-0">
                                    <label for="city" class="d-md-block d-none">City</label>
                                    <select name="city" id="city" class="rounded-pill city">
                                        <option label="Select City"></option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-city error text-white"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-10 col-sm-10">
                                <div class="form-group">
                                    <label for="hospital_name" class="d-md-block d-none">Hospital Name</label>
                                    <input type="text" name="hospital_name" id="hospital_name" class="form-control" autocomplete="off" style="height: 33px;border-radius: 2rem;background: black;border: 0;box-shadow: none;color: #a3a3a3;padding-left: 18px;padding-top: 3px;">
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-group text-center mt-1">
                                    <label for="country"></label>
                                    <button type="submit" class="btn text-white rounded-pill">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row m-md-0" style="border: 1px solid #e5e5e5;">
            <div class="col-md-3 p-md-0 order-md-0 order-last">
                <div class="card border-0" style="border-radius: 0;height:100%;border-right: 1px solid #e3e3e3 !important;">
                    <div class="card-header" style="border: none;border-radius: 0;background: #e3e3e3;">
                        <h6 class="card-title text-uppercase m-0" style="color:#832a00;">City List</h6>
                    </div>
                    <div class="card-body" style="padding-top: 3px;">
                        <div style="height: 600px;overflow-y: scroll;">
                            <a title="All" href="{{route('hospital.details')}}" class="hospital_city {{$city_id != null ? '' : 'text-danger'}}">All</a>
                            @foreach($cities as $item)
                            <a title="{{$item->name}}" href="{{route('hospital.details', $item->id)}}" class="hospital_city {{$city_id != null ? $city_id == $item->id ? 'text-danger': '' : ''}}">{{$item->name}} <span class="text-danger" style="font-weight:700;">({{$item->hospital->count()}})</span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 doctor_details">
                <h5 class="m-0 totalDoctorcount" style="text-align: right;font-family: auto;font-style: italic;">Total: <span>{{$total_hospital}}</span></h5>
                <div class="row py-2 hospitalbody">

                    @foreach($data['hospital'] as $item)
                    <div class="col-md-6 mb-3">
                        <a href="{{route('singlepagehospital', $item->id)}}" target="_blank" class="text-decoration-none text-secondary" title="{{$item->name}}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex position-relative" style="padding: 5px;gap: 8px;">
                                    @if($item->discount_amount != 0)
                                    <p style="position: absolute;bottom: 5px;right: 10px;" class="m-0 text-danger">সকল প্রকার সার্ভিসের উপরে <span class="text-decoration-underline">{{$item->discount_amount}}%</span> ছাড়।</p>
                                    @endif
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="{{asset($item->image != '0' ? $item->image:'/frontend/img/hospital.png')}}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>{{$item->name}}</h6>
                                        <p class="text-capitalize" style="color:#c99913;">{{$item->hospital_type}}, {{$item->city->name}}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> {{$item->address}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach

                    {{$data['hospital']->links('vendor.pagination.simple-bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push("js")
<script>
    function Row(index, value) {
        var row = `
                    <div class="col-md-6 mb-3">
                        <a href="/single-details-hospital/${value.id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex position-relative" style="padding: 5px;gap: 8px;">
                                    ${value.discount_amount > 0 ? '<p style="position: absolute;bottom: 5px;right: 10px;" class="m-0 text-danger">সকল প্রকার সার্ভিসের উপরে <span class="text-decoration-underline">'+value.discount_amount+'%</span> ছাড়।</p>':''}
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="${value.image != '0' ?'/'+value.image: '/frontend/img/hospital.png'}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>${value.name}</h6>
                                        <p class="text-capitalize" style="color:#c99913;">${value.hospital_type}, ${value.city_name}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> ${value.address}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
        $(".hospitalbody").append(row)

    }


    $("#formHospital").on("submit", (event) => {
        event.preventDefault();
        var formdata = new FormData(event.target)
        $.ajax({
            url: "{{route('filter.hospital')}}",
            method: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $("#formHospital").find(".error").text("")
                $(".Loading").removeClass("d-none")
                $(".hospitalbody").html("")
            },
            success: res => {
                if (res.status == true && res.message.length == 0) {
                    $(".totalDoctorcount").find("span").text(res.message.length)
                    $(".hospitalbody").html(`<div class="col-12 bg-dark text-white text-center">Not Found Data</div>`)
                } else if (res.status == true) {
                    $(".totalDoctorcount").find("span").text(res.message.length)
                    $.each(res.message, (index, value) => {
                        Row(index, value)
                    })
                } else {
                    $(".hospitalbody").html(`<div class="col-12 bg-dark text-white text-center">${res.message}</div>`)
                }
            },
            complete: () => {
                $(".Loading").addClass("d-none")
            }
        })
    })
</script>
@endpush