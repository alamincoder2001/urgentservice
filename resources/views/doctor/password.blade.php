@extends("layouts.doctor.app")

@section("title", "Doctor Dashboard")

@section("content")
<div class="row d-flex justify-content-center">
  <div class="col-xl-3 text-center">
    <div class="card">
      <div class="card-body">
        <div class="image">
          <img src="{{asset(Auth::guard('doctor')->user()->image != '0' ? Auth::guard('doctor')->user()->image: 'noImage.jpg')}}" width="130" class="img border rounded p-1">
        </div>
        <form id="ImageUpdate">
          <div class="form-group">
            <label for="image">Doctor Image</label>
            <input type="file" class="form-control" id="image" name="image" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary px-1">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-xl-6">
    <div class="card" style="height: 300px;">
      <div class="card-heading text-center">
        <h4 class="card-title">Change Password</h4>
      </div>
      <div class="card-body">
        <form id="PasswordUpdate">
          <div class="input-group">
            <input type="password" name="password" class="form-control" id="password" placeholder="Current Password"><span class="btn btn-secondary text-white"><i class="fas fa-key"></i></span>
          </div>
          <span class="error-password error text-danger"></span>
          <div class="row">
            <div class="col-md-6 col-lg-6">
              <div class="input-group mt-4">
                <span class="btn btn-danger text-white"><i class="fas fa-key"></i></span><input type="password" name="new_password" class="form-control" id="new_password" placeholder="New Password">
              </div>
              <span class="error-new_password error text-danger"></span>
            </div>
            <div class="col-md-6 col-lg-6">
              <div class="input-group mt-4">
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Retype Password"><span class="btn btn-danger text-white"><i class="fas fa-key"></i></span>
              </div>
              <span class="error-confirm_password error text-danger"></span>
            </div>
          </div>
          <div class="form-group text-center mt-3">
            <button type="submit" class="btn btn-success px-3 text-uppercase text-white">Change</button>
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
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $("#PasswordUpdate").on("submit", (event) => {
      event.preventDefault()
      var formdata = new FormData(event.target)
      $.ajax({
        url: "{{route('doctor.doctor.passwordupdate')}}",
        method: "POST",
        dataType: "JSON",
        data: formdata,
        contentType: false,
        processData: false,
        beforeSend: () => {
          $("#PasswordUpdate").find('.error').text("");
        },
        success: (res) => {
          if (res.error) {
            $.each(res.error, (index, value) => {
              $("#PasswordUpdate").find(".error-" + index).text(value);
            })
          } else {
            if (res.errors) {
              $("#PasswordUpdate").find(".error-password").text(res.errors);
              return
            }
            $("#PasswordUpdate").trigger("reset")
            $.notify(res, "success");
          }
        }
      })
    })
    $("#ImageUpdate").on("submit", (event) => {
      event.preventDefault()
      var formdata = new FormData(event.target)
      $.ajax({
        url: "{{route('doctor.doctor.imageUpdate')}}",
        method: "POST",
        dataType: "JSON",
        data: formdata,
        contentType: false,
        processData: false,
        success: (response) => {
          $("#ImageUpdate").trigger("reset")
          $.notify(response, "success");
        }
      })
    })
  })
</script>
@endpush