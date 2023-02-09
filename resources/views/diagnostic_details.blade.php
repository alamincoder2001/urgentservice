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
        
        <div class="row d-flex justify-content-center diagnosticbody">
            @foreach($data["diagnostic"] as $item)
            <div class="col-md-6 col-10 col-sm-6 col-lg-4">
                <a style="text-decoration: none;" target="_blank" href="{{route('singlepagediagnostic', $item->id)}}">
                    <div class="card border-0 mb-4" style="height:360px;background: #ffffff;box-shadow:0px 0px 5px 1px #c1c1c1;" title="{{$item->name}}">
                        <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                            <img src="{{asset($item->image ? $item->image:'/frontend/img/hospital.png' )}}" style="width: 100%; height:100%;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center text-uppercase text-dark" style="font-size: 15px;">{{mb_strimwidth($item->name, 0, 30, "...")}}</h5>
                            <p class="card-text text-primary text-center mb-2"><span>{{ucwords($item->diagnostic_type)}} Diagnostic Centre</span> | <span>{{$item->phone}}</span></p>
                            <ul style="list-style: none;padding:0 0 0 5px;">
                                <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span class="text-dark" style="font-size: 11px;">{{$item->address}}, {{$item->city->name}}</span></li>
                                <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span class="text-dark" style="font-size: 13px;">{{$item->email}}</span></li>
                            </ul>
                        </div>
                        <div class="card-footer text-center text-white text-uppercase border-0 py-3">
                            View Details
                        </div>
                        @if($item->discount_amount != 0)
                        <div class="discount">-{{$item->discount_amount}}%</div>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach

            {{$data['diagnostic']->links('vendor.pagination.simple-bootstrap-4')}}
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
                <div class="col-md-6 col-10 col-sm-6 col-lg-4 ">
                    <a class="text-decoration-none" target="_blank" href="${'/single-details-diagnostic/'+value.id}">
                        <div class="card border-0 mb-4" style="height:360px;background: #ffffff;box-shadow:0px 0px 5px 1px #c1c1c1;" title="${value.name}">
                            <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                                <img src="${value.image != '0'?location.origin+'/'+value.image:location.origin+'/frontend/img/hospital.png'}" style="width: 100%; height:100%;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-uppercase text-center text-dark" style="font-size: 15px;">${value.name}</h5>
                                <p class="card-text text-primary text-center mb-2"><span>${value.diagnostic_type.toUpperCase()}</span> | <span>${value.phone}</span></p>
                                <ul style="list-style: none;padding:0 0 0 5px;">
                                    <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span class="text-dark" style="font-size: 11px;">${value.address}, ${value.city.name}</span></li>
                                    <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span class="text-dark" style="font-size: 13px;">${value.email}</span></li>
                                </ul>
                            </div>                        
                            <div class="card-footer text-white text-center text-uppercase border-0 py-3">
                                View Details
                            </div>
                            ${value.discount_amount!=0?"<div class='discount'>-"+value.discount_amount+"%</div>":""}
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