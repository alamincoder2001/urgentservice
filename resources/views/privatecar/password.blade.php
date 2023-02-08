@extends("layouts.privatecar.app")

@section("title", "Private password change")

@section("content")

<div class="row d-flex justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <form id="updateImage">
                <div class="form-group text-center">
                    <img class="img" src="{{asset(Auth::guard('privatecar')->user()->image != '0' ? Auth::guard('privatecar')->user()->image : '/noimage.jpg')}}" width="100">
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary px-3 mt-3">Update</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card" style="height: 296px;">
            <form id="updatePassword">
                <div class="row">
                    <div class="form-group">
                        <label for="password">Current Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control"><i class="fa fa-key btn btn-danger d-flex align-items-center justify-content-center"></i>
                        </div>
                        <span class="error-password error text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="input-group">
                                <input type="password" name="new_password" id="new_password" class="form-control"><i class="fa fa-key btn btn-danger d-flex align-items-center justify-content-center"></i>
                            </div>
                            <span class="error-new_password error text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"><i class="fa fa-key btn btn-danger d-flex align-items-center justify-content-center"></i>
                            </div>
                            <span class="error-confirm_password error text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary px-3 mt-3">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push("js")
<script>
    $(document).ready(() => {
        $("#updatePassword").on("submit", (event) => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('privatecar.password.update')}}",
                data: formdata,
                method: "POST",
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#updatePassword").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#updatePassword").find(".error-" + index).text(value);
                        })
                    } else if (response.errors) {
                        $.notify(response.errors);
                    } else {
                        $("#updatePassword").trigger("reset")
                        $.notify(response, "success");
                    }
                }
            })
        })
        $("#updateImage").on("submit", (event) => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('privatecar.image.update')}}",
                data: formdata,
                method: "POST",
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: (response) => {
                    $.notify(response, "success");
                }
            })
        })
    })
</script>
@endpush