@extends("layouts.ambulance.app")
@section("title", "Hire Ambulance Page")

@section("content")

<div class="row d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Person Name</th>
                            <th>Phone</th>
                            <th>Departure Date</th>
                            <th>Ambulance Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Email</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data["hireambulance"] as $key => $item)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->departing_date}}</td>
                            <td>{{$item->ambulance_type}}</td>
                            <td>{{$item->from}}</td>
                            <td>{{$item->to}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->comment}}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="{{$item->comment==null?'text-danger':'text-success'}}">{{$item->comment==null?'Pending':'Success'}}</i>
                                    <button value="{{$item->id}}" onclick="Comment(this, '{{$item->comment}}')" class="fa fa-comment text-info border-0" style="background:none;"></button>
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

<div class="modal" id="myModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form id="addComment">
                    <input type="hidden" id="id" name="id">
                    <div class="input-group">
                        <textarea name="comment" id="comment" class="form-control" placeholder="Enter comment"></textarea><button class="fa fa-comment btn btn-danger"></button>
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

    function Comment(event, comment) {
        $("#myModal").modal("show")
        $("#myModal").find("#id").val(event.value)
        $("#myModal").find("textarea").val(comment)
    }

    $(document).on("submit", "#addComment", event => {
        event.preventDefault()
        var formdata = new FormData(event.target)
        $.ajax({
            url: "{{route('ambulance.hire.comment')}}",
            method: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: response => {
                $("#myModal").modal("hide")
                $("#addComment").trigger("reset")
                $.notify(response, "success");
                location.reload();
            }
        })
    })
</script>
@endpush