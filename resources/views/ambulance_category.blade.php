@extends("layouts.master")
@section("content")
@php
    $ambulance_type = ["ICU", "NICU", "Freezing", "AC", "NON-AC"];
@endphp
<section style="margin: 35px 0;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 col-md-12">
                <div class="row">
                    @foreach($ambulance_type as $item)
                    <div class="col-lg-3 mb-4">
                        <a class="text-decoration-none" href="{{route('privatecar.details', $item)}}" title="{{$item}}">
                            <div class="card text-center position-relative" style="background: #63cbff;border: 0;">
                                <span style="color:white;position: absolute;top:-25px;right:0;background:red;padding:1px 8px;border-radius:50%;">0</span>
                                <div class="card-title">
                                    <img class="w-50" src="{{asset('frontend/img/privatecar.png')}}" alt="{{$item}}">
                                </div>
                                <div class="card-body text-white">
                                    {{$item}}
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection