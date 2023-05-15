@extends("layouts.app")

@section("title", "Hire Ambulance List")

@section("content")

<div class="row d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Client Name</th>
                            <th>Departing Date</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Client Phone</th>
                            <th>Ambulance Type</th>
                            <th>Trip</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contactprivatecars as $key => $item)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->departing_date}}</td>
                            <td>{{$item->from}}</td>
                            <td>{{$item->to}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->cartype->name}}</td>
                            <td>{{$item->trip}}</td>
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