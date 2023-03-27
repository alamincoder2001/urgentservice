@extends("layouts.app")

@section("title", "Admin User Create")

@section("content")
<div class="row d-flex justify-content-center">
    <div class="col-md-4">
        <div class="card mb-0">
            <div class="card-body">
                <form id="addUser">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Name">
                        <span class="error-name error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="username">User Name</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="User Name">
                        <span class="error-username error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                        <span class="error-email error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control">
                            <option value="">Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                        <span class="error-role error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        <span class="error-password error text-danger"></span>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success px-3">Save User</button>
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
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Role</th>
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
            ajax: location.origin + "/admin/user-fetch",
            columns: [{
                    data: 'id',
                },
                {
                    data: 'name',
                },
                {
                    data: 'email',
                },
                {
                    data: "role",
                },
                {
                    data: null,
                    render: (data) => {
                        return `
                            <a href="/admin/user/permission/${data.id}" class="btn btn-warning btn-sm">User Permission</a>
                            <button type="button" class="btn btn-primary btn-sm editUser" value="${data.id}">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm deleteUser" value="${data.id}">Delete</button>
                        `;
                    }
                }
            ],
        });
        $("#addUser").on("submit", (event) => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: location.origin + "/admin/user/store",
                data: formdata,
                method: "POST",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#addUser").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#addUser").find(".error-" + index).text(value);
                        })
                    } else {
                        table.ajax.reload()
                        $("#addUser").trigger('reset')
                        $("button[type='submit']").text("Save").removeClass("btn-primary").addClass("btn-success");
                        $("#addUser").find("#user_id").val('')
                        $.notify(response, "success");
                    }
                }
            })
        })
        //edit department
        $(document).on("click", ".editUser", (event) => {
            $("button[type='submit']").text("Update").addClass("btn-primary").removeClass("btn-success");
            $.ajax({
                url: location.origin + "/admin/user/edit/" + event.target.value,
                method: "GET",
                beforeSend: () => {
                    $("#addUser").find("span").text("");
                },
                success: (response) => {
                    $.each(response, (index, value) => {
                        $("#addUser").find("#" + index).val(value);
                    })
                    $("#addUser").find("#user_id").val(response.id);
                }
            })
        })
        // delete department
        $(document).on("click", ".deleteUser", (event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: location.origin + "/admin/user/delete",
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