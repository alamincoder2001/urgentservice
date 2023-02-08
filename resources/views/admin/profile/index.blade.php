@extends("layouts.app")

@section("title", "Admin Profile")

@section("content")

<div class="row">
    <!-- Column -->
    <div class="col-12 col-lg-6">
        <div class="card adminprofile">
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <form id="FormAdmin" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                        <span class="error-name text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                        <span class="error-email text-danger"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-4 pe-0">
                            <img class="img" style="width:100px; height:100px;" />
                        </div>
                        <div class="col-md-8 d-flex align-items-center pe-0">
                            <div class="form-group mb-0">
                                <input type="file" class="form-control" id="image" name="image" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success px-2 text-white">Save Profile</button>
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
                url: "{{route('getadmin.profile')}}",
                method: "GET",
                dataType: "JSON",
                beforeSend: () => {
                    $(".adminprofile").html("");
                },
                success: (response) => {
                    $("#FormAdmin").find("#name").val(response.name);
                    $("#FormAdmin").find("#email").val(response.email);
                    $("#FormAdmin").find(".img").prop("src", window.location.origin + '/' + response.image);
                    var row = `
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="image" style="width: 135px;height: 135px;border: 1px solid #ebebeb;">
                                            <img style="width: 100%; height:100%;" src="${window.location.origin +'/'+response.image}" alt="${response.name}">
                                        </div>
                                    </div>
                                    <div class="col-md-8 d-flex align-items-center">
                                        <div class="details">
                                            <span class="bg-dark text-white px-2 py-1 rounded-pill">Name:</span> ${response.name}
                                            <br>
                                            <br>
                                            <span class="bg-dark text-white px-2 py-1 rounded-pill">Email:</span> ${response.email}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `
                    $(".adminprofile").append(row)
                    $("#adminIcon").prop("src", window.location.origin + '/' + response.image);
                }
            })
        }
        getData()

        $("#FormAdmin").on("submit", (event) => {
            event.preventDefault()
            var formdata = new FormData($("#FormAdmin")[0]);

            $.ajax({
                url: "{{route('saveadmin.profile')}}",
                data: formdata,
                method: "POST",
                dataType: "JSON",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#FormAdmin").find("span").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#FormAdmin").find(".error-" + index).text(value);
                        })
                    } else {
                        getData();
                        $("#FormAdmin").trigger('reset')
                        $.notify(response, "success");
                    }
                }
            })
        })
    })
</script>
@endpush