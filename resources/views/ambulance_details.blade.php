@extends("layouts.master")
@push('style')
<style>
    .ambulance_category {
        text-decoration: none;
        display: block;
        list-style: none;
        padding: 3px;
        font-family: auto;
        border-bottom: 1px dashed #d1d1d1;
        color: #626262;
        transition: 2ms ease-in-out;
    }

    .ambulance_category:hover {
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
                    <form id="filterAmbulance" class="form">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3 col-10">
                                <div class="form-group mb-4 mb-md-0">
                                    <label for="city" class="d-md-block d-none">City</label>
                                    <select class="rounded-pill" name="city" id="city">
                                        <option label="Select City"></option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-10">
                                <div class="form-group">
                                    <label for="ambulance_type" class="d-md-block d-none">Type Of Ambulance</label>
                                    <select class="rounded-pill" name="ambulance_type" id="ambulance_type">
                                        <option label="Select Ambulance Type"></option>
                                        <option value="ICU">ICU Ambulance</option>
                                        <option value="NICU">Non ICU Ambulance</option>
                                        <option value="Freezing">Freezing Ambulance</option>
                                        <option value="AC">AC Ambulance</option>
                                        <option value="NON-AC">Non AC Ambulance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-10">
                                <div class="form-group">
                                    <label for="ambulance_name" class="d-md-block d-none">Ambulance Name</label>
                                    <input type="text" name="ambulance_name" id="ambulance_name" autocomplete="off" class="form-control" style="height: 33px;border-radius: 2rem;background: black;border: 0;box-shadow: none;color: #a3a3a3;padding-left: 18px;padding-top: 3px;">
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group text-center pt-1">
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
                        <h6 class="card-title text-uppercase m-0" style="color:#832a00;">Type Of Ambulance List</h6>
                    </div>
                    <div class="card-body" style="padding-top: 3px;">
                        <a title="All" href="{{route('ambulance.details')}}" class="ambulance_category {{$type != null ? '' : 'text-danger'}}">All</a>
                        @foreach($data['ambulance_types'] as $item)
                        <a title="{{$item->ambulance_type}}" href="{{route('ambulance.details', ['type', 'type_name' => $item->ambulance_type])}}" class="ambulance_category {{$type != null ? $type == $item->ambulance_type ? 'text-danger': '' : ''}}">{{$item->ambulance_type}} <span class="text-danger" style="font-weight:700;">({{\App\Models\Ambulance::TotalTypeWiseAmbulance($item->ambulance_type)}})</span></a>
                        @endforeach

                        <!-- city list -->
                        <div class="mt-5" style="border: none;border-radius: 0;background: #e3e3e3;padding:7px;">
                            <h6 class="title text-uppercase m-0" style="color:#832a00;">City List</h6>
                        </div>
                        <div style="height: 400px;overflow-y: scroll;">
                            @foreach($cities as $item)
                            <a title="{{$item->name}}" href="{{route('ambulance.details',['city', 'id' => $item->id])}}" class="ambulance_category {{$item->id == $city_id ? 'text-danger' : ''}}">{{$item->name}} <span class="text-danger" style="font-weight:700;">({{$item->ambulance->count()}})</span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 doctor_details">
                <h5 class="m-0 totalDoctorcount" style="text-align: right;font-family: auto;font-style: italic;">Total: <span>{{$data['ambulance']->count()}}</span></h5>
                <div class="row py-2 ambulancebody">
                    @foreach($data['ambulance'] as $item)
                    <div class="col-md-6 mb-3">
                        <a href="{{route('singlepageambulance', $item->id)}}" target="_blank" class="text-decoration-none text-secondary" title="{{$item->name}}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="{{asset($item->image != '0' ? $item->image:'/frontend/img/ambulance.png')}}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>{{$item->name}}</h6>
                                        <p style="color:#c99913;">{{$item->ambulance_type}}, {{$item->city->name}}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> {{mb_strimwidth($item->address, 0, 100, "...")}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach

                    {{$data['ambulance']->links('vendor.pagination.simple-bootstrap-4')}}
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
                        <a href="/single-details-ambulance/${value.id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="${value.image != '0' ? value.image:'/frontend/img/ambulance.png'}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>${value.name}</h6>
                                        <p style="color:#c99913;">${value.ambulance_type}, ${value.city_name}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> ${value.address}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            `;
        $(".ambulancebody").append(row)

    }

    $("#filterAmbulance").on("submit", event => {
        event.preventDefault();
        var formdata = new FormData(event.target)
        $.ajax({
            url: "{{route('filter.ambulance')}}",
            method: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $(".Loading").removeClass("d-none")
                $(".ambulancebody").html("")
            },
            success: res => {
                if (res.status == true && res.message.length == 0) {
                    $(".totalDoctorcount").find("span").text(res.message.length)
                    $(".ambulancebody").html(`<div class="bg-dark text-white text-center">Not found Data</div>`)
                } else if (res.status == true) {
                    $(".totalDoctorcount").find("span").text(res.message.length)
                    $.each(res.message, (index, value) => {
                        Row(index, value)
                    })
                } else {
                    $(".ambulancebody").html(`<div class="bg-dark text-white text-center">${res.message}</div>`)
                }
            },
            complete: () => {
                $(".Loading").addClass("d-none")
            }
        })
    })
</script>
@endpush