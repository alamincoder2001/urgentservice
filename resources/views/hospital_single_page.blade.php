@extends("layouts.master")

@push('style')
<style>
    /* =========== doctor card design ============ */
    .doctor_details .card {
        transition: 2ms ease-in-out;
    }

    .doctor_details .card:hover {
        border: 1px solid #d9d9d9 !important;
        box-shadow: 5px 3px 0px 3px #81818130 !important;
    }

    .doctor_department {
        text-decoration: none;
        display: block;
        list-style: none;
        padding: 4px;
        font-family: auto;
        margin-bottom: 5px;
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
<section id="appointment" style="padding: 25px 0;">
    <div class="container">
        <div class="singlehospital">
            <div class="card">
                <div class="card-header py-4" style="background: #0B1B67;height: 150px;display: flex;justify-content: center;align-items: center;">
                    <h2 class="text-white text-center">{{$data->name}}</h2>
                </div>
                <div class="card-body" style="position: relative;">
                    <div class="imghospital" style="width: 150px !important;position: absolute;top: -100px;">
                        <img src="{{asset($data->image?$data->image:'/frontend/img/hospital.png')}}" class="border rounded" style="width: 100%; height:145px;">
                    </div>
                    <div class="hospital-body" style="margin-top: 55px;">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-3 d-flex align-items-center justify-content-start">
                                <div class="phone d-flex align-items-center">
                                    <i class="fa fa-phone fs-3" style="background: #1ead29;color: white;padding: 6px 10px;margin-right:10px;"></i> <span> Hotline: 24 Hours <br>+880 {{substr($data->phone, 1)}}</span>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-center justify-content-start">
                                <div class="location d-flex align-items-center">
                                    <i class="fa fa-map-marker fs-3" style="background: #bf2c3a;color: white;padding: 5px 12px;margin-right:10px;"></i> <span>{{$data->address}}, {{$data->city->name}}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="map">
                                    {!!$data->map_link?$data->map_link:''!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-body doctor_details">
                <h5 class="text-center" style="text-decoration: underline;margin-bottom: 20px;">Related All Doctor</h5>
                <div class="row">
                    @if($data->hospital_wise_doctor->count())
                    @foreach($data->hospital_wise_doctor as $item)
                    <div class="col-12 col-lg-4 mb-3">
                        <a href="{{route('singlepagedoctor', $item->id)}}" target="_blank" class="text-decoration-none text-secondary" title="{{$item->name}}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="{{asset($item->image? $item->image:'/uploads/nouserimage.png')}}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>{{$item->doctor->name}}</h6>
                                        <p style="color:#c99913;">{{$item->doctor->department[0]->specialist->name}}, {{$item->doctor->city->name}}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;">{{mb_strimwidth($item->doctor->education, 0, 100, "...")}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center">Not Found Data</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <p style="text-align: justify;">
                    {!! $data->description !!}
                </p>
            </div>
        </div>

        <div class="newsletter">
            <h4 class="text-center mt-3">NEWS & EVENTS</h4>
            <p class="text-center">Find upcoming and ongoing medical conference, meetings, events
                medical fairs and trade shows near you</p>

            <div class="card mt-4">
                <div class="card-header" style="background: #023256;">
                    <h4 class="text-white">GET IN TOUCH</h4>
                </div>
                <div class="card-body">
                    <form class="addContact">
                        <input type="hidden" id="hospital" name="hospital" value="hospital">
                        <input type="hidden" id="hospital_id" name="hospital_id" value="{{$data->id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                    <span class="error-name error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                    <span class="error-email error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">Contact</label>
                                    <input type="text" name="phone" class="form-control" placeholder="+880 1737 484046">
                                    <span class="error-phone error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" name="subject" class="form-control" placeholder="Subject">
                                    <span class="error-subject error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control" name="message" placeholder="Message"></textarea>
                                    <span class="error-message error text-danger"></span>
                                </div>
                            </div>
                            <div class="clearfix border-top mt-3"></div>
                            <div class="form-group mt-3 text-center">
                                <button type="submit" class="btn btn-outline-primary">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@push("js")
<script>
    $(document).ready(() => {
        $("iframe").attr("width", "100%").attr("height", "80%");

        // Hospital store
        $(".addContact").on("submit", event => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('hospitaldiagnosticcontact')}}",
                method: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                beforeSend: () => {
                    $(".addContact").find(".error").text("")
                },
                success: response => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $(".addContact").find(".error-" + index).text(value)
                        })
                    } else {
                        $(".addContact").trigger("reset")
                        $.notify(response, "success");
                    }
                }
            })
        })
    })
</script>
@endpush