@extends("layouts.app")

@section("title", "Admin CompanyContact Page")

@section("content")
<div class="row d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key=>$item)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->message}}</td>
                            <td>
                                <button onclick="deleteContact(event)" value="{{$item->id}}" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push("js")
<script>
    $("#example").DataTable();
    function deleteContact(event){
        if(confirm("Are you sure want to delete this")){
            $.ajax({
                url: location.origin+"/admin/delete_companycontact/"+event.target.value,
                method: "GET",
                success: res => {
                    $.notify(res, "success")
                    setInterval(() => {
                        location.reload()
                    }, 500)
                }
            })
        }
    }
</script>
@endpush