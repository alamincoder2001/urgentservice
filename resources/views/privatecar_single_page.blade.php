@extends("layouts.master")

@push("style")
<style>
    #appointment .appointment-banner {
        background-color: #023256;
        padding: 60px 0;
        margin-top: 25px;
        text-align: center;
    }

    #appointment .phone i {
        background: lightblue;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 11px;
        font-size: 16px;
        font-weight: 600;
        color: green;
    }

    #appointment .location i {
        background: lightblue;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        font-size: 18px;
        font-weight: 600;
        color: #ff2300;
    }

    #appointment .email i {
        background: lightblue;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 9px;
        font-size: 16px;
        font-weight: 600;
        color: #008585;
    }
</style>
@endpush

@section("content")
<section id="appointment" style="padding: 25px 0;">
    <div class="container">

        <div class="newsletter">
            <div class="card mt-1">
                <div class="card-header" style="background: #023256;">
                    <h4 class="text-white">Hire An Privatecar</h4>
                </div>
                <div class="card-body">
                    <form id="addPrivatecar">
                        <input type="hidden" name="id" id="id" value="{{$data->id}}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group my-2">
                                    <label for="privatecar_type">Privatecar Type: <span class="text-danger">*</span></label>
                                    <select id="privatecar_type" name="privatecar_type" class="form-control" style="cursor: pointer;">
                                        <option label="Select privatecar Type"></option>
                                        @foreach($data->typewisecategory as $private)
                                        <option value="{{$private->cartype->id}}">{{$private->cartype->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-privatecar_type error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group my-2">
                                    <label for="departing_date">Departing Date: <span class="text-danger">*</span></label>
                                    <input type="text" name="departing_date" class="form-control departing_date" value="{{date('d-m-Y')}}">
                                    <span class="error-departing_date error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group my-2">
                                    <label for="name">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Your Name">
                                    <span class="error-name error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group my-2">
                                    <label for="phone">Your Contact: <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <i class="btn btn-secondary">+88</i><input type="text" name="phone" id="phone" class="form-control" placeholder="017########">
                                    </div>
                                    <span class="error-phone error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label for="from">From: <span class="text-danger">*</span></label>
                                    <input type="text" name="from" id="from" class="form-control" placeholder="Full address">
                                    <span class="error-from error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label for="to">To: <span class="text-danger">*</span></label>
                                    <input type="text" name="to" id="to" class="form-control" placeholder="Full address">
                                    <span class="error-to error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-2">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Your Email">
                                    <span class="error-email error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-between">
                                <div class="form-check my-2">
                                    <input class="form-check-input" value="single" type="radio" name="trip" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Single Trip
                                    </label>
                                </div>
                                <div class="form-check my-2">
                                    <input class="form-check-input" value="round" type="radio" name="trip" id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Round Trip
                                    </label>
                                </div>
                            </div>
                            <div style="display: block;">
                                <span class="error-trip error text-danger"></span>
                            </div>
                            <div class="clearfix border-top mt-3"></div>
                            <div class="form-group d-grid mt-3">
                                <button type="submit" class="btn btn-outline-primary">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mt-md-0">
                <div class="card" style="height: 395px;">
                    <div class="card-header" style="background: #023256;">
                        <h4 class="text-white">Contact</h4>
                    </div>
                    <div class="card-body">
                        <div class="phone d-flex align-items-center gap-3 mb-3">
                            <i class="fa fa-phone"></i><span>+880 {{substr($data->phone, 1)}}</span>
                        </div>
                        <div class="location d-flex align-items-center gap-3 mb-3">
                            <i class="fa fa-map-marker"></i><span>{{$data->address}}, {{$data->city->name}}</span>
                        </div>
                        <div class="email d-flex align-items-center gap-3 mb-3">
                            <i class="fa fa-envelope-o"></i><span>{{$data->email}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-md-0 mt-2">
                <div class="card">
                    <div class="card-header" style="background: #023256;">
                        <h4 class="text-white">Find Us On Google Map</h4>
                    </div>
                    <div class="card-body">
                        {!! $data->map_link !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
@endsection

@push("js")
<script>
    $(".departing_date").datepicker({
        format: "dd-mm-yyyy",
        startDate: new Date(),
        orientation: 'bottom'
    })
    $(document).ready(() => {
        $("iframe").attr("width", "100%").attr("height", "300px !important");

        $("#addPrivatecar").on("submit", event => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('hire.privatecar')}}",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#addPrivatecar").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#addPrivatecar").find(".error-" + index).text(value);
                        })
                    } else {
                        $("#addPrivatecar").trigger('reset')
                        $.notify(response, "success");
                    }
                }
            })
        })
    })
</script>
@endpush