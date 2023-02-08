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
</style>
@endpush
@section("content")
<section id="hospital-details" style="padding: 25px 0;">
    <div class="container">
        <div class="doctordetail-header mb-2">
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
                                    <select name="hospital_name" id="hospital_name" class="rounded-pill hospital">
                                        <option label="Select Hospital Name"></option>
                                    </select>
                                    <span class="error-hospital_name error text-white"></span>
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
    </div>

    <div class="container">
        <div class="row d-flex justify-content-center hospitalbody">
            @foreach($data['hospital'] as $item)
            <div class="col-md-6 col-10 col-sm-6 col-lg-4 ">
                <a style="text-decoration: none;" target="_blank" href="{{route('singlepagehospital', $item->id)}}">
                    <div class="card border-0 mb-4" style="height:360px;background: #ffffff;box-shadow:0px 0px 5px 1px #c1c1c1;" title="{{$item->name}}">
                        <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                            <img style="width: 100%; height:100%;" src="{{asset($item->image ? $item->image:'/frontend/img/hospital.png' )}}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-uppercase text-center text-dark" style="font-size: 15px;">{{mb_strimwidth($item->name, 0, 30, "...")}}</h5>
                            <p class="card-text text-primary text-center mb-2"><span>{{ucwords($item->hospital_type)}}</span> | <span>{{$item->phone}}</span></p>
                            <ul style="list-style: none;padding:0 0 0 5px;">
                                <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span class="text-dark" style="font-size: 11px;">{{$item->address}}, {{$item->city->name}}</span></li>
                                <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span class="text-dark" style="font-size: 13px;">{{$item->email}}</span></li>
                            </ul>
                        </div>
                        <div class="text-white card-footer text-uppercase border-0 text-center py-3">
                            View Details
                        </div>
                        @if($item->discount_amount != 0)
                        <div class="discount">-{{$item->discount_amount}}%</div>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach

            {{$data['hospital']->links('vendor.pagination.simple-bootstrap-4')}}
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
        $(".hospital").select2({
            placeholder: "Select Hospital Name"
        });

        $("#city").on("change", (event) => {
            $.ajax({
                url: "{{route('filter.city')}}",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: event.target.value,
                    hospital: 'hospital'
                },
                beforeSend: () => {
                    $("#hospital_name").html(`<option value="">Select Hospital Name</option>`)
                },
                success: (response) => {
                    if (response.null) {} else {
                        $.each(response, (index, value) => {
                            var row = `<option value="${value.name}">${value.name}</option>`;
                            $("#hospital_name").append(row)
                        })
                    }
                }
            })
        })

        function Row(index, value) {
            var row = `
                <div class="col-md-6 col-10 col-sm-6 col-lg-4 ">
                    <a class="text-decoration-none" target="_blank" href="${'/single-details-hospital/'+value.id}">
                        <div class="card border-0 mb-4" style="height:360px;background: #ffffff;box-shadow:0px 0px 5px 1px #c1c1c1;" title="${value.name}">
                            <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                                <img src="${value.image != '0'?location.origin+'/'+value.image:location.origin+'/frontend/img/hospital.png'}" style="width: 100%; height:100%;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-uppercase text-center" style="font-size: 15px;">${value.name}</h5>
                                <p class="card-text text-primary text-center mb-2"><span>${value.hospital_type.toUpperCase()}</span> | <span>${value.phone}</span></p>
                                <ul style="list-style: none;padding:0 0 0 5px;">
                                    <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span class="text-dark" style="font-size: 13px;">${value.address}, ${value.city.name}</span></li>
                                    <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span class="text-dark" style="font-size: 13px;">${value.email}</span></li>
                                </ul>
                            </div>                    
                            <div class="card-footer text-uppercase text-white border-0 text-center py-3">
                                View Details
                            </div>
                            ${value.discount_amount!=0?"<div class='discount'>-"+value.discount_amount+"%</div>":""}
                        </div>
                    </a>
                </div>
                `;
            $(".hospitalbody").append(row)

        }

        function Error(err) {
            $.each(err, (index, value) => {
                $("#formHospital").find(".error-" + index).text(value)
            })
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
                success: (response) => {
                    if (response.error) {
                        $(".hospitalbody").html(`<div class="col-12 bg-dark text-white text-center">Not Found Data</div>`)
                        Error(response.error);
                    } else {
                        if (response.null) {
                            $(".hospitalbody").html(`<div class="bg-dark text-white text-center">${response.null}</div>`)
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