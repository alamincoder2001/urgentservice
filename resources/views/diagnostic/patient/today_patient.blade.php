@extends("layouts.diagnostic.app")

@section("title", "Diagnostic Patient Today Appointment")

@section("content")

<div class="row d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Patient Name</th>
                            <th>Appointment Date</th>
                            <th>Age</th>
                            <th>Address</th>
                            <th>Doctor Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data["appointment"] as $key => $item)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->appointment_date}}</td>
                            <td>{{$item->age}}</td>
                            <td>{{$item->upazila->name}}, {{$item->city->name}}</td>
                            <td>{{$item->doctor->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="{{$item->comment==null?'text-danger':'text-success'}}">{{$item->comment==null?'Pending':'Success'}}</i>
                                    <a href="{{route('diagnostic.patient.show', $item->id)}}" class="fa fa-eye text-info text-decoration-none"></a>
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
    $("#example").DataTable();
</script>
@endpush