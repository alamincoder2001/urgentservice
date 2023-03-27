@extends("layouts.app")

@section("title", "Admin Patient Prescription Page")

@section("content")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading">
                <div class="card-title">Patient Prescription List</div>
            </div>
            <div class="card-body">
                <table id="example" class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Prescription</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key=>$item)
                        <tr>
                            <td>{{++$key}}</td>
                            <td class="text-center">
                                @php
                                    $isPdf = explode(".", $item->image);
                                    $end = end($isPdf);
                                @endphp
                                @if($end == "pdf" || $end == "PDF")
                                    <a href="{{asset($item->image)}}" target="_blank"><i style="font-size: 35px;" class="fas fa-file-pdf"></i></a>
                                @else
                                    <a href="{{asset($item->image)}}" target="_blank">
                                        <img src="{{asset($item->image)}}" style="width: 90px;border:1px solid forestgreen;">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <button value="{{$item->id}}" class="fas fa-trash text-danger border-0 deletePrescription" style="background: none;"></button>
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

            $(document).on("click", ".deletePrescription",(event) => {
            if (confirm("Are you sure want to delete this data!")) {
                $.ajax({
                    url: "{{route('admin.prescription.destroy')}}",
                    data: {
                        id: event.target.value
                    },
                    method: "POST",
                    success: (response) => {
                        $.notify(response, "success");
                        setTimeout(() => {
                            location.reload()
                        }, 500);
                    }
                })
            }
        })
        })
    </script>
@endpush