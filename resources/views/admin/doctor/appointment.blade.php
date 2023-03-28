@extends("layouts.app")

@section("title", "Doctor Patient list")

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
                            <th>Phone</th>
                            <th>Is Appointment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $key => $item)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->appointment_date}}</td>
                            <td>{{$item->age}}</td>
                            <td>{{$item->upazila->name}}, {{$item->city->name}}</td>
                            <td>{{$item->contact}}</td>
                            <td>
                                @if($item->chamber_name != null)
                                <i class="fa fa-home"></i> {{$item->chamber_name}}
                                @elseif($item->hospital != null)
                                <i class="fa fa-hospital-o"></i> {{$item->hospital->name}}
                                @else
                                <i class="fa fa-plus-square-o"></i> {{$item->diagnostic->name}}
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    action
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