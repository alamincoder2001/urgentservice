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
    <div class="col-md-8 col-lg-10 col-xlg-3">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Ambulance Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{Auth::guard('ambulance')->user()->email}}">
                                <span class="error-email error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Ambulance Phone</label>
                                <div class="input-group">
                                    <i class="btn btn-secondary">+88</i><input type="text" name="phone" id="phone" class="form-control" value="{{Auth::guard('ambulance')->user()->phone}}">
                                </div>
                                <span class="error-phone error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @php
                            $data = Auth::guard('ambulance')->user();
                            $ambulance = explode(",", $data->ambulance_type);
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
                                <label for="city_id">City</label>
                                <select name="city_id" id="city_id" class="form-control select2">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}" {{Auth::guard('ambulance')->user()->city_id==$city->id?"selected":""}}>{{$city->name}}</option>
                                    @endforeach
                                </select>
                                <span class="error-city_id error text-danger"></span>
                            </div>
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
</script>
@endpush