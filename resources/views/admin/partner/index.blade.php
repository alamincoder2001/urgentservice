@extends("layouts.app")

@section("title", "Admin Partner Page")

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
                <form id="addPartner">
                    <input type="hidden" id="partner_id" name="partner_id">
                    <div class="form-group">
                        <label for="name">Corporate Partner Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                        <span class="error-name error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="file" name="image" class="form-control image mb-2" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                        <span class="text-danger">(200 x 200)</span>
                        <div style="height:150px; position:relative;border:1px solid #bdbdbd;">
                            <img class="img" src="{{asset('noimage.jpg')}}" style="width: 100%;height:100%;position:absolute;">
                        </div>
                    </div>
                    <div class="form-group text-center pt-2">
                        <button type="submit" class="btn btn-success save px-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            @if(in_array("partner.index", $access))
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Corporate Partner Name</th>
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
    var editaccess = "{{in_array('partner.edit', $access)}}"
    var deleteaccess = "{{in_array('partner.destroy', $access)}}"

    function getData() {
        $.ajax({
            url: "{{route('partner.fetch')}}",
            method: "GET",
            dataType: "JSON",
            beforeSend: () => {
                $("tbody").html("")
            },
            success: response => {
                $.each(response, (index, value) => {
                    var tr = `
                            <tr>
                                <td>${++index}</td>
                                <td>${value.name}</td>
                                <td>
                                    <img width="40" src="${window.location.origin+"/"}${value.image}">
                                </td>
                                <td>
                                    <button value="${value.id}" class="fa fa-edit text-primary editPartner border-0" style="background:none;"></button>
                                    <button value="${value.id}" class="fa fa-trash text-danger deletePartner border-0" style="background:none;"></button>
                                </td>
                            </tr>
                        `
                    $('tbody').append(tr)
                })
            }
        })
    }
    getData();
    $("#addPartner").on("submit", event => {
        event.preventDefault()
        var formdata = new FormData(event.target)
        $.ajax({
            url: "{{route('partner.store')}}",
            method: "POST",
            dataType: "JSON",
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $("#addPartner").find(".error").text("");
            },
            success: (response) => {
                if (response.error) {
                    $.each(response.error, (index, value) => {
                        $("#addPartner").find(".error-" + index).text(value);
                    })
                } else {
                    $("#addPartner").trigger('reset')
                    $.notify(response, "success");
                    $(".save").text("Save").addClass("btn-success").removeClass("btn-primary")
                    $("#partner_id").val("");
                    $("#addPartner").find(".img").attr("src", "");
                    getData()
                }
            }
        })
    })

    $(document).on("click", ".editPartner", event => {
        $(".save").text("Update").addClass("btn-primary").removeClass("btn-success")
        $.ajax({
            url: "partner/" + event.target.value + "/edit",
            method: "GET",
            dataType: "JSON",
            beforeSend: () => {
                $("#addPartner").find(".error").text("");
                $("#addPartner").find(".image").val("")
            },
            success: response => {
                $.each(response, (index, value) => {
                    $("#addPartner").find("#" + index).val(value);
                })
                $("#partner_id").val(response.id);
                $(".img").prop("src", window.location.origin + "/" + response.image)
            }
        })

    })

    // delete department
    $(document).on("click", ".deletePartner", (event) => {
        if (confirm("Are you sure want to delete this data!")) {
            $.ajax({
                url: "{{route('partner.destroy')}}",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: event.target.value
                },
                success: (response) => {
                    $.notify(response, "success");
                    getData();
                }
            })
        }
    })
</script>
@endpush