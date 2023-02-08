<!DOCTYPE html>
<html lang="en">

<head>
    <!-- metas -->
    <meta charset="utf-8">
    <meta name="author" content="Chitrakoot Web" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="keywords" content="admin,dashboard" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- title  -->
    <title>@yield('title')</title>
    @include("layouts.doctor.style")

</head>

<body>
    <div class="page-container">
        <!-- PAGE SIDEBAR================================================== -->
        @include("layouts.doctor.sidebar")

        <!-- PAGE CONTENT================================================== -->
        <div class="page-content">
            <!-- start page header -->
            @include("layouts.doctor.navbar")
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
    @include("layouts.doctor.script")
</body>

</html>