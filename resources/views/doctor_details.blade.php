@extends("layouts.master")
@push("style")
<style>
    /* =========== doctor card design ============ */
    .doctor_department {
        text-decoration: none;
        display: block;
        list-style: none;
        padding: 3px;
        font-family: auto;
        border-bottom: 1px dashed #d1d1d1;
        color: #626262;
        transition: 2ms ease-in-out;
    }

    .doctor_department:hover {
        color: red !important;
    }
</style>
@endpush
@section("content")
<section id="doctor-details">
    <div class="container">
        <div class="doctordetail-header mb-3">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-10 col-10">
                    <form id="filterDoctor" class="form">
                        <div class="row justify-content-center d-flex">
                            <div class="col-md-3 col-10">
                                <div class="form-group mb-4 mb-md-0">
                                    <label for="city" class="d-md-block d-none">City</label>
                                    <select class="rounded-pill city" name="city" id="city">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-10">
                                <div class="form-group mb-4 mb-md-0">
                                    <label for="department" class="d-md-block d-none">Department</label>
                                    <select class="rounded-pill department" name="department" id="department">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-10">
                                <div class="form-group doctor_name">
                                    <label for="doctor_name" class="d-md-block d-none">Doctor Name</label>
                                    <input type="text" name="doctor_name" id="doctor_name" class="form-control" style="height: 33px;border-radius: 2rem;background: black;border: 0;box-shadow: none;color: #a3a3a3;padding-left: 18px;padding-top: 3px;">
                                    <span class="error-doctor_name error text-white"></span>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group text-center">
                                    <label for="country"></label>
                                    <button class="btn text-white rounded-pill">Search</button>
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
                        <h6 class="card-title text-uppercase m-0" style="color:#832a00;">Department List</h6>
                    </div>
                    <div class="card-body" style="padding-top: 3px;">
                        <div style="height: 600px;overflow-y: scroll;">
                            <a href="{{route('doctor.details')}}" class="doctor_department {{$department == null ? 'text-danger' : ''}}">All</a>
                            @foreach($departments as $item)
                            <a title="{{$item->name}}" href="{{route('doctor.details',['department', 'name' => strtolower($item->name)])}}" class="doctor_department {{strtolower($item->name) == strtolower($department) ? 'text-danger' : ''}}">{{mb_strimwidth($item->name, 0, 28, "...")}} <span class="text-danger" style="font-weight:700;">({{$item->specialistdoctor->count()}})</span></a>
                            @endforeach
                        </div>

                        <!-- city list -->
                        <div class="mt-5" style="border: none;border-radius: 0;background: #e3e3e3;padding:7px;">
                            <h6 class="title text-uppercase m-0" style="color:#832a00;">City List</h6>
                        </div>
                        <div style="height: 400px;overflow-y: scroll;">
                            @foreach($cities as $item)
                            <a title="{{$item->name}}" href="{{route('doctor.details',['city', 'id' => $item->id])}}" class="doctor_department {{$item->id == $city_id ? 'text-danger' : ''}}">{{$item->name}} <span class="text-danger" style="font-weight:700;">({{$item->doctor->count()}})</span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 doctor_details">
                <h5 class="m-0 totalDoctorcount" style="text-align: right;font-family: auto;font-style: italic;">Total: <span>{{\App\Models\Doctor::all()->count()}}</span></h5>
                <div class="row py-2 doctorbody">

                    @foreach($data['specialist'] as $item)
                    <div class="col-md-6 mb-3">
                        <a href="{{route('singlepagedoctor', $item->doctor->id)}}" target="_blank" class="text-decoration-none text-secondary" title="{{$item->doctor->name}}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;overflow:hidden;">
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

                    @if($city_id == null)
                    {{$data['specialist']->links('vendor.pagination.simple-bootstrap-4')}}
                    @endif
                </div>
            </div>
        </div>

    </div>

</section>
@endsection

@push("js")
<script>
    $("#filterDoctor").on("submit", event => {
        event.preventDefault()
        var formdata = new FormData(event.target)
        $.ajax({
            url: "{{route('filter.doctor')}}",
            method: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $("#filterDoctor").find(".error").text("")
                $(".doctorbody").html("")
                $(".Loading").removeClass("d-none")
            },
            success: res => {
                if (res.status == true && res.message.length == 0) {
                    $(".totalDoctorcount span").text(res.message.length)
                    $(".doctorbody").html(`<div class="bg-dark text-white text-center">Not Found Data</div>`)
                } else if (res.status == true) {
                    $(".totalDoctorcount span").text(res.message.length)
                    $.each(res.message, (index, value) => {
                        Row(index, value)
                    })
                } else {
                    $(".doctorbody").html(`<div class="bg-dark text-white text-center">Not Found Data</div>`)
                }
            },
            complete: () => {
                $(".Loading").addClass("d-none")
            }
        })
    })

    function Row(index, value) {
        var row = `
                <div class="col-md-6 mb-3">
                    <a href="/single-details-doctor/${value.doctor_id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                        <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;overflow:hidden;">
                            <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                    <img height="100%" src="${value.image != '0'?value.image:'/uploads/nouserimage.png'}" width="100">
                                </div>
                                <div class="info" style="padding-right:5px;">
                                    <h6>${value.name}</h6>
                                    <p style="color:#c99913;">${value.department_name}, ${value.city_name}</p>
                                    <p style="border-top: 2px dashed #dddddd85;text-align:justify;">${value.education}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                    `;
        $(".doctorbody").append(row)
    }
</script>
@endpush