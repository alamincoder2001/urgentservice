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
                            <th>Patient Type</th>
                            <th>Is Appointment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $key => $item)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->appointment_date}}</td>
                            <td>{{$item->age}}</td>
                            <td>{{$item->upazila->name}}, {{$item->city->name}}</td>
                            <td>{{$item->contact}}</td>
                            <td>{{$item->patient_type}}</td>
                            <td>
                                @if($item->chamber_name != null)
                                {{$item->chamber_name}} (Chamber)
                                @elseif($item->hospital != null)
                                {{$item->hospital->name}} (Hospital)
                                @else
                                {{$item->diagnostic->name}} (Diagnostic)
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