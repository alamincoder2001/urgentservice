@extends("layouts.master")
@push("js")
<style>
    .diagnosticbody .card .discount {
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

    .diagnostic_city {
        text-decoration: none;
        display: block;
        list-style: none;
        padding: 3px;
        font-family: auto;
        border-bottom: 1px dashed #d1d1d1;
        color: #626262;
        transition: 2ms ease-in-out;
    }

    .diagnostic_city:hover {
        color: red !important;
    }
</style>
@endpush
@section("content")
<section id="details-diagnostic" style="padding: 25px 0;">
    <div class="container">
        <div class="doctordetail-header mb-3">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-10 col-10">
                    <form id="filterDiagnostic" class="form">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4 col-10">
                                <div class="form-group mb-4 mb-md-0">
                                    <label for="city" class="d-md-block d-none">City</label>
                                    <select class="rounded-pill city" name="city" id="city">
                                        <option label="Select City"></option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-city error text-white"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-10">
                                <div class="form-group">
                                    <label for="diagnostic_name" class="d-md-block d-none">Diagnostic Name</label>
                                    <select class="rounded-pill diagnostic" name="diagnostic_name" id="diagnostic_name">
                                        <option label="Select Diagnostic Name"></option>
                                    </select>
                                    <span class="error-diagnostic_name error text-white"></span>
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

        <div class="row m-lg-0" style="border: 1px solid #e5e5e5;">
            <div class="col-12 col-lg-3 p-lg-0">
                <div class="card border-0" style="border-radius: 0;height:100%;border-right: 1px solid #e3e3e3 !important;">
                    <div class="card-header" style="border: none;border-radius: 0;background: #e3e3e3;">
                        <h6 class="card-title text-uppercase m-0" style="color:#832a00;">City List</h6>
                    </div>
                    <div class="card-body" style="padding-top: 3px;">
                        <div style="height: 600px;overflow-y: scroll;">
                            <a title="All" href="{{route('diagnostic.details')}}" class="diagnostic_city {{$city_id != null ? '' : 'text-danger'}}">All</a>
                            @foreach($cities as $item)
                            <a title="{{$item->name}}" href="{{route('diagnostic.details', $item->id)}}" class="diagnostic_city {{$city_id != null ? $city_id == $item->id ? 'text-danger': '' : ''}}">{{$item->name}} <span class="text-danger" style="font-weight:700;">({{$item->diagnostic->count()}})</span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9 doctor_details">
                <h5 class="m-0 totalDoctorcount" style="text-align: right;font-family: auto;font-style: italic;">Total: <span>{{$total_diagnostic}}</span></h5>
                <div class="row py-2 diagnosticbody">

                    @foreach($data['diagnostic'] as $item)
                    <div class="col-12 col-lg-6 mb-3">
                        <a href="{{route('singlepagediagnostic', $item->id)}}" target="_blank" class="text-decoration-none text-secondary" title="{{$item->name}}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex position-relative" style="padding: 5px;gap: 8px;">
                                    @if($item->discount_amount != 0)
                                    <p style="position: absolute;bottom: 5px;right: 10px;" class="m-0 text-danger">সকল প্রকার সার্ভিসের উপরে <span class="text-decoration-underline">{{$item->discount_amount}}%</span> ছাড়।</p>
                                    @endif
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="{{asset($item->image != '0' ? $item->image:'/frontend/img/diagnostic.png')}}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>{{$item->name}}</h6>
                                        <p class="text-capitalize" style="color:#c99913;">{{$item->diagnostic_type}}, {{$item->city->name}}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> {{$item->address}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach

                    {{$data['diagnostic']->links('vendor.pagination.simple-bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push("js")
<script>
    $(document).ready(() => {
        $(".city").select2({
            placeholder: "Select city"
        });
        $(".diagnostic").select2({
            placeholder: "Select Diagnostic Name"
        });

        $("#city").on("change", (event) => {
            $.ajax({
                url: "{{route('filter.city')}}",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: event.target.value,
                    diagnostic: 'diagnostic'
                },
                beforeSend: () => {
                    $("#diagnostic_name").html(`<option value="">Select Diagnostic Name</option>`)
                },
                success: (response) => {
                    if (response.null) {} else {
                        $.each(response, (index, value) => {
                            var row = `<option value="${value.name}">${value.name}</option>`;
                            $("#diagnostic_name").append(row)
                        })
                    }
                }
            })
        })

        function Row(index, value) {
            var row = `
                    <div class="col-12 col-lg-6 mb-3">
                        <a href="/single-details-diagnostic/${value.id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="${value.image != '0' ?'/'+value.image: '/frontend/img/diagnostic.png'}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>${value.name}</h6>
                                        <p class="text-capitalize" style="color:#c99913;">${value.diagnostic_type}, ${value.city.name}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> ${value.address}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
            $(".diagnosticbody").append(row)

        }

        function Error(err) {
            $.each(err, (index, value) => {
                $("#filterDiagnostic").find(".error-" + index).text(value)
            })
        }

        $("#filterDiagnostic").on("submit", (event) => {
            event.preventDefault();
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('filter.diagnostic')}}",
                method: "POST",
                dataType: "JSON",
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#filterDiagnostic").find(".error").text("")
                    $(".Loading").removeClass("d-none")
                    $(".diagnosticbody").html("")
                },
                success: (response) => {
                    if (response.error) {
                        $(".diagnosticbody").html(`<div class="col-12 bg-dark text-white text-center">Not Found Data</div>`)
                        Error(response.error);
                    } else {
                        if (response.null) {
                            $(".diagnosticbody").html(`<div class="bg-dark text-white text-center">${response.null}</div>`)
                        } else {
                            $.each(response, (index, value) => {
                                Row(index, value)
                            })
                        }
                    }
                },
                complete: () => {
                    $(".Loading").addClass("d-none")
                }
            })
        })
    })
</script>
@endpush