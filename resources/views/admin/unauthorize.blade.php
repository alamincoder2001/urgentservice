@extends("layouts.app")
@section("title", "UnAuthorized Page")

@section("content")

<div class="row d-flex justify-content-center">
    <div class="col-6 text-center">
        <span style="display: block;padding: 10px;font-size: 24px;" class="badge bg-warning">Opps! UnAuthorized Page</span>
        Sorry! you have no access
    </div>
</div>
@endsection