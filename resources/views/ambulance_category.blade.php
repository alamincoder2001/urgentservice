@extends("layouts.master")
@section("content")
<section style="margin: 35px 0;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 col-md-12">
                <div class="row">
                    @foreach($data as $item)
                    <div class="col-lg-3 mb-4">
                        <a class="text-decoration-none" href="{{route('ambulance.details', $item->ambulance_type)}}" title="{{$item->ambulance_type}}">
                            <div class="card text-center position-relative" style="background: #63cbff;border: 0;">
                                <span style="color:white;position: absolute;top:-25px;right:0;background:red;padding:1px 8px;border-radius:50%;">{{\App\Models\Ambulance::TotalTypeWiseAmbulance($item->ambulance_type)}}</span>
                                <div class="card-title">
                                    <img class="w-50" src="{{asset('frontend/img/ambulance.png')}}" alt="{{$item->ambulance_type}}">
                                </div>
                                <div class="card-body text-white">
                                    {{$item->ambulance_type}}
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