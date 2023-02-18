@extends("layouts.app")

@section("title", "Admin Diagnostic Create Page")

@section("content")

<div class="row d-flex justify-content-center">

    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                <div class="card-title">
                    <a href="{{route('admin.diagnostic.index')}}" class="btn btn-danger px-3">Back To Home</a>
                </div>
            </div>
            <div class="card-body p-3">
                <form id="addDiagnostic">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Diagnostic Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Ex: KC Diagnostice">
                                <span class="error-name text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Ex: Username">
                                <span class="error-username text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="urgentservicebd@gmail.com">
                                <span class="error-email text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
                                <span class="error-password text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">Phone</label><span class="text-danger" onclick="numberAdd(event)"><i class="fa fa-plus"></i></span>
                                <div class="phoneAdd">
                                    <div class="input-group">
                                        <input type="text" name="phone[]" id="phone" class="form-control" value="01721843819" autocomplete="off">
                                    </div>
                                </div>
                                <span class="error-phone text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="discount_amount">Discount</label>
                                <div class="input-group">
                                    <input type="number" min="0" step="0.01" name="discount_amount" id="discount_amount" class="form-control" value="0"><i class="btn btn-secondary">%</i>
                                </div>
                                <span class="error-discount_amount text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="diagnostic_type">Type Of Diagnostic</label>
                                <select name="diagnostic_type" id="diagnostic_type" class="form-control">
                                    <option label="Choose diagnostic type"></option>
                                    <option value="government">Government</option>
                                    <option value="non-government">Non-Government</option>
                                </select>
                                <span class="error-diagnostic_type text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city_id">City Name</label>
                                <select name="city_id" id="city_id" class="form-control select2">
                                    <option value="">Choose a city name</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="error-city_id text-danger error"></span>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control"></textarea>
                                <span class="error-address text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="map_link">Map Link</label>
                                <textarea name="map_link" id="map_link" class="form-control"></textarea>
                                <span class="error-map_link text-danger error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image">Diagnostic Image</label>
                                <input type="file" class="form-control" id="image" name="image" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <img width="100" class="img" style="border: 1px solid #ccc; height:80px;">
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-success text-white text-uppercase px-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push("js")
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
    $('.select2').select2();
    $(document).ready(() => {
        $("#addDiagnostic").on("submit", (event) => {
            event.preventDefault()
            var description = CKEDITOR.instances.description.getData();
            var formdata = new FormData(event.target)
            formdata.append("description", description)

            $.ajax({
                url: "{{route('admin.diagnostic.store')}}",
                data: formdata,
                method: "POST",
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#addDiagnostic").find(".error").text("");
                },
                success: (response) => {
                    if (response.error) {
                        $.each(response.error, (index, value) => {
                            $("#addDiagnostic").find(".error-" + index).text(value);
                        })
                    } else {
                        $("#addDiagnostic").trigger('reset')
                        $.notify(response, "success");
                    }
                }
            })
        })
    })

    function numberAdd() {
        var row = `
            <div class="input-group">
                <input type="text" id="phone" name="phone[]" class="form-control">
                <button type="button" class="btn btn-danger removePhone">remove</button>
            </div>
        `
        $(".phoneAdd").append(row)
    }

    $(document).on("click", ".removePhone", event => {
        event.target.offsetParent.remove();
    })
</script>
@endpush