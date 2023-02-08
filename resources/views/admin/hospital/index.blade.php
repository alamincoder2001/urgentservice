@extends("layouts.app")

@section("title", "Admin Hospital Page")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                <div class="card-title">
                    <a href="{{route('admin.hospital.create')}}" class="btn btn-primary px-3">Add Hospital</a>
                </div>
            </div>
            <div class="card-body" style="overflow-x: auto;">
                <table id="example" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Hospital Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Hospital type</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hospital as $key => $item)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->username}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->hospital_type}}</td>
                                <td>{{$item->address}}</td>
                                <td>
                                    <img src="{{asset($item->image != '0' ? $item->image : '/noimage.jpg')}}"  width="50" class="img-rounded"/>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('admin.hospital.edit',$item->id)}}" class="fa fa-edit text-primary text-decoration-none"></a>
                                        <button class="fa fa-trash text-danger border-0 deleteadminHospital" style="background: none;" value="{{$item->id}}"></button>
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

        $(document).on("click", ".deleteadminHospital",(event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: "{{route('admin.hospital.destroy')}}",
                    data: {
                        id: event.target.value
                    },
                    method: "POST",
                    dataType: "JSON",
                    success: (response) => {
                        $.notify(response, "success");
                        setTimeout(() => {
                            location.reload()
                        }, 500);
                    }
                })
            }
        })
    })
</script>
@endpush