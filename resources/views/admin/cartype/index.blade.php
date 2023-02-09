@extends("layouts.app")

@section("title", "Admin Car Type Page")

@section("content")

<div class="row d-flex justify-content-center">
    <div class="col-md-4">
        <div class="card mb-0">
            <div class="card-body">
                <form id="addCartype">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name">Car Type</label>
                        <input type="text" id="name" name="name" class="form-control">
                        <span class="error-name error text-danger"></span>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="Save btn btn-success px-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>City Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push("js")
<script>
    $(document).ready(() => {
        var table = $('#example').DataTable({
            // processing: true,
            ajax: "{{route('cartype.fetch')}}",
            columns: [{
                    data: 'id',
                },
                {
                    data: 'name',
                },
                {
                    data: null,
                    render: (data) => {
                        return `
                            <button type="button" class="btn btn-primary btn-sm editCartype" value="${data.id}">Edit</button>           
                            <button type="button" class="btn btn-danger btn-sm deleteCartype" value="${data.id}">Delete</button>
                        `;
                    }
                }
            ],
        });

        $("#addCartype").on("submit", (event) => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: location.origin + "/admin/cartype",
                method: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                dataType: "JSON",
                beforeSend: () => {
                    $("#addCartype").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#addCartype").find(".error-" + index).text(value);
                        })
                    } else {
                        table.ajax.reload()
                        $("#addCartype").trigger('reset')
                        $(".Save").text("Save").removeClass("bg-primary")
                        $.notify(response.msg, "success");
                    }
                }
            })
        })
        //edit department
        $(document).on("click", ".editCartype", (event) => {
            $(".Save").text("Update").addClass("bg-primary")
            $.ajax({
                url: location.origin + "/admin/cartype/" + event.target.value+"/edit",
                method: "GET",
                beforeSend: () => {
                    $("#addCartype").find("span").text("");
                },
                success: (response) => {
                    $.each(response, (index, value) => {
                        $("#addCartype").find("#" + index).val(value);
                    })
                }
            })
        })
        // delete department
        $(document).on("click", ".deleteCartype", (event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: location.origin + "/admin/cartype/delete",
                    method: "POST",
                    data:{id:event.target.value},
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