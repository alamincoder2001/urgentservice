@extends("layouts.master")

@section("content")
<section id="donorlist" style="padding: 55px 0;">
    <div class="container" style="position: relative;">
        <div class="input-group" style="padding:8px;border-radius: 0;box-shadow: none;position: absolute;top: -55px;right: 10px;background: #283290;width: 135px;">
            <input type="checkbox" id="showAddDonor" class="me-2"> <label class="text-white text-uppercase" style="cursor: pointer" for="showAddDonor">Donor Add</label>
        </div>
    </div>
    <div class="container mb-2">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12" id="showDonor" class="d-none">
                <div class="d-none" id="maindonor" style="background: #283290;padding: 35px;">
                    <form id="formDonor" class="text-white">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="name">Donor Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" style="box-shadow: none;border-radius:0;">
                                    <span class="error-name error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="phone">Donor Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" style="box-shadow: none;border-radius:0;">
                                    <span class="error-phone error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="dob">Date of Birth</label>
                                    <input type="text" name="dob" id="dob" class="form-control datepicker" autocomplete="off" placeholder="dd-mm-YY" style="box-shadow: none;border-radius:0;">
                                    <span class="error-dob error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="email">Donor Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Nullable" style="box-shadow: none;border-radius:0;">
                                    <span class="error-email error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control" placeholder="Nullable" style="box-shadow: none;border-radius:0;">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select>
                                    <span class="error-gender error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="blood_group">Blood Group</label>
                                    <select name="blood_group" id="blood_group" class="form-control" placeholder="Nullable" style="box-shadow: none;border-radius:0;">
                                        <option value="">Select Blood Group</option>
                                        <option value="A+">A+</option>
                                        <option value="B+">B+</option>
                                        <option value="O+">O+</option>
                                        <option value="AB+">AB+</option>
                                        <option value="A-">A-</option>
                                        <option value="B-">B-</option>
                                        <option value="O-">O-</option>
                                        <option value="AB-">AB-</option>
                                    </select>
                                    <span class="error-blood_group error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="city_id">City Name</label>
                                    <select name="city_id" id="city_id" class="form-control" style="box-shadow: none;border-radius:0;">
                                        <option value="">Select city name</option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-city_id error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" style="box-shadow: none;border-radius:0;height:10px;"></textarea>
                                    <span class="error-address error text-warning"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="image">Donor Image</label>
                                    <input type="file" class="form-control" name="image" id="image" style="box-shadow: none;border-radius:0;">
                                    <span class="error-image error text-warning"></span>
                                    <i>Not Fillable this Field</i>
                                </div>
                            </div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn border-0" style="background: green;border-radius: 0;color: white;">Save Donor</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 145px;">
        <div class="row d-flex align-items-center justify-content-end">
            <div class="col-lg-2 col-2 text-end">
                <div class="form-group">
                    <select class="GroupwiseDonor" style="width: 80%;box-shadow:none;outline:none;border: 1px solid #061160;padding: 3px;border-bottom: 0;">
                        <option value="">Filter Donor</option>
                        <option value="A+">A+</option>
                        <option value="B+">B+</option>
                        <option value="O+">O+</option>
                        <option value="AB+">AB+</option>
                        <option value="A-">A-</option>
                        <option value="B-">B-</option>
                        <option value="O-">O-</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
            </div>
        </div>
        <hr class="mt-0" style="color: #061160;">
        <div class="row d-flex justify-content-center groupWiseDonorShow">
            @if(count($data) > 0)
            @foreach($data as $item)
            <div class="col-md-2 col-lg-2 col-12">
                <div class="card" title="{{$item->name}}">
                    <div class="card-header p-0" style="background: 0;">
                        <img style="width: 100%; height:110px;padding:6px;" src="{{asset($item->image?$item->image:'uploads/nouserimage.png')}}" class="card-img-top">
                    </div>
                    <div class="card-body py-1">
                        <p><span style="font-weight:500;">Name:</span> {{$item->name}}</p>
                        <p><span style="font-weight:500;">Blood Group:</span> {{$item->blood_group}}</p>
                        <p><span style="font-weight:500;">Phone:</span> {{$item->phone}}</p>
                        <p><span style="font-weight:500;">Gender:</span> {{ucwords($item->gender)}}</p>
                        <p><span style="font-weight:500;">Address: </span>{{$item->address}}, {{$item->city->name}}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <p>Not Found Data</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push("js")
<script>
    $(document).ready(() => {
        $("#showAddDonor").on("click", event => {
            if (event.target.checked) {
                $("#showDonor").removeClass("d-none").animate({
                    height: "350px",
                    padding: "10px"
                });
                $("#maindonor").removeClass("d-none");
            } else {
                $("#showDonor").animate({
                    height: "0",
                    padding: "0"
                });
                $("#maindonor").addClass("d-none");
            }
        })

        $("#formDonor").on("submit", event => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('donor.store')}}",
                method: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#formDonor").find(".error").text("")
                },
                success: response => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#formDonor").find(".error-" + index).text(value)
                        })
                    } else {
                        $("#formDonor").trigger("reset");
                        $.notify(response, "success");
                        setTimeout(function() {
                            location.reload();
                        }, 500)
                    }
                }
            })
        })

        $(".GroupwiseDonor").on("change", event => {
            $.ajax({
                url: "{{route('filter.donor')}}",
                method: "POST",
                dataType: "JSON",
                data: {
                    group: event.target.value
                },
                beforeSend: () => {
                    $(".groupWiseDonorShow").html("")
                    $(".Loading").removeClass("d-none")
                },
                success: response => {
                    if (!response.null) {
                        $.each(response, (index, value) => {                            
                            let row = `
                                <div class="col-md-2 col-lg-2 col-12">
                                    <div class="card" title="${value.name}">
                                        <div class="card-header p-0" style="background: 0;">
                                            <img style="width: 100%; height:110px;padding:6px;" src="${value.image > '0'?location.origin+"/"+value.image:"/uploads/nouserimage.png"}" class="card-img-top">
                                        </div>
                                        <div class="card-body py-1">
                                            <p><span style="font-weight:500;">Name:</span> ${value.name}</p>
                                            <p><span style="font-weight:500;">Blood Group:</span> ${value.blood_group}</p>
                                            <p><span style="font-weight:500;">Phone:</span> ${value.phone}</p>
                                            <p><span style="font-weight:500;">Gender:</span> ${value.gender.charAt().toUpperCase()+value.gender.slice(1)}</p>
                                            <p><span style="font-weight:500;">Address: </span>${value.address}, ${value.city.name}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $(".groupWiseDonorShow").append(row)
                        })
                    } else {
                        let row = `
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>${response.null}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        $(".groupWiseDonorShow").html(row)
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