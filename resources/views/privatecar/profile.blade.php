@extends("layouts.privatecar.app")
@section("title", "privatecar Profile")
@push("style")
<style>
    .privatecar-card-heading {
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
            <div class="card-heading privatecar-card-heading" style="background: url('{{asset(Auth::guard('privatecar')->user()->image != '0' ? Auth::guard('privatecar')->user()->image : '/noimage.jpg')}}');"></div>
            <div class="box bg-success text-center py-3">
                <h6 class="text-white">Privatecar Profile</h6>
            </div>
            <div class="card-body pt-3">
                <form id="updatePrivatecar">
                    <input type="hidden" name="id" id="id" value="{{Auth::guard('privatecar')->user()->id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Privatecar Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{Auth::guard('privatecar')->user()->name}}">
                                <span class="error-name error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="{{Auth::guard('privatecar')->user()->username}}">
                                <span class="error-username error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Privatecar Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{Auth::guard('privatecar')->user()->email}}">
                                <span class="error-email error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Privatecar Phone</label>
                                <div class="input-group">
                                    <i class="btn btn-secondary">+88</i><input type="text" name="phone" id="phone" class="form-control" value="{{Auth::guard('privatecar')->user()->phone}}">
                                </div>
                                <span class="error-phone error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @php
                            $data = Auth::guard('privatecar')->user();
                            $privatecar = explode(",", $data->privatecar_type);
                            @endphp
                            <div class="form-group">
                                <label for="privatecar_type">Type Of Privatecar</label>
                                <select multiple name="privatecar_type[]" id="privatecar_type" class="form-control select2">
                                    <option value="ICU" {{in_array("ICU",$privatecar)?"selected":""}}>ICU Privatecar</option>
                                    <option value="NICU" {{in_array("NICU",$privatecar)?"selected":""}}>Non ICU Privatecar</option>
                                    <option value="Freezing" {{in_array("Freezing",$privatecar)?"selected":""}}>Freezing Privatecar</option>
                                    <option value="AC" {{in_array("AC",$privatecar)?"selected":""}}>AC Privatecar</option>
                                </select>
                                <span class="error-privatecar_type text-danger error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city_id">City</label>
                                <select name="city_id" id="city_id" class="form-control select2">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}" {{Auth::guard('privatecar')->user()->city_id==$city->id?"selected":""}}>{{$city->name}}</option>
                                    @endforeach
                                </select>
                                <span class="error-city_id error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control">{{Auth::guard('privatecar')->user()->address}}</textarea>
                                <span class="error-address error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="map_link">Map Link</label>
                                <textarea name="map_link" id="map_link" class="form-control">{{Auth::guard('privatecar')->user()->map_link}}</textarea>
                                <span class="error-map_link error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description">{!!Auth::guard('privatecar')->user()->description!!}</textarea>
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
    $("#privatecar_type").select2();
    CKEDITOR.replace('description');
    $(document).ready(() => {
        $("#updatePrivatecar").on("submit", (event) => {
            event.preventDefault()
            var description = CKEDITOR.instances.description.getData();
            var formdata = new FormData(event.target)
            formdata.append("description", description)

            $.ajax({
                url: "{{route('privatecar.profile.update')}}",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#updateprivatecar").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#updateprivatecar").find(".error-" + index).text(value);
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