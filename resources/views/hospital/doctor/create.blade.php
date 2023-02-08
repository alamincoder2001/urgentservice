@extends("layouts.hospital.app")

@section("title", "Hospital Doctor Create Profile")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                <div class="card-title">
                    <a href="{{route('hospital.doctor.index')}}" class="btn btn-danger px-3">Back To Home</a>
                </div>
            </div>
            <div class="card-body">
                <form id="saveDoctor">
                    <div class="personal-info px-3">
                        <h5>Personal Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name <small class="text-danger">*</small></label>
                                    <input type="text" name="name" class="form-control" placeholder="Ex: Dr. Rayhan">
                                    <span class="error-name error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="username">Username<small class="text-danger">*</small></label>
                                    <input type="text" name="username" class="form-control" placeholder="Ex: username">
                                    <span class="error-username error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email">
                                <span class="error-email error text-danger"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password<small class="text-danger">*</small></label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    <span class="error-password error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="education">Education<small class="text-danger">*</small></label>
                                    <input type="text" name="education" class="form-control">
                                    <span class="error-education error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="department_id">Specialist<small class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <select multiple name="department_id[]" id="department_id" class="form-control select2">
                                            @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                        <i class="btn btn-secondary addDepartment">+</i>
                                    </div>
                                    <span class="error-department_id error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="first_fee">First Fee<small class="text-danger">*</small></label>
                                <div class="input-group">
                                    <input type="number" id="first_fee" name="first_fee" class="form-control" placeholder="Ex: 800 Tk"><i class="btn btn-secondary">Tk</i>
                                </div>
                                <span class="error-first_fee error text-danger"></span>
                            </div>
                            <div class="col-md-2">
                                <label for="second_fee">Second Fee<small class="text-danger">*</small></label>
                                <div class="input-group">
                                    <input type="number" id="second_fee" name="second_fee" class="form-control" placeholder="Ex: 800 Tk"><i class="btn btn-secondary">Tk</i>
                                </div>
                                <span class="error-second_fee error text-danger"></span>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="day">Availability Day <small class="text-danger">*</small></label>
                                    <div class="input-group gap-2">
                                        <input type="checkbox" id="sat" onchange="DayWiseTime(event)" name="day[]" value="Saturday" /><label for="sat">Saturday</label>
                                        <input type="checkbox" id="sun" onchange="DayWiseTime(event)" name="day[]" value="Sunday" /><label for="sun">Sunday</label>
                                        <input type="checkbox" id="mon" onchange="DayWiseTime(event)" name="day[]" value="Monday" /><label for="mon">Monday</label>
                                        <input type="checkbox" id="tue" onchange="DayWiseTime(event)" name="day[]" value="Tuesday" /><label for="tue">Tuesday</label><br>
                                        <input type="checkbox" id="wed" onchange="DayWiseTime(event)" name="day[]" value="Wednessday" /><label for="wed">Wednessday</label>
                                        <input type="checkbox" id="thu" onchange="DayWiseTime(event)" name="day[]" value="Thursday" /><label for="thu">Thursday</label>
                                        <input type="checkbox" id="fri" onchange="DayWiseTime(event)" name="day[]" value="Friday" /><label for="fri">Friday</label>
                                    </div>
                                    <span class="error-day error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="phone">Phone <i class="fa fa-plus" onclick="phoneAdd()"></i></label>
                                <div class="phoneadd">
                                    <div class="input-group">
                                        <input type="text" id="phone" name="phone[]" class="form-control">
                                        <button type="button" class="btn btn-danger">remove</button>
                                    </div>
                                </div>
                                <span class="error-phone error text-danger"></span>
                            </div>
                            <div class="col-6">
                                <label for="">Time</label>
                                <div class="timeadd">
                                </div>
                                <span class="error-time error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="concentration">Consultancy</label>
                            <textarea name="concentration" id="concentration"></textarea>
                            <span class="text-danger error-concentration error"></span>
                        </div>
                        <div class="col-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="px-3 mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Doctor Image</label>
                                    <input type="file" class="form-control" id="image" name="image" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                                    <span class="error-image error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="image">
                                    <img width="100" class="img" height="100">
                                </div>
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
@endsection

@push("js")
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
    $(".select2").select2();
    CKEDITOR.replace('description');
    CKEDITOR.replace('concentration');
    $(document).ready(() => {
        $("#saveDoctor").on("submit", (event) => {
            event.preventDefault()
            var description = CKEDITOR.instances.description.getData();
            var concentration = CKEDITOR.instances.concentration.getData();

            var formdata = new FormData(event.target)
            formdata.append("description", description)
            formdata.append("concentration", concentration)
            $.ajax({
                url: "{{route('hospital.doctor.store')}}",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#saveDoctor").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#saveDoctor").find(".error-" + index).text(value);
                        })
                    } else {
                        $("#saveDoctor").trigger('reset')
                        $.notify(response, "success");
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
            $(".timeadd ." + event.target.value).remove();
        }
    }
</script>
@endpush