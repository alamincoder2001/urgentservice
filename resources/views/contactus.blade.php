@extends("layouts.master")
@push("style")
<style>
    .contact-heading {
        background-image: url("{{asset('frontend')}}/img/contactus.jpg");
        background-size: 100% 100%;
        background-position: center;
        background-repeat: no-repeat;
        height: 235px;
    }

    #contact-us .contact-body i {
        font-size: 35px;
        font-weight: 900;
    }

    #contact-us .contact-body .fa-phone {
        color: #00aba3;
    }

    #contact-us .contact-body .fa-map-marker {
        color: #F60002;
    }

    #contact-us .contact-body .fa-envelope-o {
        color: #168BE4;
    }

    #contact-us .contact-body small {
        color: #8d8d8dcf;
    }
</style>
@endpush
@section("content")
@php
$data = App\Models\Contact::first();
@endphp
<section id="contact-us">
    <div class="contact-heading d-flex align-items-center justify-content-start text-white" style="background: url('{{asset($data->image)}}');">
        <div class="container">
            <h2 class="text-uppercase">Contact with Us</h2>
        </div>
    </div>

    <div class="container contact-body">
        <div class="row py-5">
            <div class="col-md-4 text-center mt-3 mt-md-0">
                <i class="fa fa-phone"></i>
                <h4>Call Us</h4>
                <small>Phone: {{$data->phone}}</small>
            </div>
            <div class="col-md-4 text-center mt-3 mt-md-0">
                <i class="fa fa-map-marker"></i>
                <h4>Address</h4>
                <small>{{$data->address}}</small>
            </div>
            <div class="col-md-4 text-center mt-3 mt-md-0">
                <i class="fa fa-envelope-o"></i>
                <h4>Email</h4>
                <small>{{$data->email}}</small>
            </div>
        </div>
    </div>

    <div class="contact-form" style="background: #f3f3f3;">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-7">
                    <form class="addContact">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group py-2 py-md-0">
                                    <label for="name">Name <span class="text-danger fs-4">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                    <span class="error-name error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group py-2 py-md-0">
                                    <label for="email">Email <span class="text-danger fs-4">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email">
                                    <span class="error-email error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group py-2 py-md-3">
                                    <label for="phone">Phone <span class="text-danger fs-4">*</span></label>
                                    <input type="text" name="phone" class="form-control" placeholder="+880">
                                    <span class="error-phone error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group py-2 py-md-3">
                                    <label for="message">Message <span class="text-danger fs-4">*</span></label>
                                    <textarea class="form-control" name="message" placeholder="Message"></textarea>
                                    <span class="error-message error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group py-2 py-md-3">
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <button type="submit" class="btn btn-outline-success">Send Message</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-5 mt-2 mt-md-0">
                    {!!$data->map_link!!}
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@push("js")
<script>
    $("iframe").css({
        width: "100%",
        height: "100%",
        border: "1px solid #e3dddd"
    })

    $(".addContact").on("submit", event => {
        event.preventDefault()
        var formdata = new FormData(event.target)
        $.ajax({
            url: "{{route('companycontact')}}",
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
                    $(".addContact").find(".img").prop("src", location.origin+"/noimage.jpg")
                }
            }
        })
    })
</script>
@endpush