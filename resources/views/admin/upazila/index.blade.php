@extends("layouts.app")

@section("title", "Admin Upazila Page")
@section("content")
<div class="row d-flex justify-content-center">
    <div class="col-md-4">
        <div class="card mb-0">
            <div class="card-body">
                <form id="addUpazila">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name">Upazila Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                        <span class="error-name error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="district_id">City Name</label>
                        <select id="district_id" name="district_id" class="form-control">
                            <option value="">Select City</option>
                            @foreach($cities as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-district_id error text-danger"></span>
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
                            <th>Upazila Name</th>
                            <th>Disctrict</th>
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
            ajax: "{{route('upazila.get')}}",
            columns: [{
                    data: 'id',
                },
                {
                    data: 'name',
                },
                {
                    data: null,
                    render: data => {
                        return data.district.name;
                    }
                },
                {
                    data: null,
                    render: (data) => {
                        return `
                           <button type="button" class="btn btn-primary btn-sm editUpazila" value="${data.id}">Edit</button>           
                            <button type="button" class="btn btn-danger btn-sm deleteUpazila" value="${data.id}">Delete</button>
                        `;
                    }
                }
            ],
        });

        $("#addUpazila").on("submit", (event) => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: location.origin + "/admin/upazila",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#addUpazila").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#addUpazila").find(".error-" + index).text(value);
                        })
                    } else {
                        table.ajax.reload()
                        $("#addUpazila").trigger('reset')
                        $(".Save").text("Save").removeClass("bg-primary")
                        $.notify(response.msg, "success");
                    }
                }
            })
        })
        //edit department
        $(document).on("click", ".editUpazila", (event) => {
            $(".Save").text("Update").addClass("bg-primary")
            $.ajax({
                url: location.origin + "/admin/upazila-edit/" + event.target.value,
                method: "GET",
                beforeSend: () => {
                    $("#addUpazila").find("span").text("");
                },
                success: (response) => {
                    $.each(response, (index, value) => {
                        $("#addUpazila").find("#" + index).val(value);
                    })
                }
            })
        })
        // delete department
        $(document).on("click", ".deleteUpazila", (event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: location.origin + "/admin/upazila-delete/" + event.target.value,
                    method: "GET",
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