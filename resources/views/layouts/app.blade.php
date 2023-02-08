<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template" />
    <meta name="description" content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @include("layouts.backend.style")

</head>

<body>

    <div class="page-container">
        <!-- PAGE SIDEBAR================================================= -->
        @include("layouts.backend.sidebar")
        <!-- PAGE CONTENT================================================== -->
        <div class="page-content">
            <!-- start page header -->
            @include("layouts.backend.navbar")
            <!-- end page header -->

            <!-- start page inner -->
            <div class="page-inner">
                <!-- <div class="page-title">
                    <h3 class="breadcrumb-header">@yield('breadcrumb')</h3>
                </div> -->
                <div id="main-wrapper">
                    @yield("content")
                </div>
            </div>
            <!-- end page inner -->
        </div>
    </div>

    <script>
        function dateTime() {
            d = new Date().toDateString();
            time = new Date().toLocaleTimeString();
            document.getElementById("time").innerText = d+', '+time
            setTimeout(() => {
                dateTime()
            }, 1000)
        }
        dateTime()
    </script>
    @include("layouts.backend.script")
</body>

</html>