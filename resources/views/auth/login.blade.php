@extends("layouts.master")

@push("style")
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    .image-avatar {
        width: 200px;
        height: 200px;
        margin: 0 auto;
        border-radius: 50%;
        background: #ededed;
        overflow: hidden;
        position: relative;
    }

    .image-avatar img {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        border-radius: 50%;
    }

    .container {
        padding: 16px;
    }
</style>
@endpush

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center image-avatar">
                <img src="{{asset('frontend/nodoctorimage.png')}}">
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <form method="POST" action="{{route('user.login')}}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-6 offset-md-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" name="email" value="{{ old('email') }}" placeholder="Email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6 offset-md-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" style="box-shadow:none;" autocomplete="off" name="password" placeholder="Password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0 text-center">
                            <div class="col-6 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                <a class="d-block" href="{{url('/register')}}">Account create first!</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection