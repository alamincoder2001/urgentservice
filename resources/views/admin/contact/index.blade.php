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
                                <input type="email" class="form-control" id="email" name="email">
                                <span class="error-email text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <div class="input-group">
                                    <p class="btn btn-secondary m-0">+88</p><input type="text" name="phone" id="phone" class="form-control">
                                </div>
                                <span class="error-phone text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" class="form-control" name="address"></textarea>
                                <span class="error-address text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="map_link">Map Link</label>
                                <textarea id="map_link" class="form-control" name="map_link"></textarea>
                                <span class="error-map_link text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <img class="img border" style="width: 100%;height:100%;">
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
    $(document).ready(() => {
        function getData() {
            $.ajax({
                url: "{{route('admin.contact.get')}}",
                method: "GET",
                dataType: "JSON",
                success: (response) => {
                    $("#contactAdd").find("#email").val(response.email)
                    $("#contactAdd").find("#phone").val(response.phone)
                    $("#contactAdd").find("#address").val(response.address)
                    $("#contactAdd").find("#map_link").val(response.map_link)
                    $("#contactAdd").find(".img").attr("src", window.location.protocol+"/"+ response.image)
                }
            })
        }
        getData();

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
                        getData();
                        $("#contactAdd").trigger('reset')
                        $.notify(response, "success");
                    }
                }
            })
        })
    })
</script>
@endpush