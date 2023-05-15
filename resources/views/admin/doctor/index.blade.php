@extends("layouts.app")

@section("title", "Doctor Profile")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                <div class="card-title">
                    <a href="{{route('admin.doctor.create')}}" class="btn btn-primary px-3">Add Doctor</a>
                </div>
            </div>
            <div class="card-body" style="overflow-x: auto;">
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Doctor Name</th>
                            <th>Username</th>
                            <th>Education</th>
                            <th>Speciality</th>
                            <th>Phone</th>
                            <th>First Fee</th>
                            <th>Second Fee</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $key=>$item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->username}}</td>
                            <td>{{$item->education}}</td>
                            <td>
                                @foreach($item->department as $dept)
                                {{$dept->specialist->name}},
                                @endforeach
                            </td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->first_fee}}</td>
                            <td>{{$item->second_fee}}</td>
                            <td>
                                <img src="{{asset($item->image != '0' ? $item->image : '/uploads/nouserimage.png')}}" width="50">
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{route('admin.doctor.create',$item->id)}}" class="fa fa-edit text-primary text-decoration-none"></a>
                                    <button class="fa fa-trash text-danger deleteadminDoctor border-0" style="background: none;" value="{{$item->id}}"></button>
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

        $(document).on("click", ".deleteadminDoctor", (event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: "{{route('admin.doctor.destroy')}}",
                    data: {
                        id: event.target.value
                    },
                    method: "POST",
                    success: (response) => {
                        $.notify(response, "success");
                        window.location.href = "{{route('admin.doctor.index')}}"
                    }
                })
            }
        })
    })
</script>
@endpush