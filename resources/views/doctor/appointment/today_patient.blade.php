@extends("layouts.doctor.app")

@section("title", "Today Doctor Appointment List Page")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading">
                <div class="card-title">Today Patient List</div>
            </div>
            <div class="card-body">
                <table id="example" class="table table-responsive">
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
                        @foreach($data['new'] as $key=>$p)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$p->name}}</td>
                            <td>{{$p->appointment_date}}</td>
                            <td>{{$p->age}}</td>
                            <td>{{$p->upazila->name}}, {{$p->city->name}}</td>
                            <td>{{$p->contact}}</td>
                            <td>
                                @if($p->diagnostic_id !== null)
                                    <i class="fas fa-square-plus"></i>{{$p->diagnostic->name}}
                                @elseif($p->hospital_id)
                                    <i class="fas fa-hospital"></i> {{$p->hospital->name}}                                    
                                @else
                                    <i class="fas fa-home"></i>{{$p->chamber_name}}
                                @endif
                            </td>
                            <td>
                                <i class="{{$p->comment==null?'text-danger':'text-success'}}">{{$p->comment==null?'Pending':'Success'}}</i>
                                <a href="{{route('doctor.patient', $p->id)}}"><i class="fa fa-eye text-info"></i></a>
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
        })
    </script>
@endpush