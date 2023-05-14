@extends("layouts.app")

@section("title", "Admin Ambulance Edit Page")

@section("content")
@php
$access = App\Models\UserAccess::where('user_id', Auth::guard('admin')->user()->id)
->pluck('permissions')
->toArray();
@endphp
<div class="row d-flex justify-content-center">

    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                @if(in_array("ambulance.index", $access))
                <div class="card-title">
                    <a href="{{route('admin.ambulance.index')}}" class="btn btn-danger px-3">Back To Home</a>
                </div>
                @endif
            </div>
            <div class="card-body p-3">
                <form id="updateAmbulance">
                    <input type="hidden" id="id" name="id" value="{{$data->id}}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Ambulance Service Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$data->name}}">
                                <span class="error-name text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="{{$data->username}}">
                                <span class="error-username text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{$data->email}}">
                                <span class="error-email text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="checkbox" id="Showpassword">
                                    <input type="password" name="password" id="password" class="form-control" disabled>
                                </div>
                                <span class="error-password text-danger error"></span>
                            </div>
                        </div>
                        @php
                            $phones = explode(',', $data->phone);
                        @endphp
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Phone <span class="bg-dark rounded-pill text-white p-1" style="cursor: pointer;" onclick="addPhone(event)"><i class="fa fa-plus"></i></span></label>
                                <div class="multiplePhone">
                                    @foreach($phones as $phone)
                                    <div class="input-group">
                                        <input type="text" name="phone[]" id="" class="form-control" value="{{$phone}}">
                                        <button onclick="removePhone(event)" type="button" class="btn btn-danger">remove</button>
                                    </div>
                                    @endforeach
                                </div>
                                <span class="error-phone text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @php
                            $ambulance = explode(",", $data->ambulance_type);
                            @endphp
                            <div class="form-group">
                                <label for="ambulance_type">Type Of Ambulance</label>
                                <select multiple name="ambulance_type[]" id="ambulance_type" class="form-control select2">
                                    <option value="ICU" {{in_array("ICU",$ambulance)?"selected":""}}>ICU Ambulance</option>
                                    <option value="NICU" {{in_array("NICU",$ambulance)?"selected":""}}>Non ICU Ambulance</option>
                                    <option value="Freezing" {{in_array("Freezing",$ambulance)?"selected":""}}>Freezing Ambulance</option>
                                    <option value="AC" {{in_array("AC",$ambulance)?"selected":""}}>AC Ambulance</option>
                                    <option value="NON-AC" {{in_array("NON-AC",$ambulance)?"selected":""}}>NON AC Ambulance</option>
                                </select>
                                <span class="error-ambulance_type text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city_id">City Name</label>
                                <select onchange="getUpazila(event)" name="city_id" id="city_id" class="form-control select2">
                                    <option value="">Select City Name</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}" {{$data->city_id==$city->id?"selected":""}}>{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="error-city_id text-danger error"></span>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="upazila_id">Upazila Name</label>
                                <select name="upazila_id" id="upazila_id" class="form-control">
                                    <option value="">Select Upazila Name</option>
                                    @foreach($upazilas as $upazila)
                                    <option value="{{$upazila->id}}" {{$data->upazila_id==$upazila->id?"selected":""}}>{{$upazila->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="error-upazila_id text-danger error"></span>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control">{{$data->address}}</textarea>
                                <span class="error-address text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="map_link">Map Link</label>
                                <textarea name="map_link" id="map_link" class="form-control">{{$data->map_link}}</textarea>
                                <span class="error-map_link text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="car_license">Car License</label>
                                <input type="text" name="car_license" id="car_license" class="form-control" value="{{$data->car_license}}">
                                <span class="error-car_license text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="driver_license">Driving License</label>
                                <input type="text" name="driver_license" id="driver_license" class="form-control" value="{{$data->driver_license}}">
                                <span class="error-driver_license text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="driver_nid">Driver NID</label>
                                <input type="text" name="driver_nid" id="driver_nid" class="form-control" value="{{$data->driver_nid}}">
                                <span class="error-driver_nid text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="driver_address">Driver Address</label>
                                <input type="text" name="driver_address" id="driver_address" class="form-control" value="{{$data->driver_address}}">
                                <span class="error-driver_address text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image">Ambulance Image</label>
                                <input type="file" class="form-control" id="image" name="image" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <img src="{{asset($data->image != '0' ? $data->image : '/noimage.jpg')}}" width="100" class="img" style="border: 1px solid #ccc; height:80px;">
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description">{!!$data->description!!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-primary text-white text-uppercase px-3">Update</button>
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
    $('.select2').select2();
    $(document).ready(() => {
        $("#Showpassword").on("click", (event) => {
            if (event.target.checked) {
                $("#password").attr("disabled", false)
            } else {
                $("#password").attr("disabled", true)
            }
        })

        $("#updateAmbulance").on("submit", (event) => {
            event.preventDefault()
            var description = CKEDITOR.instances.description.getData();
            var formdata = new FormData(event.target)
            formdata.append("description", description)
            
            $.ajax({
                url: "{{route('admin.ambulance.update')}}",
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
                        $("#updateAmbulance").trigger('reset')
                        $.notify(response, "success");
                        location.href = "{{route('admin.ambulance.index')}}"
                    }
                }
            })
        })
    })

    function getUpazila(event){
        $.ajax({
            url: location.origin+"/getupazila/"+event.target.selectedOptions[0].value,
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

    function addPhone(event) {
        var row = `<div class="input-group">
                        <input type="text" name="phone[]" id="phone" class="form-control">
                        <button onclick="removePhone(event)" type="button" class="btn btn-danger">remove</button>
                    </div>`;
        $('.multiplePhone').append(row);
    }
    function removePhone(event){
        event.target.offsetParent.remove();
    }
</script>
@endpush