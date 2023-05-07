@extends("layouts.app")
@section("title", "Admin Privatecar Create Page")
@push("js")
    <style>
        .cartype_id[data-select2-id='select2-data-cartype_id'] .select2-container{
            width: 85% !important;
        }
    </style>
@endpush
@section("content")
<div class="row d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                <div class="card-title">
                    <a href="{{route('admin.privatecar.index')}}" class="btn btn-danger px-3">Back To Home</a>
                </div>
            </div>
            <div class="card-body p-3">
                <form id="addPrivatecar">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Privatecar Service Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                                <span class="error-name text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control">
                                <span class="error-username text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                                <span class="error-password text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="urgentservicebd@gmail.com">
                                <span class="error-email text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Phone <span class="bg-dark rounded-pill text-white p-1" style="cursor: pointer;" onclick="addPhone(event)"><i class="fa fa-plus"></i></span></label>
                                <div class="multiplePhone">
                                    <div class="input-group">
                                        <input type="text" name="phone[]" id="" class="form-control" value="01721843819">
                                    </div>
                                </div>
                                <span class="error-phone text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cartype_id">Type Of Privatecar</label>
                                <div class="input-group">
                                    <select multiple name="cartype_id[]" id="cartype_id" class="form-control cartype_id">
                                        @foreach(App\Models\Cartype::latest()->get() as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    <span onclick="PrivateCar(event)" class="btn btn-dark">+</span>
                                </div>
                                <span class="error-cartype_id text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city_id">City Name</label>
                                <select onchange="getUpazila(event)" name="city_id" id="city_id" class="form-control cartype_id">
                                    <option value="">Select City Name</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="error-city_id text-danger error"></span>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="upazila_id">Upazila Name</label>
                                <select  name="upazila_id" id="upazila_id" class="form-control">
                                    <option value="">Select Upazila Name</option>
                                </select>
                            </div>
                            <span class="error-upazila_id text-danger error"></span>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control"></textarea>
                                <span class="error-address text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="map_link">Map Link</label>
                                <textarea name="map_link" id="map_link" class="form-control"></textarea>
                                <span class="error-map_link text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="car_license">Privatecar License</label>
                                <input type="text" name="car_license" id="car_license" class="form-control">
                                <span class="error-car_license text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="driver_license">Driving License</label>
                                <input type="text" name="driver_license" id="driver_license" class="form-control">
                                <span class="error-driver_license text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="driver_nid">Driver NID</label>
                                <input type="text" name="driver_nid" id="driver_nid" class="form-control">
                                <span class="error-driver_nid text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="driver_address">Driver Address</label>
                                <input type="text" name="driver_address" id="driver_address" class="form-control">
                                <span class="error-driver_address text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="number_of_seat">Number Of Seat</label>
                                <input type="text" name="number_of_seat" id="number_of_seat" class="form-control">
                                <span class="error-number_of_seat text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image">Privatecar Image</label>
                                <input type="file" class="form-control" id="image" name="image" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <img src="{{asset('noimage.jpg')}}" class="img" style="width:100px;border: 1px solid #ccc; height:80px;">
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-success text-white text-uppercase px-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Car Type Name</h5>
            </div>
            <form id="formPrivatecar">
                <input type="hidden" name="car_id" id="car_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Car Type</label>
                        <input type="text" name="name" class="form-control" id="name">
                        <span class="error-name error text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push("js")
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
    $('.cartype_id').select2();
    $(document).ready(() => {
        $("#addPrivatecar").on("submit", (event) => {
            event.preventDefault()
            var description = CKEDITOR.instances.description.getData();
            var formdata = new FormData(event.target)
            formdata.append("description", description)

            $.ajax({
                url: "{{route('admin.privatecar.store')}}",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#addPrivatecar").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#addPrivatecar").find(".error-" + index).text(value);
                        })
                    } else {
                        $("#addPrivatecar").trigger('reset')
                        $.notify(response, "success");
                    }
                }
            })
        })
    })

    function PrivateCar(event) {
        $("#myModal").modal("show")
    }

    $("#formPrivatecar").on("submit", event => {
        event.preventDefault()
        var name = $("#myModal").find("#formPrivatecar #name").val()
        var id = $("#myModal").find("#formPrivatecar #car_id").val()
        $.ajax({
            url: location.origin + "/admin/cartype",
            method: "POST",
            data: {car_id: id, name:name},
            beforeSend: () => {
                $("#myModal").find("#formPrivatecar .error").text("")
            },
            success: res => {
                if (res.error) {
                    $.each(res.error, (index, value) => {
                        $("#myModal").find("#formPrivatecar .error-" + index).text(value)
                    })
                } else {
                    $("#myModal").modal("hide")
                    $.notify(res.msg, "success")
                    $("#formPrivatecar").trigger('reset')
                    $("#cartype_id").append(`<option value="${res.name}">${name}</option>`);
                }
            }
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