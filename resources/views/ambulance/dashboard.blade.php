@extends("layouts.ambulance.app")
@section("title", "Ambulance Dashboard")

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
    <div class="col-md-4 col-lg-4 col-xlg-3">
        <a href="" class="text-decoration-none">
            <div class="card" style="position: relative;">
                <span style="border-bottom-left-radius: 25%;position: absolute;top: 0;right: 0;background: green;color: white;padding: 1px 10px;">1</span>
                <div class="text-center dashboard">
                    <i class="fa fa-ambulance"></i>
                </div>
                <div class="text-center" style="margin-top: 8px;background: #017e73;text-transform: uppercase;color: white;">Ambulance</div>
            </div>
        </a>
    </div>
</div>
@endsection