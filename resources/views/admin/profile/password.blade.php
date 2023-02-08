@extends("layouts.app")

@section("title", "Change Password")

@section("content")
<div class="row d-flex justify-content-center">
    <div class="col-md-6 col-lg-6">
        <div class="card">
            <div class="card-heading text-center">
                <h4 class="card-title">Change Password</h4>
            </div>
            <div class="card-body">
                <form id="submitPassword">
                    <div class="form-group">
                        <div class="d-flex align-items-center">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Current Password"><i class="btn btn-secondary fas fa-key"></i>
                            </div>
                        </div>
                        <span class="error-password error text-danger"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <div class="input-group">
                                        <i class="btn btn-danger fas fa-key"></i><input type="password" name="new_password" class="form-control" id="new_password" placeholder="New Password">
                                    </div>
                                </div>
                                <span class="error-new_password error text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <div class="input-group">
                                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Retype Password"><i class="btn btn-danger fas fa-key"></i>
                                    </div>
                                </div>
                                <span class="error-confirm_password error text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-success px-3 text-uppercase text-white">Change</button>
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
        $("#submitPassword").on("submit", (event) => {
            event.preventDefault()

            var formdata = new FormData($("#submitPassword")[0]);
            $.ajax({
                url: "{{route('changeadmin.password')}}",
                method: "POST",
                dataType: "JSON",
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#submitPassword").find(".error").text("")
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#submitPassword").find(".error-" + index).text(value)
                        })
                    }else if(response.errors){
                        $.notify(response.errors);
                    }else {
                        $.notify(response, "success");
                        $("#submitPassword").trigger("reset");
                    }
                }
            })
        })
    })
</script>
@endpush