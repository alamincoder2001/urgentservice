@extends("layouts.app")

@section("title", "Admin Department Page")

@section("content")
@php
$access = App\Models\UserAccess::where('user_id', Auth::guard('admin')->user()->id)
->pluck('permissions')
->toArray();
@endphp
<div class="row d-flex justify-content-center">
    <div class="col-md-4">
        <div class="card mb-0">
            @if(in_array("department.edit", $access))
            <div class="card-body">
                <form id="addDepartment">
                    <div class="form-group">
                        <label for="name">Department Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Ex: Paediatric Surgery">
                        <span class="error-name error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="file" name="image" class="form-control image mb-2" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                        <span class="text-danger">(200 x 200)</span>
                        <div style="height:150px; position:relative;border:1px solid #bdbdbd;">
                            <img class="img" src="{{asset('noimage.jpg')}}" style="width: 100%;height:100%;position:absolute;">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success px-3">Save</button>
                    </div>
                </form>
                <form id="updateDepartment" class="d-none">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="name">Department Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                        <span class="error-name error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="file" name="image" class="form-control image mb-2" onchange="document.querySelector('.img1').src = window.URL.createObjectURL(this.files[0])">
                        <span class="text-danger">(200 x 200)</span>
                        <div style="height:150px; position:relative;border:1px solid #bdbdbd;">
                            <img class="img1" style="width: 100%;height:100%;position:absolute;">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-info px-3">Update</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if(in_array("department.index", $access))
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
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
</div>

@endsection

@push("js")
<script>
    var editaccess = "{{in_array('department.edit', $access)}}"
    var deleteaccess = "{{in_array('department.destroy', $access)}}"

    $(document).ready(() => {
        var table = $('#example').DataTable({
            // processing: true,
            ajax: "{{route('department.get')}}",
            columns: [{
                    data: 'id',
                },
                {
                    data: 'name',
                },
                {
                    data: null,
                    render: data => {
                        return `<img src="${location.origin}/${data.image}" width="40" />`;
                    }
                },
                {
                    data: null,
                    render: (data) => {
                        return `
                            ${editaccess?'<button type="button" class="btn btn-primary btn-sm editDepartment" value="'+data.id+'">Edit</button>':''}            
                            ${deleteaccess?'<button type="button" class="btn btn-danger btn-sm deleteDepartment" value="'+data.id+'">Delete</button>':''}
                        `;
                    }
                }
            ],
        });

        $("#addDepartment").on("submit", (event) => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('department.store')}}",
                data: formdata,
                method: "POST",
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#addDepartment").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#addDepartment").find(".error-" + index).text(value);
                        })
                    } else {
                        table.ajax.reload()
                        $("#addDepartment").trigger('reset')
                        $("#addDepartment").find(".img").prop("src", location.origin+"/noImage.jpg");
                        $.notify(response.msg, "success");
                    }
                }
            })
        })
        //edit department
        $(document).on("click", ".editDepartment", (event) => {
            $("#updateDepartment").removeClass("d-none")
            $("#addDepartment").addClass("d-none")
            $.ajax({
                url: "{{route('department.edit')}}",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: event.target.value
                },
                beforeSend: () => {
                    $("#updateDepartment").find("span").text("");
                },
                success: (response) => {
                    $.each(response, (index, value) => {
                        $("#updateDepartment").find("#" + index).val(value);
                    })
                    if (response.image) {
                        $("#updateDepartment").find(".img1").prop("src", location.origin+"/"+response.image);
                    }else{
                        $("#updateDepartment").find(".img1").prop("src", location.origin+"/noImage.jpg");
                    }
                }
            })
        })
        //update department
        $("#updateDepartment").on("submit", (event) => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('department.update')}}",
                data: formdata,
                method: "POST",
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#updateDepartment").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#updateDepartment").find(".error-" + index).text(value);
                        })
                    } else {
                        table.ajax.reload()
                        $("#updateDepartment").trigger('reset')
                        $("#addDepartment").removeClass("d-none")
                        $("#updateDepartment").addClass("d-none")
                        $.notify(response, "success");
                        $("#updateDepartment").find(".img1").prop("src", location.origin+"/noImage.jpg");
                    }
                }
            })
        })
        // delete department
        $(document).on("click", ".deleteDepartment", (event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: "{{route('department.destroy')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        id: event.target.value
                    },
                    success: (response) => {
                        $.notify(response, "success");
                        table.ajax.reload();
                    }
                })
            }
        })
    })
</script>
@endpush