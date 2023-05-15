<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hospital-Login</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/x-icon" href="{{asset($setting->favicon)}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Importing fonts from Google */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        /* Reseting */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #ecf0f3;
        }

        .wrapper {
            max-width: 450px;
            min-height: 500px;
            margin: 80px auto;
            padding: 40px 30px 30px 30px;
            background-color: #ecf0f3;
            border-radius: 15px;
            box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
        }

        .logo {
            width: 80px;
            margin: auto;
        }

        .logo img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0px 0px 3px #5f5f5f,
                0px 0px 0px 5px #ecf0f3,
                8px 8px 15px #a7aaa7,
                -8px -8px 15px #fff;
        }

        .wrapper .name {
            font-weight: 600;
            font-size: 1.4rem;
            letter-spacing: 1.3px;
            padding-left: 10px;
            color: #555;
        }

        .wrapper .form-field input {
            width: 100%;
            display: block;
            border: none;
            outline: none;
            background: none;
            font-size: 1.2rem;
            color: #666;
            padding: 10px 15px 10px 10px;
            /* border: 1px solid red; */
        }

        .wrapper .form-field {
            padding-left: 10px;
            margin-bottom: 20px;
            border-radius: 20px;
            box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
        }

        .wrapper .form-field .fas {
            color: #555;
        }

        .wrapper .btn {
            box-shadow: none;
            width: 100%;
            height: 40px;
            background-color: #03A9F4;
            color: #fff;
            border-radius: 25px;
            box-shadow: 3px 3px 3px #b1b1b1,
                -3px -3px 3px #fff;
            letter-spacing: 1.3px;
        }

        .wrapper .btn:hover {
            background-color: #039BE5;
        }

        .wrapper a {
            text-decoration: none;
            font-size: 0.8rem;
            color: #03A9F4;
        }

        .wrapper a:hover {
            color: #039BE5;
        }

        .fa-hospital {
            padding: 25px;
            background: #d7d4d4;
            border-radius: 50%;
            color: red;
            font-size: 22px;
        }

        @media(max-width: 380px) {
            .wrapper {
                margin: 30px 20px;
                padding: 40px 15px 15px 15px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>


    <div class="wrapper">
        <h3 class="text-center text-uppercase">{{$setting->name}}</h3>
        <div class="mt-4 name d-flex align-items-center gap-2 justify-content-center">
            <i class="fa fa-hospital"></i>
        </div>

        <form class="p-3 mt-3" id="hospital">
            <div class="form-field d-flex align-items-center">
                <i class="far fa-user"></i>
                <input type="text" name="email" id="email" placeholder="Email">
            </div>
            <span class="error-email error text-danger"></span>
            <div class="form-field d-flex align-items-center">
                <i class="fas fa-key"></i>
                <input type="password" name="password" id="pwd" placeholder="Password">
            </div>
            <span class="error-password error text-danger"></span>

            <button type="submit" class="btn mt-3">Hospital</button>
        </form>
        <div class="text-center fs-6">
            <a href="{{route('password.request')}}">Forget password?</a> or <a href="#">Sign up</a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#hospital").on("submit", (event) => {
                event.preventDefault()
                var formdata = new FormData(event.target)
                $.ajax({
                    url: "{{route('hospital.login')}}",
                    data: formdata,
                    method: "POST",
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    beforeSend: () => {
                        $("#hospital").find(".error").text("");
                    },
                    success: (response) => {
                        if (response.error) {
                            $.each(response.error, (index, value) => {
                                $("#hospital").find(".error-" + index).text(value);
                            })
                        } else if (response.errors) {
                            alert(response.errors)
                        } else {
                            $("#hospital").trigger('reset')
                            window.location.href = "{{route('hospital.dashboard')}}"
                        }
                    }
                })
            })
        })
    </script>

</body>

</html>