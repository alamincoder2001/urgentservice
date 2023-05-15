@extends("layouts.ambulance.app")
@section("title", "Ambulance Profile")
@push("style")
<style>
    .ambulance-card-heading {
        background-position: center !important;
        background-size: 100% 100% !important;
        background-repeat: no-repeat !important;
        height: 300px !important;
    }
</style>
@endpush
@section("content")
<div class="row d-flex justify-content-center">
    <!-- Column -->
    <div class="col-md-12">
        <div class="card card-hover">
            <div class="card-heading ambulance-card-heading" style="background: url('{{asset(Auth::guard('ambulance')->user()->image)}}');"></div>
            <div class="box bg-success text-center py-3">
                <h6 class="text-white">Ambulance Profile</h6>
            </div>
            <div class="card-body pt-3">
                <form id="updateAmbulance">
                    <input type="hidden" name="id" id="id" value="{{Auth::guard('ambulance')->user()->id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Ambulance Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{Auth::guard('ambulance')->user()->name}}">
                                <span class="error-name error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="{{Auth::guard('ambulance')->user()->username}}">
                                <span class="error-username error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">Ambulance Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{Auth::guard('ambulance')->user()->email}}">
                                <span class="error-email error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="phone">Phone <i class="fa fa-plus" onclick="phoneAdd()"></i></label>
                            <div class="phoneadd">
                                @php
                                $phone = explode(",", Auth::guard('ambulance')->user()->phone);
                                @endphp
                                @foreach($phone as $item)
                                <div class="input-group">
                                    <input type="text" id="phone" name="phone[]" class="form-control" value="{{$item}}">
                                    <button type="button" class="btn btn-danger removePhone">remove</button>
                                </div>
                                @endforeach
                            </div>
                            <span class="error-phone error text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            @php
                            $ambulance = explode(",", Auth::guard('ambulance')->user()->ambulance_type);
                            @endphp
                            <div class="form-group">
                                <label for="ambulance_type">Type Of Ambulance</label>
                                <select multiple name="ambulance_type[]" id="ambulance_type" class="form-control select2">
                                    <option value="ICU" {{in_array("ICU",$ambulance)?"selected":""}}>ICU Ambulance</option>
                                    <option value="NICU" {{in_array("NICU",$ambulance)?"selected":""}}>Non ICU Ambulance</option>
                                    <option value="Freezing" {{in_array("Freezing",$ambulance)?"selected":""}}>Freezing Ambulance</option>
                                    <option value="AC" {{in_array("AC",$ambulance)?"selected":""}}>AC Ambulance</option>
                                </select>
                                <span class="error-ambulance_type text-danger error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city_id">City Name</label>
                                <select onchange="getUpazila(event)" name="city_id" id="city_id" class="form-control select2">
                                    <option value="">Select City Name</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}" {{Auth::guard('ambulance')->user()->city_id==$city->id?"selected":""}}>{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="error-city_id text-danger error"></span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="upazila_id">Upazila Name</label>
                                <select name="upazila_id" id="upazila_id" class="form-control">
                                    <option value="">Select Upazila Name</option>
                                    @foreach($upazilas as $upazila)
                                    <option value="{{$upazila->id}}" {{Auth::guard('ambulance')->user()->upazila_id==$upazila->id?"selected":""}}>{{$upazila->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="error-upazila_id text-danger error"></span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control">{{Auth::guard('ambulance')->user()->address}}</textarea>
                                <span class="error-address error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="map_link">Map Link</label>
                                <textarea name="map_link" id="map_link" class="form-control">{{Auth::guard('ambulance')->user()->map_link}}</textarea>
                                <span class="error-map_link error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description">{!!Auth::guard('ambulance')->user()->description!!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-gorup text-center">
                        <button type="submit" class="btn btn-primary px-3">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push("js")
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
    $("#ambulance_type").select2();
    CKEDITOR.replace('description');
    $(document).ready(() => {
        $("#updateAmbulance").on("submit", (event) => {
            event.preventDefault()
            var description = CKEDITOR.instances.description.getData();
            var formdata = new FormData(event.target)
            formdata.append("description", description)

            $.ajax({
                url: "{{route('ambulance.profile.update')}}",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#updateAmbulance").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#updateAmbulance").find(".error-" + index).text(value);
                        })
                    } else {
                        $.notify(response, "success");
                    }
                }
            })
        })
    })

    function getUpazila(event) {
        $.ajax({
            url: location.origin + "/getupazila/" + event.target.selectedOptions[0].value,
            method: "GET",
            beforeSend: () => {
                $("#upazila_id").html(`<option value="">Select Upazila Name</option>`)
            },
            success: res => {
                $.each(res, (index, value) => {
                    $("#upazila_id").append(`<option value="${value.id}">${value.name}</option>`)
                })
            }
        })
    }

    function phoneAdd() {
        var row = `
            <div class="input-group">
                <input type="text" id="phone" name="phone[]" class="form-control">
                <button type="button" class="btn btn-danger removePhone">remove</button>
            </div>
        `
        $(".phoneadd").append(row)
    }

    $(document).on("click", ".removePhone", event => {
        event.target.offsetParent.remove();
    })
</script>
@endpush