@extends("layouts.diagnostic.app")

@section("title", "Diagnostic - Doctor Profile")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                <div class="card-title">
                    <a href="{{route('diagnostic.doctor.create')}}" class="btn btn-primary px-3">Add Doctor</a>
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
                            <td>{{$item->doctor->name}}</td>
                            <td>{{$item->doctor->username}}</td>
                            <td>{{$item->doctor->education}}</td>
                            <td>
                                @foreach($item->doctor->department as $department)
                                {{$department->specialist->name}},
                                @endforeach
                            </td>
                            <td>{{$item->doctor->phone}}</td>
                            <td>{{$item->doctor->first_fee}}</td>
                            <td>{{$item->doctor->second_fee}}</td>
                            <td>
                                <img src="{{asset($item->doctor->image != '0' ? $item->doctor->image : '/uploads/nouserimage.png')}}" width="50">
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{route('diagnostic.doctor.create',$item->doctor->id)}}" class="fa fa-edit text-primary text-decoration-none"></a>
                                    <button class="fa fa-trash text-danger border-0 deletediagnosticDoctor" style="background: none;" value="{{$item->doctor->id}}"></button>
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

        $(document).on("click", ".deletediagnosticDoctor", (event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: "{{route('diagnostic.doctor.destroy')}}",
                    data: {
                        id: event.target.value
                    },
                    method: "POST",
                    dataType: "JSON",
                    success: (response) => {
                        $.notify(response, "success");
                        window.location.href = "{{route('diagnostic.doctor.index')}}"
                    }
                })
            }
        })
    })
</script>
@endpush