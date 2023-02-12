@extends("layouts.app")

@section("title", "Admin Ambulance Page")

@section("content")
@php
$access = App\Models\UserAccess::where('user_id', Auth::guard('admin')->user()->id)
->pluck('permissions')
->toArray();
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                @if(in_array("ambulance.create", $access))
                <div class="card-title">
                    <a href="{{route('admin.ambulance.create')}}" class="btn btn-primary px-3">Add Ambulance</a>
                </div>
                @endif
            </div>
            <div class="card-body" style="overflow-x: auto;">
                <table id="example" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Ambulance Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Ambulance type</th>
                            <th>Upazila</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ambulances as $key => $item)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->username}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->ambulance_type}}</td>
                            <td>{{$item->upazila ? $item->upazila->name: ''}}</td>
                            <td>{{$item->address}}</td>
                            <td>
                                <img src="{{asset($item->image != '0' ? $item->image : '/noimage.jpg')}}" width="50">
                            </td>
                            <td>
                                <div class="d-flex">
                                    @if(in_array("ambulance.edit", $access))
                                    <a href="{{route('admin.ambulance.edit',$item->id)}}" class="fa fa-edit text-primary text-decoration-none"></a>
                                    @endif
                                    @if(in_array("ambulance.destroy", $access))
                                    <button class="fa fa-trash text-danger border-0 deleteadminAmbulance" style="background: none;" value="{{$item->id}}"></button>
                                    @endif
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

        $(document).on("click", ".deleteadminAmbulance", (event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: "{{route('admin.ambulance.destroy')}}",
                    data: {
                        id: event.target.value
                    },
                    method: "POST",
                    dataType: "JSON",
                    success: (response) => {
                        $.notify(response, "success");
                        window.location.href = "{{route('admin.ambulance.index')}}"
                    }
                })
            }
        })
    })
</script>
@endpush