@extends("layouts.hospital.app")
@section("title", "Hospital Profile")

@push("style")
<style>
    .hospital-card-heading {
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
    <div class="col-md-10">
        <div class="card card-hover">
            <div class="card-heading hospital-card-heading" style="background: url('{{asset(Auth::guard('hospital')->user()->image != 0 ? Auth::guard('hospital')->user()->image : '/noimage.jpg')}}');"></div>
            <div class="box bg-success text-center py-3">
                <h6 class="text-white">Hospital Profile</h6>
            </div>
            <div class="card-body pt-3">
                <form id="updateHospital">
                    <input type="hidden" name="id" id="id" value="{{Auth::guard('hospital')->user()->id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Hospital Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{Auth::guard('hospital')->user()->name}}">
                                <span class="error-name error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="{{Auth::guard('hospital')->user()->username}}">
                                <span class="error-username error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Hospital Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{Auth::guard('hospital')->user()->email}}">
                                <span class="error-email error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone">Phone <i class="fa fa-plus" onclick="phoneAdd()"></i></label>
                            <div class="phoneadd">
                                @php
                                $phone = explode(",", Auth::guard('hospital')->user()->phone);
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="discount_amount">Discount</label>
                                <div class="input-group">
                                    <input type="number" name="discount_amount" id="discount_amount" class="form-control" value="{{Auth::guard('hospital')->user()->discount_amount}}"><i class="btn btn-secondary">%</i>
                                </div>
                                <span class="error-discount_amount text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hospital_type">Hospital Type</label>
                                <select name="hospital_type" id="hospital_type" class="form-control">
                                    <option value="">Select Hospital Type</option>
                                    <option value="government" {{Auth::guard('hospital')->user()->hospital_type=="government"?"selected":""}}>Government</option>
                                    <option value="non-government" {{Auth::guard('hospital')->user()->hospital_type=="non-government"?"selected":""}}>Non-Government</option>
                                </select>
                                <span class="error-hospital_type error text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city_id">City</label>
                                <select name="city_id" id="city_id" class="form-control select2">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}" {{Auth::guard('hospital')->user()->city_id==$city->id?"selected":""}}>{{$city->name}}</option>
                                    @endforeach
                                </select>
                                <span class="error-city_id error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control">{{Auth::guard('hospital')->user()->address}}</textarea>
                                <span class="error-address error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="map_link">Map Link</label>
                                <textarea name="map_link" id="map_link" class="form-control">{{Auth::guard('hospital')->user()->map_link}}</textarea>
                                <span class="error-map_link error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description">{!!Auth::guard('hospital')->user()->description!!}</textarea>
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
        $("#updateHospital").on("submit", (event) => {
            event.preventDefault()
            var description = CKEDITOR.instances.description.getData();
            var formdata = new FormData(event.target)
            formdata.append("description", description)

            $.ajax({
                url: "{{route('hospital.hospital.update')}}",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#updateHospital").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#updateHospital").find(".error-" + index).text(value);
                        })
                    } else {
                        $.notify(response, "success")
                    }
                }
            })
        })
    })

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