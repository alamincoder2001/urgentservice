@extends("layouts.app")

@section("title", "Admin Blood Donor Page")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading">
                <div class="card-title">Blood Donor List</div>
            </div>
            <div class="card-body">
                <table id="example" class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Donor Name</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>DoB</th>
                            <th>Blood Group</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key=>$p)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$p->name}}</td>
                            <td>{{$p->phone}}</td>
                            <td>{{$p->gender}}</td>
                            <td>{{$p->dob}}</td>
                            <td>{{$p->blood_group}}</td>
                            <td>{{$p->address}}, {{$p->city->name}}</td>
                            <td>{{$p->email}}</td>
                            <td>
                                <img src="{{asset($p->image != '0' ? $p->image : '/uploads/nouserimage.png')}}" width="50">
                            </td>
                            <td>
                                <button value="{{$p->id}}" class="fas fa-trash text-danger border-0 deleteadminDonor" style="background: none;"></button>
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

            $(document).on("click", ".deleteadminDonor",(event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: "{{route('admin.donor.destroy')}}",
                    data: {
                        id: event.target.value
                    },
                    method: "POST",
                    success: (response) => {
                        if(response.unauthorize){
                            $.notify(response.unauthorize);
                        }else{
                            $.notify(response, "success");
                            setTimeout(() => {
                                location.reload()
                            }, 1000);
                        }
                    }
                })
            }
        })
        })
    </script>
@endpush