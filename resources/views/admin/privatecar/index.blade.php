@extends("layouts.app")

@section("title", "Admin Privatecar Page")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                <div class="card-title">
                    <a href="{{route('cartype.index')}}" class="btn btn-info text-white px-3">Add Cartype</a>
                    <a href="{{route('admin.privatecar.create')}}" class="btn btn-primary px-3">Add Privatecar</a>
                </div>
            </div>
            <div class="card-body" style="overflow-x: auto;">
                <table id="example" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Privatecar Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Privatecar type</th>
                            <th>Upazila</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($privatecars as $key => $item)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->username}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->phone}}</td>
                                <td>
                                    @foreach($item->typewisecategory as $cat)
                                        {{$cat->cartype->name}}, 
                                    @endforeach
                                </td>
                                <td>{{$item->upazila ? $item->upazila->name: ''}}</td>
                                <td>{{$item->address}}</td>
                                <td>
                                    <img src="{{asset($item->image != '0' ? $item->image : '/noimage.jpg')}}" width="50">
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('admin.privatecar.edit',$item->id)}}" class="fa fa-edit text-primary text-decoration-none"></a>
                                        <button class="fa fa-trash text-danger border-0 deleteadminPrivatecar" style="background: none;" value="{{$item->id}}"></button>
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

        $(document).on("click", ".deleteadminPrivatecar",(event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: "{{route('admin.privatecar.destroy')}}",
                    data: {
                        id: event.target.value
                    },
                    method: "POST",
                    success: (response) => {
                        $.notify(response, "success");
                        window.location.href = "{{route('admin.privatecar.index')}}"
                    }
                })
            }
        })
    })
</script>
@endpush