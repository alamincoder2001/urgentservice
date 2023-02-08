@extends("layouts.hospital.app")

@section("title", "Hospital Patient Appointment")

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
                                    <a href="{{route('hospital.patient.show', $item->id)}}" class="fa fa-eye text-info text-decoration-none"></a>
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Investigation of: <span id="exampleModalLabel"></span></h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select onchange="TestName(event)" class="form-control">
                        <option value="">Select Test Name</option>
                        @foreach($tests as $item)
                        <option class="tests test{{$item->id}}" value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <hr>
                <form onsubmit="addInvestigation(event)">
                    <input type="hidden" id="appointment_id" name="appointment_id">
                    <div class="row d-flex justify-content-center">
                        <div class="col-10">
                            <table class="table table-striped">
                                <thead style="background: #133346;border:0;">
                                    <tr>
                                        <th class="text-white">Test Name</th>
                                        <th class="text-white">Unit Price</th>
                                        <th class="text-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot style="border: 0;">
                                    <tr>
                                        <th colspan="3" class="text-end">
                                            <div class="row">
                                                <div class="col-4 p-0">
                                                    <div class="input-group">
                                                        <input type="number" oninput="Discount(event)" class="form-control" style="margin-left:3px;" name="discount" id="discount" value="0"><span class="btn btn-dark">%</span>
                                                    </div>
                                                </div>
                                                <div class="col-8 text-end">
                                                    <input type="hidden" id="TotalValue">
                                                    <span class="total" style="font-size: 20px;">Total: <span class="text-success">0</span> tk</span>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Investigation</button>
                    </div>
                </form>
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