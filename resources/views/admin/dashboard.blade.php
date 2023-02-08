@extends("layouts.app")
@section("title", "Dashboard")

@push("style")
<style>
    .dashboard i {
        padding: 25px;
        background: #008572;
        color: #ffffff;
        font-size: 30px;
        border-top-left-radius: 40%;
        border-bottom-right-radius: 40%;
    }
</style>
@endpush

@section("content")

<div class="row d-flex justify-content-center">
    <!-- Column -->
    <!-- hospital -->
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('admin.doctor.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["doctor"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-user-md"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">Doctor</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('admin.hospital.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["hospital"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-hospital"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">Hospital</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('admin.diagnostic.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["diagnostic"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-plus-square"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">Diagnostic</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('admin.ambulance.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["ambulance"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-ambulance"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">Ambulance</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('admin.privatecar.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["privatecar"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-car"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">Privatecar</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('department.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["department"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-list-alt"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">Department</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('city.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["city"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-list-alt"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">City List</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('test.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["test"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-list-alt"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">Test List</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('investigation.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["investigation"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-list-alt"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">Investigation</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('slider.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["slider"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-list-alt"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">Sliders</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('admin.blood.donor')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["donor"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-list-alt"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">Donor List</div>
            </div>
        </a>
    </div>
    <div class="col-md-2 col-lg-2 col-xlg-2">
        <a href="{{route('admin.user.create')}}" class="text-decoration-none">
            <div class="card" style="position: relative;padding:15px;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: #f76e6e;color: white;padding: 1px 10px;">{{$data["user"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-user-plus"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #ff6f6f;text-transform: uppercase;color: white;">User List</div>
            </div>
        </a>
    </div>
</div>
@endsection