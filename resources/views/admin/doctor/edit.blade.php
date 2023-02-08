@extends("layouts.app")

@section("title", "Admin Doctor Update Profile")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                <div class="card-title">
                    <a href="{{route('admin.doctor.index')}}" class="btn btn-danger px-3">Back To Home</a>
                </div>
            </div>
            <div class="card-body">
                <form id="updateDoctor">
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <div class="personal-info px-3">
                        <h5>Personal Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name <small class="text-danger">*</small></label>
                                    <input type="text" name="name" class="form-control" value="{{$data->name}}">
                                    <span class="error-name error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="username">Username<small class="text-danger">*</small></label>
                                <input type="text" id="username" name="username" class="form-control" value="{{$data->username}}">
                                <span class="error-username text-danger"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{$data->email}}">
                                <span class="error-email text-danger"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password<small class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <input type="checkbox" id="Showpassword"><input type="password" disabled class="form-control" id="password" name="password" placeholder="Password">
                                    </div>
                                    <span class="error-password text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="education">Education<small class="text-danger">*</small></label>
                                    <input type="text" name="education" class="form-control" value="{{$data->education}}">
                                    <span class="error-education error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_id">City Name<small class="text-danger">*</small></label>
                                    <select name="city_id" id="city_id" class="form-control select2">
                                        <option value="">Choose a city name</option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}" {{$data->city_id == $city->id?"selected":""}}>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="error-city_id text-danger error"></span>
                            </div>
                            <div class="col-md-2">
                                <label for="first_fee">First Fee<small class="text-danger">*</small></label>
                                <input type="number" id="first_fee" name="first_fee" class="form-control" value="{{$data->first_fee}}">
                                <span class="error-first_fee error text-danger"></span>
                            </div>
                            <div class="col-md-2">
                                <label for="second_fee">Second Fee<small class="text-danger">*</small></label>
                                <input type="number" id="second_fee" name="second_fee" class="form-control" value="{{$data->second_fee}}">
                                <span class="error-second_fee error text-danger"></span>
                            </div>
                            <div class="col-md-8">
                            @php
                                $timedaycheck = $data->time->pluck("day")->toArray();
                            @endphp 
                                <div class="form-group">
                                    <label for="day">Availability Day <small class="text-danger">*</small></label>
                                    <div class="input-group gap-2">
                                        <input type="checkbox" onchange="DayWiseTime(event)" id="sat" {{in_array("Saturday", $timedaycheck)?"checked":""}} name="day[]" value="Saturday" /><label for="sat">Saturday</label>
                                        <input type="checkbox" onchange="DayWiseTime(event)" id="sun" {{in_array("Sunday", $timedaycheck)?"checked":""}} name="day[]" value="Sunday" /><label for="sun">Sunday</label>
                                        <input type="checkbox" onchange="DayWiseTime(event)" id="mon" {{in_array("Monday", $timedaycheck)?"checked":""}} name="day[]" value="Monday" /><label for="mon">Monday</label>
                                        <input type="checkbox" onchange="DayWiseTime(event)" id="tue" {{in_array("Tuesday", $timedaycheck)?"checked":""}} name="day[]" value="Tuesday" /><label for="tue">Tuesday</label><br>
                                        <input type="checkbox" onchange="DayWiseTime(event)" id="wed" {{in_array("Wednessday", $timedaycheck)?"checked":""}} name="day[]" value="Wednessday" /><label for="wed">Wednessday</label>
                                        <input type="checkbox" onchange="DayWiseTime(event)" id="thu" {{in_array("Thursday", $timedaycheck)?"checked":""}} name="day[]" value="Thursday" /><label for="thu">Thursday</label>
                                        <input type="checkbox" onchange="DayWiseTime(event)" id="fri" {{in_array("Friday", $timedaycheck)?"checked":""}} name="day[]" value="Friday" /><label for="fri">Friday</label>
                                    </div>
                                    <span class="error-day error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    @php
                                    $specialist = App\Models\Specialist::where("doctor_id", $data->id)->pluck("department_id")->toArray();
                                    @endphp

                                    <label for="department_id">Specialist<small class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <select multiple name="department_id[]" id="department_id" class="form-control select2">
                                            @foreach($departments as $department)
                                            <option value="{{$department->id}}" {{in_array($department->id, $specialist)?"selected":""}}>{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                        <i class="btn btn-secondary addDepartment">+</i>
                                    </div>
                                    <span class="error-department_id error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="">Time</label>
                                <div class="timeadd">
                                    @foreach($data->time as $item)
                                    <div class="input-group {{$item->day}}">
                                        <input type="time" id="from" name="from[]" class="form-control" value="{{$item->from}}">
                                        <input type="time" id="to" name="to[]" class="form-control" value="{{$item->to}}">
                                    </div>
                                    @endforeach
                                </div>
                                <span class="error-time error text-danger"></span>
                            </div>
                            <div class="col-4">
                                <label for="phone">Phone <i class="fa fa-plus" onclick="phoneAdd()"></i></label>
                                <div class="phoneadd">
                                    @php
                                    $phone = explode(",", $data->phone);
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
                        </div>
                    </div>

                    <!-- hospital && diagnostic && chamber -->
                    <div class="chamber-info px-3">
                        <h5>Select Chamber Or Hospital Or Diagnostic</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Choose a module</label>
                                    <select class="form-control changeModule">
                                        <option value="">Select Chamber Or Hospital Or Diagnostic</option>
                                        <option value="chamber">Chamber</option>
                                        <option value="hospital">Hospital</option>
                                        <option value="diagnostic">Diagnostic</option>
                                    </select>
                                </div>
                            </div>
                            <div id="chamber" class="col-md-8 row {{$data->chamber?'':'d-none'}}">
                                <div class="col-md-12">
                                    <table class="table chamberTable">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Chamber Name</th>
                                                <th>Address</th>
                                                <th><i class="btn btn-dark ChamberName">+</i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data->chamber as $key => $item)
                                            <tr class="{{$key+1}}">
                                                <td>{{$key+1}}</td>
                                                <td><input type="text" name="chamber[]" class="form-control" value="{{$item->name}}" /></td>
                                                <td><input type="text" name="address[]" class="form-control" value="{{$item->address}}" /></td>
                                                <td><span data="{{$key+1}}" data-id="{{$item->id}}" class="text-danger removeChamber" style="cursor:pointer;">Remove</span></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="hospital" class="col-md-8 row {{$data->hospital_id?'':'d-none'}}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hospital_id">Hospital Name</label>
                                        <select multiple name="hospital_id[]" id="hospital_id" class="select1 form-control">
                                            <option label="Choose Hospital"></option>
                                            @php
                                            $hosparr = explode(",",$data->hospital_id);
                                            $diagarr = explode(",",$data->diagnostic_id);
                                            @endphp
                                            @foreach($hospitals as $item)
                                            <option value="{{$item->id}}" {{in_array($item->id, $hosparr)?"selected":""}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-hospital_id error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="diagnostic" class="col-md-8 row {{$data->diagnostic_id?'':'d-none'}}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="diagnostic_id">Diagnostic Name</label>
                                        <select multiple name="diagnostic_id[]" id="diagnostic_id" class="select1 form-control">
                                            <option label="Choose Diagnostic"></option>
                                            @foreach($diagnostics as $item)
                                            <option value="{{$item->id}}" {{in_array($item->id, $diagarr)?"selected":""}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-diagnostic_id error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="concentration">Consultancy</label>
                            <textarea name="concentration" id="concentration">{{$data->concentration}}</textarea>
                        </div>
                        <div class="col-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description">{{$data->description}}</textarea>
                        </div>
                    </div>

                    <div class="img-info px-3">
                        <hr>
                        <div class="row d-flex align-items-center">
                            <div class="col-md-3">
                                <div class="image">
                                    <img width="100" class="img" height="100" src="{{asset($data->image)}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Doctor Image</label>
                                    <input type="file" class="form-control" id="image" name="image" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                                    <span class="error-image text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group text-center mt-3">
                        <hr>
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
    CKEDITOR.replace('concentration');
    $(document).ready(() => {
        $('.select2').select2();

        $("#Showpassword").on("click", (event) => {
            if (event.target.checked) {
                $("#password").attr("disabled", false)
            } else {
                $("#password").attr("disabled", true)
            }
        })

        $(".ChamberName").on("click", (event) => {
            var count = $(".chamberTable").find("tbody").html();
            if (count != "") {
                var totallength = $(".chamberTable").find("tbody tr").length;
                var row = `
                <tr class="${totallength+1}">
                    <td>${totallength+1}</td>
                    <td><input type="text" name="chamber[]" class="form-control" placeholder="Chamber Name"/></td>
                    <td><input type="text" name="address[]" class="form-control" placeholder="Chamber Address"/></td>
                    <td><span data="${totallength+1}"  class="text-danger removeChamber" style="cursor:pointer;">Remove</span></td>
                </tr>
            `;

                $(".chamberTable").find("tbody").prepend(row)
            } else {
                var row = `
                <tr class="1">
                    <td>1</td>
                    <td><input type="text" name="chamber[]" class="form-control Chamber-Name" placeholder="Chamber Name"/></td>
                    <td><input type="text" name="address[]" class="form-control Chamber-Address" placeholder="Chamber Address"/></td>
                    <td><span data="1"  class="text-danger removeChamber" style="cursor:pointer;">Remove</span></td>
                </tr>
            `;

                $(".chamberTable").find("tbody").prepend(row)
            }
        })

        $(document).on("click", ".removeChamber", event => {
            $(".chamberTable").find("tbody ." + event.target.attributes[0].value).remove()
        })

        $(document).on("change", ".changeModule", (event) => {
            if (event.target.value == "chamber") {
                $("#chamber").removeClass("d-none")
                $("#hospital").addClass("d-none")
                $("#diagnostic").addClass("d-none")
            } else if (event.target.value == "hospital") {
                $("#chamber").addClass("d-none")
                $("#hospital").removeClass("d-none")
                $("#diagnostic").addClass("d-none")
                $('.select1').select2();
            } else if (event.target.value == "diagnostic") {
                $("#chamber").addClass("d-none")
                $("#hospital").addClass("d-none")
                $("#diagnostic").removeClass("d-none")
                $('.select1').select2();
            } else {
                $("#chamber").addClass("d-none")
                $("#hospital").addClass("d-none")
                $("#diagnostic").addClass("d-none")
            }
        })

        $("#updateDoctor").on("submit", (event) => {
            event.preventDefault()
            var description = CKEDITOR.instances.description.getData();
            var concentration = CKEDITOR.instances.concentration.getData();

            var formdata = new FormData(event.target)
            formdata.append("description", description)
            formdata.append("concentration", concentration)

            $.ajax({
                url: "{{route('admin.doctor.update')}}",
                data: formdata,
                method: "POST",
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#updateDoctor").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#updateDoctor").find(".error-" + index).text(value);
                        })
                    } else {
                        $.notify(response, "success");
                        window.location.href = "{{route('admin.doctor.index')}}"
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

    function DayWiseTime(event) {
        if (event.target.checked) {
            var row = `
                <div class="input-group ${event.target.value}">
                    <input type="time" id="from" name="from[]" class="form-control">
                    <input type="time" id="to" name="to[]" class="form-control">
                </div>
            `
            $(".timeadd").append(row)
        } else {
          $(".timeadd ."+event.target.value).remove();
        }
    }
</script>
@endpush