@extends("layouts.app")

@section("title", "Admin Investigation Page")

@section("content")
<div class="row">
    <div class="col-5">
        <div class="card bodyInvestigation">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="patient_name">Patient Name</label>
                            <input type="text" name="patient_name" id="patient_name" disabled value="{{$data->patient_name}}" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="patient_phone">Patient Phone</label>
                            <input type="text" name="patient_phone" id="patient_phone" disabled value="{{$data->patient_phone}}" class="form-control" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-7">
        <div class="card" id="tableInvestigation">
            <div class="card-heading">
                <div class="card-title">Investigation Test List</div>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead style="background: #133346;border:0;">
                        <tr>
                            <th class="text-white">Test Name</th>
                            <th class="text-white">Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->investigationDetails as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->price}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-4">
                        <div class="input-group">
                            <input type="number" class="form-control" disabled name="discount" id="discount" value="{{$data->discount}}"><span class="btn btn-dark">%</span>
                        </div>
                    </div>
                    <div class="col-8 text-end">
                        <input type="hidden" id="TotalValue" value="600">
                        <span class="total" style="font-size: 20px;">Total: <span class="text-success">{{$data->total_amount}}</span> tk</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("js")
<script>

</script>
@endpush