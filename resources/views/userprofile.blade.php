@extends("layouts.master")
@push("style")
<style>
    #userprofile .form-control:focus {
        box-shadow: none;
        border-color: #BA68C8
    }

    #userprofile .profile-button {
        background: rgb(99, 39, 120);
        box-shadow: none;
        border: none
    }

    #userprofile .profile-button:hover {
        background: #682773
    }

    #userprofile .profile-button:focus {
        background: #682773;
        box-shadow: none
    }

    #userprofile .profile-button:active {
        background: #682773;
        box-shadow: none
    }

    #userprofile .back:hover {
        color: #682773;
        cursor: pointer
    }

    #userprofile .labels {
        font-size: 11px
    }

    #userprofile .add-experience:hover {
        background: #BA68C8;
        color: #fff;
        cursor: pointer;
        border: solid 1px #BA68C8
    }
</style>
@endpush

@section("content")
<section id="userprofile">
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 pt-5"><img class="rounded-circle" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold">{{Auth::user()->name}}</span><span class="text-black-50">{{Auth::user()->email}}</span><span> </span></div>
                <ul class="d-flex flex-column align-items-center text-start" style="list-style: none;padding:0;">
                    <li><button value="profile" onclick="clickChange(this)" class="bg-success clickChange profile border-0 text-decoration-none px-2 py-1">Profile</button></li>
                    <li class="mt-2"><button style="background: none;" value="view" onclick="clickChange(this)" class="border-0 clickChange view text-decoration-none px-2 py-1">Comment View</button></li>
                </ul>
                <div class="d-flex align-items-center text-center">
                    <a class="dropdown-item" href="{{ route('logout.user') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> Log Out</a>
                    <form id="logout-form" action="{{ route('logout.user') }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
            <div class="col-md-6 border-right changeContent">
                <div class="p-3 py-5 first">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <form action="{{route('user.update')}}" method="POST">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Name</label><input type="text" name="name" class="form-control" value="{{Auth::user()->name}}"></div>
                            <div class="col-md-6"><label class="labels">Email</label><input type="text" name="email" class="form-control" value="{{Auth::user()->email}}"></div>
                            <div class="col-md-6"><label class="labels">Phone</label><input type="text" name="phone" class="form-control" value="{{Auth::user()->phone}}"></div>
                            <div class="col-md-6">
                                <label class="labels">City</label>
                                <select name="city_name" id="city_name" class="form-control">
                                    <option value="">Select city Name</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->name}}" {{Auth::user()->city_name==$city->id?"selected":""}}>{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12"><label class="labels">Address</label><textarea name="address" class="form-control">{{Auth::user()->address}}</textarea></div>
                        </div>
                        <div class="mt-3 text-center">
                            <button class="btn btn-primary profile-button" type="submit"> Update </button>
                        </div>
                    </form>
                </div>
                <div class="p-3 py-5 d-none second">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-0">
                                <div class="card-header">
                                    <button class="btn btn-success btn-sm">Doctor</button>
                                    <button class="btn btn-sm">Hospital</button>
                                    <button class="btn btn-sm">Diagnostic</button>
                                    <button class="btn btn-sm">Ambulance</button>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Message</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Hello</td>
                                                <td>Action</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push("js")
<script>
    function clickChange(event) {
        $(".clickChange").removeClass("bg-success")
        $("." + event.value).addClass("bg-success")

        if (event.value == "profile") {
            $(".first").removeClass("d-none")
            $(".second").addClass("d-none")
            $(".view").css({
                background: "none"
            })
        } else {
            $(".first").addClass("d-none")
            $(".second").removeClass("d-none")
            $(".profile").css({
                background: "none"
            })
        }

    }
</script>
@endpush