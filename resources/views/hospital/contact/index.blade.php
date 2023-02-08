@extends("layouts.hospital.app")

@section("title", "Hospital Contact Page")

@section("content")
<div class="row d-flex justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Hospital Feedback</th>
                            <th>Client Feedback</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key=>$item)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->subject}}</td>
                            <td>{{$item->message}}</td>
                            <td>
                                @foreach($item->feedback as $msg)
                                {{$msg->hospital_comment}}
                                @endforeach
                            </td>
                            <td>
                                @foreach($item->feedback as $msg)
                                {{$msg->client_comment}}
                                @endforeach
                            </td>
                            <td>
                                <button class="fas fa-comment border-0 text-success Comment" style="background: none;" value="{{$item->id}}"></button>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form id="addComment">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="hospital_id" name="hospital_id">
                    <div class="input-group">
                        <textarea name="hospital_comment" rows="6" id="hospital_comment" class="form-control" placeholder="Enter comment"></textarea><button class="fa fa-comment btn btn-danger"></button>
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

    $(document).on("click", ".Comment", event => {
        var hospital_id = "{{Auth::guard('hospital')->user()->id}}"
        $("#myModal").modal("show")
        $("#myModal").find("#id").val(event.target.value)
        $("#myModal").find("#hospital_id").val(hospital_id)
    })

    $(document).on("submit", "#addComment", event => {
        event.preventDefault()
        var formdata = new FormData(event.target)
        var check = $("#myModal").find("#hospital_comment").val()
        if (check !== "") {
            $.ajax({
                url: "{{route('hospital.client.comment')}}",
                method: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: response => {
                    $("#myModal").modal("hide")
                    $("#addComment").trigger("reset")
                    $.notify(response, "success");

                    setTimeout(function() {
                        location.reload();
                    }, 500)
                }
            })
        }
    })
</script>
@endpush