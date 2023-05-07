@extends("layouts.diagnostic.app")
@section("title", "Diagnostic Patient list show")

@section("content")
<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex gap-3 align-items-center">
                    <div class="d-flex align-items-center justify-content-center" style="width: 65px;height: 65px;background: beige;">
                        <i class="fa fa-user" style="font-size: 50px;"></i>
                    </div>
                    <h4>{{$patients->name}}</h4>
                </div>
                <hr />
                <div class="details ps-2">
                    <div class="input-group gap-3">
                        <i style="font-weight: 600;font-family: serif;">Appointment Date:</i> <i style="font-size:13px;">{{$patients->appointment_date}}</i>
                    </div>
                    <div class="input-group gap-3">
                        <i style="font-weight: 600;font-family: serif;">Patient Age:</i> <i style="font-size:13px;">{{$patients->age}}</i>
                    </div>
                    <div class="input-group gap-3">
                        <i style="font-weight: 600;font-family: serif;">Patient District:</i> <i>{{$patients->city->name}}</i>
                    </div>
                    <div class="input-group gap-3">
                        <i style="font-weight: 600;font-family: serif;">Patient Upazila:</i>
                        <i style="font-size:13px;">
                            @php
                            $u = Devfaysal\BangladeshGeocode\Models\Upazila::where(["district_id" => $patients->district, "id" => $patients->upozila])->first();
                            @endphp
                            {{$u->name}}
                        </i>
                    </div>
                    <div class="form-group">
                        <label for="problem"><i style="font-weight: 600;font-family: serif;">Problem:</i></label>
                        <textarea readonly class="form-control fst-italic">{{$patients->problem}}</textarea>
                    </div>
                    <form id="Comment">
                        <input type="hidden" name="id" value="{{$patients->id}}">
                        <div class="form-group  mb-1">
                            <label for="comment"><i style="font-weight: 600;font-family: serif;">Comment on Patient:</i></label>
                            <textarea name="comment" id="comment" class="form-control">{{$patients->comment}}</textarea>
                        </div>
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-primary px-2">Comment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("js")
<script>
    $(document).ready(() => {
        $("#Comment").on("submit", event => {
            event.preventDefault()
            var formdata = new FormData(event.target)
            $.ajax({
                url: "{{route('diagnostic.comment.store')}}",
                data: formdata,
                method: "POST",
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: (response) => {
                    $.notify(response, "success");
                }
            })
        })
    })
</script>
@endpush