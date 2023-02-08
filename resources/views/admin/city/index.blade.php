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
            @if(in_array("city.edit", $access))
            <div class="card-body">
                <form id="addCity">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name">City Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                        <span class="error-name error text-danger"></span>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="Save btn btn-success px-3">Save</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if(in_array("city.index", $access))
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
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push("js")
<script>
    var editaccess = "{{in_array('city.edit', $access)}}"
    var deleteaccess = "{{in_array('city.destroy', $access)}}"

    $(document).ready(() => {
        var table = $('#example').DataTable({
            // processing: true,
            ajax: "{{route('city.get')}}",
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
                            ${editaccess?'<button type="button" class="btn btn-primary btn-sm editCity" value="'+data.id+'">Edit</button>':''}            
                            ${deleteaccess?'<button type="button" class="btn btn-danger btn-sm deleteCity" value="'+data.id+'">Delete</button>':''}
                        `;
                    }
                }
            ],
        });

        $("#addCity").on("submit", (event) => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: location.origin+"/admin/city",
                data: formdata,
                method: "POST",
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#addCity").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#addCity").find(".error-" + index).text(value);
                        })
                    } else {
                        table.ajax.reload()
                        $("#addCity").trigger('reset')
                        $(".Save").text("Save").removeClass("bg-primary")
                        $.notify(response.msg, "success");
                    }
                }
            })
        })
        //edit department
        $(document).on("click", ".editCity", (event) => {
            $(".Save").text("Update").addClass("bg-primary")
            $.ajax({
                url: location.origin+"/admin/city-edit/"+event.target.value,
                method: "GET",
                beforeSend: () => {
                    $("#addCity").find("span").text("");
                },
                success: (response) => {
                    $.each(response, (index, value) => {
                        $("#addCity").find("#" + index).val(value);
                    })
                }
            })
        })
        // delete department
        $(document).on("click", ".deleteCity", (event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: location.origin+"/admin/city-delete/"+event.target.value,
                    method: "GET",
                    dataType: "JSON",
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