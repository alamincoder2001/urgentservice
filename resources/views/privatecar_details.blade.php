@extends("layouts.master")
@section("content")
<section id="hospital-details" style="padding: 25px 0;">
    <div class="container">
        <div class="doctordetail-header mb-3">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-10 col-10">
                    <form id="filterPrivatecar" class="form">
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
                                    <label for="privatecar_name" class="d-md-block d-none">Privatecar Name</label>
                                    <select class="rounded-pill privatecar" name="privatecar_name" id="privatecar_name">
                                        <option label="Select Privatecar Name"></option>
                                    </select>
                                    <span class="error-privatecar_name error text-white"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
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
        <div class="row d-flex justify-content-center privatecarbody">
            @foreach($data["privatecar"] as $item)
            <div class="col-md-6 col-10 col-sm-6 col-lg-4">
                <a style="text-decoration: none;" target="_blank" href="{{route('singlepageprivatecar', $item->id)}}" title="{{$item->name}}">
                    <div class="card border-0 mb-4" style="height:360px;background: #ffffff;box-shadow:0px 0px 5px 1px #c1c1c1;">
                        <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                            <img src="{{asset($item->image ? $item->image:'/frontend/img/privatecar.png' )}}" style="width: 100%; height:110px;">
                        </div>
                        <div class="card-body text-dark">
                            <h5 class="card-title text-center" style="font-size: 15px;">{{$item->name}}</h5>
                            <p class="card-text text-primary text-center mb-2"><span>{{str_replace(","," | ", $item->cartype_id)}}</span></p>
                            <ul style="list-style: none;padding:0 0 0 5px;">
                                <li><i style="width: 15px;height:15px;" class="fa fa-phone text-info"></i> <span style="font-size: 13px;">{{$item->phone}}</span></li>
                                <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span style="font-size: 11px;">{{$item->address}}, {{$item->city->name}}</span></li>
                                <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span style="font-size: 13px;">{{$item->email}}</span></li>
                            </ul>
                        </div>
                        <div class="card-footer text-uppercase text-white text-center border-0 py-3">
                            View Details
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

            {{$data['privatecar']->links('vendor.pagination.simple-bootstrap-4')}}
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
        $(".privatecar").select2({
            placeholder: "Select Privatecar Name"
        });

        $("#city").on("change", (event) => {
            $.ajax({
                url: "{{route('filter.city')}}",
                method: "POST",
                data: {
                    id: event.target.value,
                    privatecar: 'privatecar'
                },
                beforeSend: () => {
                    $("#privatecar_name").html(`<option value="">Select Privatecar Name</option>`)
                },
                success: (response) => {
                    if (response.null) {} else {
                        $.each(response, (index, value) => {
                            var row = `<option value="${value.name}">${value.name}</option>`;
                            $("#privatecar_name").append(row)
                        })
                    }
                }
            })
        })

        function Row(index, value) {
            var row = `
            <div class="col-md-6 col-10 col-sm-6 col-lg-4 ">
                <a style="text-decoration: none;" target="_blank" href="${'single-details-privatecar/'+value.id}" title="${value.name}">
                    <div class="card border-0 mb-4" style="height:360px;background: #ffffff;box-shadow:0px 0px 5px 1px #c1c1c1;">
                        <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                            <img src="${value.image != '0'?location.origin+'/'+value.image:location.origin+'/frontend/img/privatecar.png'}" style="width: 100%; height:110px;">
                        </div>
                        <div class="card-body text-dark">
                            <h5 class="card-title text-center" style="font-size: 15px;">${value.name}</h5>
                            <p class="card-text text-primary text-center mb-2"><span>${value.cartype_id.replaceAll(",", " | ")}</span></p>
                            <ul style="list-style: none;padding:0 0 0 5px;">
                                <li><i style="width: 15px;height:15px;" class="fa fa-phone text-info"></i> <span style="font-size: 13px;"> ${value.phone}</span></li>
                                <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span style="font-size: 11px;">${value.address}, ${value.city.name}</span></li>
                                <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span style="font-size: 13px;">${value.email}</span></li>
                            </ul>
                        </div>
                        <div class="card-footer text-uppercase text-white text-center border-0 py-3">
                            View Details
                        </div>
                    </div>
                </a>
            </div>
            `;
            $(".privatecarbody").append(row)

        }

        function Error(err) {
            $.each(err, (index, value) => {
                $("#filterPrivatecar").find(".error-" + index).text(value)
            })
        }

        $("#filterPrivatecar").on("submit", (event) => {
            event.preventDefault();
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('filter.privatecar')}}",
                method: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#filterAmbulance").find(".error").text("")
                    $(".Loading").removeClass("d-none")
                    $(".privatecarbody").html("")
                },
                success: (response) => {
                    if (response.error) {
                        $(".privatecarbody").html(`<div class="bg-dark text-white text-center">No Data Found</div>`)
                        Error(response.error);
                    } else {
                        if (response.null) {
                            $(".privatecarbody").html(`<div class="bg-dark text-white text-center">${response.null}</div>`)
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