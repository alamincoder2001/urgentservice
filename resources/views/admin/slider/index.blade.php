@extends("layouts.app")

@section("title", "Admin Slider Page")

@section("content")
@php
$access = App\Models\UserAccess::where('user_id', Auth::guard('admin')->user()->id)
->pluck('permissions')
->toArray();
@endphp
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <form id="addSlider">
                    <div class="form-group">
                        <label for="title">Slider Title</label>
                        <input type="text" id="title" name="title" class="form-control">
                        <span class="error-title error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="short_text">Short Text</label>
                        <textarea name="short_text" id="short_text" class="form-control"></textarea>
                        <span class="error-short_text error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="file" name="image" class="form-control mb-2" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                        <span class="text-danger">(1900 x 850)</span>
                        <div style="height:200px; position:relative;border:1px solid #bdbdbd;">
                            <img class="img" src="{{asset('noimage.jpg')}}" style="width: 100%;height:100%;position:absolute;">
                        </div>
                    </div>
                    <div class="form-group text-center pt-2">
                        <button type="submit" class="btn btn-success px-3">Save</button>
                    </div>
                </form>
                <form id="updateSlider" class="d-none">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="title">Slider Title</label>
                        <input type="text" id="title" name="title" class="form-control">
                        <span class="error-title error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="short_text">Short Text</label>
                        <textarea name="short_text" id="short_text" class="form-control"></textarea>
                        <span class="error-short_text error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="file" name="image" class="form-control mb-2" onchange="document.querySelector('.image').src = window.URL.createObjectURL(this.files[0])">
                        <span class="text-danger">(1900 x 850)</span>
                        <div style="height:200px; position:relative;border:1px solid #bdbdbd;">
                            <img class="image" style="width: 100%;height:100%;position:absolute;">
                        </div>
                    </div>
                    <div class="form-group text-center pt-2">
                        <button type="submit" class="btn btn-primary px-3">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            @if(in_array("slider.index", $access))
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Title</th>
                        <th>Short Detals</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection

@push("js")
<script>
    var editaccess = "{{in_array('slider.edit', $access)}}"
    var deleteaccess = "{{in_array('slider.destroy', $access)}}"

    function getData() {
        $.ajax({
            url: "{{route('slider.create')}}",
            method: "GET",
            beforeSend: () => {
                $("tbody").html("")
            },
            success: response => {
                $.each(response, (index, value) => {
                    var tr = `
                            <tr>
                                <td>${++index}</td>
                                <td>${value.title}</td>
                                <td>${value.short_text}</td>
                                <td>
                                    <img width="40" src="${window.location.origin+"/"}${value.image}">
                                </td>
                                <td>
                                    ${editaccess?'<button type="button" class="btn btn-primary btn-sm editSlider border-0" value="'+value.id+'">Edit</button>':''}
                                    ${deleteaccess?'<button type="button" class="btn btn-danger btn-sm deleteSlider border-0" value="'+value.id+'">Delete</button>':''}
                                </td>
                            </tr>
                        `
                    $('tbody').append(tr)
                })
            }
        })
    }
    getData();
    $("#addSlider").on("submit", event => {
        event.preventDefault()
        var formdata = new FormData(event.target)
        $.ajax({
            url: "{{route('slider.store')}}",
            method: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $("#addSlider").find(".error").text("");
            },
            success: (response) => {
                if (response.error) {
                    $.each(response.error, (index, value) => {
                        $("#addSlider").find(".error-" + index).text(value);
                    })
                } else {
                    $("#addSlider").trigger('reset')
                    $.notify(response, "success");
                    $("#addSlider").find(".img").attr("src", location.origin + "/noimage.jpg");
                    getData()
                }
            }
        })
    })

    $(document).on("click", ".editSlider", event => {
        $("#addSlider").addClass("d-none")
        $("#updateSlider").removeClass("d-none")
        $.ajax({
            url: "slider/" + event.target.value + "/edit",
            method: "GET",
            beforeSend: () => {
                $("#updateSlider").find(".error").text("");
            },
            success: response => {
                $.each(response, (index, value) => {
                    $("#updateSlider").find("#" + index).val(value);
                })
                $(".image").prop("src", location.origin + "/" + response.image)
            }
        })

    })
    $("#updateSlider").on("submit", event => {
        event.preventDefault()
        var formdata = new FormData(event.target)
        $.ajax({
            url: "{{route('slider.update')}}",
            method: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $("#updateSlider").find(".error").text("");
            },
            success: (response) => {
                if (response.error) {
                    $.each(response.error, (index, value) => {
                        $("#updateSlider").find(".error-" + index).text(value);
                    })
                } else {
                    $("#addSlider").removeClass("d-none")
                    $("#updateSlider").addClass("d-none")
                    $("#updateSlider").trigger('reset')
                    $.notify(response, "success");
                    $("#addSlider").find(".img").attr("src", location.origin + "/noimage.jpg");
                    getData()
                }
            }
        })
    })

    // delete department
    $(document).on("click", ".deleteSlider", (event) => {
        if (confirm("Are you sure want to delete this data!")) {
            $.ajax({
                url: "{{route('slider.destroy')}}",
                method: "POST",
                data: {
                    id: event.target.value
                },
                success: (response) => {
                    $.notify(response, "success");
                    getData()
                }
            })
        }
    })
</script>
@endpush