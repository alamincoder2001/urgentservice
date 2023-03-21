@extends("layouts.doctor.app")

@section("title", "Doctor Dashboard")

@section("content")
<div class="row">
    <div class="col-xl-4">
        <div class="card card-white">
            <div class="card-heading clearfix">
                <h6 class="text-info"><span>Profile</span> of~ {{Auth::guard('doctor')->user()->name}}</h6>
            </div>
            <div class="card-body user-profile-card">
                <img src="{{asset(Auth::guard('doctor')->user()->image != 0 ? Auth::guard('doctor')->user()->image:'/uploads/nouserimage.png')}}" class="user-profile-image rounded-circle" alt="{{Auth::guard('doctor')->user()->name}}">
                <h4 class="text-center m-t-lg">{{Auth::guard('doctor')->user()->name}}</h4>
                <h5 class="text-center"><i class="fas fa-book pe-1" style="font-size: 15px;color:#0014ff;"></i>{{Auth::guard('doctor')->user()->education}}</h5>
                <p class="text-center">{{Auth::guard('doctor')->user()->speciality}}</p>
                <hr>
                <ul class="list-unstyled text-center">

                    <li>
                        <p>
                            <i class="fas fa-map-marker-alt m-r-xs"></i>
                            @if(Auth::guard('doctor')->user()->chamber_name)
                            {{Auth::guard('doctor')->user()->address}}
                            @else
                            @if(Auth::guard('doctor')->user()->hospital_id)
                            {{Auth::guard('doctor')->user()->hospital->address}}
                            @elseif(Auth::guard('doctor')->user()->diagnostic_id)
                            {{Auth::guard('doctor')->user()->diagnostic->address}}
                            @else
                            @endif
                            @endif
                        </p>
                    </li>
                </ul>
                <hr>
                <p><i class="far fa-paper-plane m-r-xs"></i><a href="#">{{Auth::guard('doctor')->user()->email}}</a></p>
                @if(Auth::guard('doctor')->user()->chamber_name)
                <p><i class='fa fa-home'></i>{{Auth::guard('doctor')->user()->chamber_name}}</p>
                @else
                @if(Auth::guard('doctor')->user()->hospital_id)
                <p><i class='fa fa-hospital'></i> {{Auth::guard('doctor')->user()->hospital_id==null?"":Auth::guard('doctor')->user()->hospital->name}}</p>
                @else(Auth::guard('doctor')->user()->diagnostic_id)
                <p><i class='fa fa-plus-square'></i> {{Auth::guard('doctor')->user()->diagnostic_id==null?"":Auth::guard('doctor')->user()->diagnostic->name}}</p>
                @endif
                @endif
                <span>Created: <small>{{date('d.m.Y', strtotime(Auth::guard('doctor')->user()->created_at))}}</small></span>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card card-white">
            <div class="card-heading clearfix">
                <h4 class="card-title">Doctor Profile</h4>

                <form id="doctorUpdate">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" class="form-control" name="name" value="{{Auth::guard('doctor')->user()->name}}">
                                    <span class="error-name error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" class="form-control" name="username" value="{{Auth::guard('doctor')->user()->username}}">
                                    <span class="error-username error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" class="form-control" name="email" value="{{Auth::guard('doctor')->user()->email}}">
                                    <span class="error-email error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="education">Education</label>
                                    <input type="text" id="education" class="form-control" name="education" value="{{Auth::guard('doctor')->user()->education}}">
                                </div>
                                <span class="error-education error text-danger"></span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    @php
                                    $specialist = App\Models\Specialist::where("doctor_id", Auth::guard('doctor')->user()->id)->pluck("department_id")->toArray();
                                    @endphp
                                    <label for="department_id">Speciality</label>
                                    <select multiple name="department_id[]" id="department_id" class="form-control select2">
                                        <option value="">Select Department</option>
                                        @foreach($data['department'] as $department)
                                        <option value="{{$department->id}}" {{in_array($department->id, $specialist)?"selected":""}}>{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-department_id error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="first_fee">First Fee</label>
                                    <div class="input-group">
                                        <input type="number" id="first_fee" class="form-control" name="first_fee" value="{{Auth::guard('doctor')->user()->first_fee}}"><i class="btn btn-secondary">Tk</i>
                                    </div>
                                    <span class="error-first_fee error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="second_fee">Second Fee</label>
                                    <div class="input-group">
                                        <input type="number" id="second_fee" class="form-control" name="second_fee" value="{{Auth::guard('doctor')->user()->second_fee}}"><i class="btn btn-secondary">Tk</i>
                                    </div>
                                    <span class="error-second_fee error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hospital_id">Hospital Name</label>
                                    <select multiple name="hospital_id[]" id="hospital_id" class="form-control select2">
                                        <option value="">Select Hospital Name</option>
                                        @foreach($hospitals as $hospital)
                                        <option value="{{$hospital->id}}" {{in_array($hospital->id, $data['hospital_id'])?"selected":""}}>{{$hospital->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-hospital_id error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="diagnostic_id">Diagnostic Name</label>
                                    <select multiple name="diagnostic_id[]" id="diagnostic_id" class="form-control select2">
                                        <option value="">Select Diagnostic Name</option>
                                        @foreach($diagnostics as $diagnostic)
                                        <option value="{{$diagnostic->id}}" {{in_array($diagnostic->id, $data['diagnostic_id'])?"selected":""}}>{{$diagnostic->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-diagnostic_id error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="availability">Availability Day</label>
                                    @php
                                    $avail = explode(",",Auth::guard('doctor')->user()->availability);
                                    $phones = explode(",",Auth::guard('doctor')->user()->phone);
                                    @endphp
                                    <div class="input-group">
                                        <input type="checkbox" {{in_array("sat",$avail)?"checked":''}} id="sat" name="availability[]" value="sat" class="ms-3 me-1" /><label style="margin-left: 20px;">Saturday</label>
                                        <input type="checkbox" {{in_array("sun",$avail)?"checked":''}} id="sun" name="availability[]" value="sun" class="ms-3 me-1" /><label style="margin-left: 20px;">Sunday</label>
                                        <input type="checkbox" {{in_array("mon",$avail)?"checked":''}} id="mon" name="availability[]" value="mon" class="ms-3 me-1" /><label style="margin-left: 20px;">Monday</label>
                                        <input type="checkbox" {{in_array("tue",$avail)?"checked":''}} id="tue" name="availability[]" value="tue" class="ms-3 me-1" /><label style="margin-left: 20px;">Tuesday</label>
                                        <input type="checkbox" {{in_array("wed",$avail)?"checked":''}} id="wed" name="availability[]" value="wed" class="ms-3 me-1" /><label style="margin-left: 20px;">Wednessday</label>
                                        <input type="checkbox" {{in_array("thu",$avail)?"checked":''}} id="thu" name="availability[]" value="thu" class="ms-3 me-1" /><label style="margin-left: 20px;">Thursday</label>
                                        <input type="checkbox" {{in_array("fri",$avail)?"checked":''}} id="fri" name="availability[]" value="fri" class="ms-3 me-1" /><label style="margin-left: 20px;">Friday</label>
                                    </div>
                                    <span class="error-availability text-danger"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Time <i class="fa fa-plus" onclick="TimeAdd()"></i></label>
                                <div class="timeadd">
                                    @foreach(Auth::guard('doctor')->user()->time as $t)
                                    <div class="input-group">
                                        <input type="time" id="from" name="from[]" class="form-control" value="{{$t->from}}">
                                        <input type="time" id="to" name="to[]" class="form-control" value="{{$t->to}}">
                                        <button type="button" class="btn btn-danger removeTime">remove</button>
                                    </div>
                                    @endforeach
                                </div>
                                <span class="error-time error text-danger"></span>
                            </div>
                            <div class="col-6">
                                <label for="phone">Phone <i class="fa fa-plus" onclick="phoneAdd()"></i></label>
                                <div class="phoneadd">
                                    @foreach($phones as $p)
                                    <div class="input-group">
                                        <input type="text" id="phone" name="phone[]" class="form-control" value="{{$p}}">
                                        <button type="button" class="btn btn-danger removePhone">remove</button>
                                    </div>
                                    @endforeach
                                </div>
                                <span class="error-phone error text-danger"></span>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="chamber">Chamber Create</label>
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
                                            @foreach(Auth::guard('doctor')->user()->chamber as $key => $item)
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

                            <div class="col-12">
                                <label for="concentration">Consultancy</label>
                                <textarea name="concentration" id="concentration">{{Auth::guard("doctor")->user()->concentration}}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="description">Description</label>
                                <textarea name="description" id="description">{{Auth::guard("doctor")->user()->description}}</textarea>
                            </div>
                            <div class="form-group text-center mt-4">
                                <button class="btn btn-primary px-3 text-uppercase">Update</button>
                            </div>
                        </div>
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
        $(".select2").select2()

        $("#doctorUpdate").on("submit", event => {
            event.preventDefault()
            var description = CKEDITOR.instances.description.getData();
            var concentration = CKEDITOR.instances.concentration.getData();

            var formdata = new FormData(event.target)
            formdata.append("description", description)
            formdata.append("concentration", concentration)
            $.ajax({
                url: "{{route('doctor.doctor.update')}}",
                method: "POST",
                dataType: "JSON",
                data: formdata,
                contentType: false,
                processData: false,
                success: response => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#doctorUpdate").find(".error-" + index).text(value)
                        })
                    } else {
                        $.notify(response, "success");
                        window.location.reload()
                    }
                }
            })
        })
    })


    function TimeAdd() {
        var row = `
            <div class="input-group">
                <input type="time" id="from" name="from[]" class="form-control">
                <input type="time" id="to" name="to[]" class="form-control">
                <button type="button" class="btn btn-danger removeTime">remove</button>
            </div>
        `
        $(".timeadd").append(row)
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

    $(document).on("click", ".removeTime", event => {
        event.target.offsetParent.remove();
    })

    $(document).on("click", ".removePhone", event => {
        event.target.offsetParent.remove();
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
</script>
@endpush