@extends("layouts.doctor.app")

@section("title", "Doctor Appointment Page")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading">
                <div class="card-title">Patient List</div>
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
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['all'] as $key=>$p)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$p->name}}</td>
                            <td>{{$p->appointment_date}}</td>
                            <td>{{$p->age}}</td>
                            <td>{{$p->upazila->name}}, {{$p->city->name}}</td>
                            <td>{{$p->contact}}</td>
                            <td>
                                @if($p->diagnostic_id !== null)
                                    @php
                                        $n = \App\Models\Diagnostic::find($p->diagnostic_id);
                                    @endphp
                                    <i class="fas fa-square-plus"></i>{{$n->name}}
                                @elseif($p->hospital_id)                                    
                                    @php
                                        $n = \App\Models\Hospital::find($p->hospital_id);
                                    @endphp
                                    <i class="fas fa-hospital"></i> {{$n->name}}                                    
                                @else
                                    @php
                                        $n = \App\Models\Doctor::find($p->doctor_id);
                                    @endphp
                                    <i class="fas fa-home"></i>{{$n->chamber_name}}
                                @endif
                            </td>
                            <td>{{$p->email}}</td>
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