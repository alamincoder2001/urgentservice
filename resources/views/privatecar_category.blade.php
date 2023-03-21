@extends("layouts.master")
@push("js")
<style>
    /* =========== doctor card design ============ */
    .doctor_department {
        text-decoration: none;
        display: block;
        list-style: none;
        padding: 3px;
        font-family: auto;
        border-bottom: 1px dashed #d1d1d1;
        color: #626262;
        transition: 2ms ease-in-out;
    }

    .doctor_department:hover {
        color: red !important;
    }
</style>
@endpush
@section("content")
<section style="margin: 35px 0;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 col-md-12">
                <div class="row">
                    @foreach($category as $item)
                    <div class="col-lg-3 mb-4">
                        <a class="text-decoration-none" href="{{route('privatecar.details', $item->id)}}" title="{{$item->name}}">
                            <div class="card text-center position-relative" style="background: #63cbff;border: 0;">
                                <span style="color:white;position: absolute;top:-25px;right:0;background:red;padding:1px 8px;border-radius:50%;">{{$item->typewiseprivatecar->count()}}</span>
                                <div class="card-title">
                                    <img class="w-50" src="{{asset('frontend/img/privatecar.png')}}" alt="{{$item->name}}">
                                </div>
                                <div class="card-body text-white">
                                    {{$item->name}}
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