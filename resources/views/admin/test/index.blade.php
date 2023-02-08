@extends("layouts.app")

@section("title", "Admin Test Page")

@section("content")
@php
$access = App\Models\UserAccess::where('user_id', Auth::guard('admin')->user()->id)
->pluck('permissions')
->toArray();
@endphp
<div class="row d-flex justify-content-center">
    <div class="col-md-4">
        <div class="card mb-0">
            <div class="card-body">
                <form id="addTest">
                    <input type="hidden" name="test_id" id="test_id">
                    <div class="form-group">
                        <label for="name">Test Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Ex: Ex-Ray">
                        <span class="error-name error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" name="amount" class="form-control">
                        <span class="error-amount error text-danger"></span>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success px-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if(in_array("test.index", $access))
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Test Name</th>
                            <th>Amount</th>
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
    var editaccess = "{{in_array('test.edit', $access)}}"
    var deleteaccess = "{{in_array('test.destroy', $access)}}"
    $(document).ready(() => {
        var table = $('#example').DataTable({
            ajax: location.origin + "/admin/test/fetch",
            columns: [{
                    data: 'id',
                },
                {
                    data: 'name',
                },
                {
                    data: 'amount',
                },
                {
                    data: null,
                    render: (data) => {
                        return `
                            ${editaccess?'<button type="button" class="btn btn-primary btn-sm editTest" value="'+data.id+'">Edit</button>':''}
                            ${deleteaccess?'<button type="button" class="btn btn-danger btn-sm deleteTest" value="'+data.id+'">Delete</button>':''}
                        `;
                    }
                }
            ],
        });
        $("#addTest").on("submit", (event) => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: location.origin + "/admin/test/store",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#addTest").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#addTest").find(".error-" + index).text(value);
                        })
                    } else {
                        table.ajax.reload()
                        $("#addTest").trigger('reset')
                        $("button[type='submit']").text("Save").removeClass("btn-primary").addClass("btn-success");
                        $("#addTest").find("#test_id").val('')
                        $.notify(response, "success");
                    }
                }
            })
        })
        //edit department
        $(document).on("click", ".editTest", (event) => {
            $("button[type='submit']").text("Update").addClass("btn-primary").removeClass("btn-success");
            $.ajax({
                url: location.origin + "/admin/test/edit/" + event.target.value,
                method: "GET",
                beforeSend: () => {
                    $("#addTest").find("span").text("");
                },
                success: (response) => {
                    $.each(response, (index, value) => {
                        $("#addTest").find("#" + index).val(value);
                    })
                    $("#addTest").find("#test_id").val(response.id);
                }
            })
        })
        // delete department
        $(document).on("click", ".deleteTest", (event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: location.origin + "/admin/test/delete",
                    method: "POST",
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