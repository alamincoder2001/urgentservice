@extends("layouts.hospital.app")
@section("title", "Hospital Dashboard")

@push("style")
<style>
    .dashboard i {
        padding: 25px;
        background: red;
        color: #ffffff;
        font-size: 30px;
        border-top-left-radius: 40%;
        border-bottom-right-radius: 40%;
    }
</style>
@endpush
@section("content")

<div class="row d-flex justify-content-center">
    <div class="col-md-3 col-lg-3 col-xlg-3">
        <a href="{{route('hospital.doctor.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: green;color: white;padding: 1px 10px;">{{$data["doctor"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-user-md"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #017e73;text-transform: uppercase;color: white;">Doctor</div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-lg-3 col-xlg-3">
        <a href="{{route('hospital.appointment.index')}}" class="text-decoration-none">
            <div class="card" style="position: relative;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: green;color: white;padding: 1px 10px;">{{$data["patient"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-user-plus"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #017e73;text-transform: uppercase;color: white;">All Patient</div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-lg-3 col-xlg-3">
        <a href="{{route('hospital.appointment.today')}}" class="text-decoration-none">
            <div class="card" style="position: relative;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: green;color: white;padding: 1px 10px;">{{$data["today"]->count()}}</span>
                <div class="text-center dashboard">
                    <i class="fa fa-user-plus"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #017e73;text-transform: uppercase;color: white;">Today Patient</div>
            </div>
        </a>
    </div>
</div>
@endsection