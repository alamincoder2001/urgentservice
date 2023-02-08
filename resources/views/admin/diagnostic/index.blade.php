@extends("layouts.app")

@section("title", "Admin Diagnostic Page")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                <div class="card-title">
                    <a href="{{route('admin.diagnostic.create')}}" class="btn btn-primary px-3">Add Diagnostic</a>
                </div>
            </div>
            <div class="card-body">
                <table id="example" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Diagnostic Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Diagnostic type</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diagnostic as $key => $item)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->username}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->diagnostic_type}}</td>
                                <td>{{$item->address}}</td>
                                <td>
                                    <img src="{{asset($item->image != '0' ? $item->image : '/noimage.jpg')}}"  width="50"/>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('admin.diagnostic.edit',$item->id)}}" class="fa fa-edit text-primary text-decoration-none"></a>
                                        <button class="fa fa-trash text-danger border-0 deleteadminDiagnostic" style="background: none;" value="{{$item->id}}"></button>
                                    </div>
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
    $(document).ready(() => {
        $("#example").DataTable();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on("click", ".deleteadminDiagnostic",(event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: "{{route('admin.diagnostic.destroy')}}",
                    data: {
                        id: event.target.value
                    },
                    method: "POST",
                    dataType: "JSON",
                    success: (response) => {
                        $.notify(response, "success");
                        window.location.href = "{{route('admin.diagnostic.index')}}"
                    }
                })
            }
        })
    })
</script>
@endpush