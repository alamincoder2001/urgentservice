@extends("layouts.app")
@section("title", "Admin- Setting page")

@section("content")

<div class="row d-flex justify-content-center align-items-center">
    <div class="col-md-10">
        <div class="card p-5">
            <div class="card-heading">
                <div class="card-title text-center">
                    Contact Us Setting
                </div>
            </div>

            <div class="card-body">
                <form id="contactAdd">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{$data->email}}">
                                <span class="error-email text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">Phone <i class="fa fa-plus" onclick="phoneAdd()"></i></label>
                                <div class="phoneadd">
                                    @php
                                        $phoneall = explode(",", $data->phone);
                                    @endphp
                                    @foreach($phoneall as $item)
                                    <div class="input-group">
                                        <input type="text" id="phone" name="phone[]" value="{{$item}}" class="form-control">
                                        <button type="button" class="btn btn-danger removePhone"><i class="fa fa-trash"></i></button>
                                    </div>
                                    @endforeach
                                </div>
                                <span class="error-phone text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" class="form-control" name="address">{{$data->address}}</textarea>
                                <span class="error-address text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="map_link">Map Link</label>
                                <textarea id="map_link" class="form-control" name="map_link">{{$data->map_link}}</textarea>
                                <span class="error-map_link text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <img src="{{asset($data->image != '0' ? $data->image : 'noimage.jpg')}}" class="img border" style="width: 100%;height:100%;">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image">Contact Image</label>
                                <input type="file" name="image" class="form-control" id="image" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>
                        <div class="form-group text-center mt-4">
                            <button class="btn btn-primary px-3">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push("js")
<script>
    $("#contactAdd").on("submit", (event) => {
        event.preventDefault()

        var formdata = new FormData(event.target);
        // console.log(event);
        $.ajax({
            url: "{{route('admin.contact.store')}}",
            method: "POST",
            dataType: "JSON",
            data: formdata,
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: () => {
                $("#contactAdd").find("span").text("");
            },
            success: (response) => {
                if (response.error) {
                    $.each(response.error, (index, value) => {
                        $("#contactAdd").find(".error-" + index).text(value);
                    })
                } else {
                    $.notify(response, "success");
                }
            }
        })
    })

    function phoneAdd() {
        var row = `
            <div class="input-group">
                <input type="text" id="phone" name="phone[]" class="form-control">
                <button type="button" class="btn btn-danger removePhone"><i class="fa fa-trash"></i></button>
            </div>
        `
        $(".phoneadd").append(row)
    }

    $(document).on("click", ".removePhone", event => {
        event.target.offsetParent.remove();
    })
</script>
@endpush