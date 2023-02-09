<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$setting->name}}</title>

    @include("layouts.frontend.style")
    <style>
        body {
            top: 0px !important;
            position: static !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .goog-te-banner-frame {
            display: none !important
        }

        .goog-te-gadget-simple {
            width: 106px !important;
            background-color: #283290 !important;
            padding: 2px !important;
            border: none !important;
            height: 36px !important;
        }

        .goog-te-gadget-simple .VIpgJd-ZVi9od-xl07Ob-lTBxed {
            color: white !important;
            line-height: 30px !important;
        }

        .goog-te-gadget-simple img {
            display: none !important;
        }

        .goog-te-menu-value span {
            display: none;
            margin: -15px !important;
        }

        .goog-te-menu-value span:first-child {
            display: block;
            text-align: center;
            color: white;
        }

        .ShowSearchBtn {
            background: #283290;
            padding: 5px;
            position: sticky;
            top: 128px;
            width: 100%;
            z-index: 99999;
        }

        .SearchBtn {
            padding: 14px;
            height: 36px;
            box-shadow: none !important;
            display: flex;
            cursor: pointer;
            align-items: center;
            border: none;
            border-radius: 0;
        }
    </style>

</head>

<body class="antialiased position-relative">
    <div class="Loading d-none" style="position: fixed;z-index: 99999;top: 0;left: 0;display: flex;justify-content: center;align-items: center;width: 100%;background: #ffffff85;">
        <img src="{{asset('loading.gif')}}">
    </div>
    @include("layouts.frontend.navbar")
    <div class="container searchshow mt-4 d-none">
        <div class="row d-flex justify-content-center">
        </div>
    </div>
    <main>
        @yield("content")
    </main>
    <!-- footer section -->
    @include("layouts.frontend.footer")

    @include("layouts.frontend.script")
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                includedLanguages: 'en,bn',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }

        $(".SearchBtn").on("click", event => {
            if (event.target.value == 0) {
                $(".SearchBtn").prop("value", 1)
                $(".ShowSearchBtn").removeClass("d-none")
                $("#select2").select2()
            } else {
                $(".SearchBtn").prop("value", 0)
                $(".ShowSearchBtn").addClass("d-none")
            }
        })
    </script>

    <script>
        function changeService(event) {
            $.ajax({
                url: location.origin + "/filtersingleservice",
                method: "POST",
                dataType: "JSON",
                data: {
                    service: event.target.value
                },
                beforeSend: () => {
                    $(".ShowSearchBtn").find(".searchName").html(`<option value="">Select Name</option>`)
                },
                success: res => {
                    $.each(res, (index, value) => {
                        $(".ShowSearchBtn").find(".searchName").append(`<option value="${value.id}">${value.name}</option>`)
                    })
                }
            })
        }

        function searchSubmit(event) {
            event.preventDefault();
            var formdata = new FormData(event.target)
            var selectName = $("#services option:selected").val();

            $.ajax({
                url: location.origin + "/filtersingleservice",
                method: "POST",
                dataType: "JSON",
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $(".error").text("")
                    $("main").html("");
                    $(".searchshow").removeClass("d-none")
                    $(".Loading").removeClass("d-none")
                    $(".searchshow").find(".row").html("")
                },
                success: res => {
                    if (res.error) {
                        $.each(res.error, (index, value) => {
                            $(".error-" + index).text(value)
                        })
                    } else {
                        $.each(res, (index, value) => {
                            if (selectName == "Doctor") {
                                AllDoctor(index, value);
                            } else if (selectName == "Hospital") {
                                Hospitals(index, value);
                            } else if (selectName == "Diagnostic") {
                                Diagnostics(index, value);
                            } else if (selectName == "Ambulance") {
                                Ambulances(index, value);
                            } else {
                                Privatecars(index, value);
                            }
                        })
                    }
                },
                complete: () => {
                    $(".Loading").addClass("d-none")
                }
            })
        }

        function Diagnostics(index, value) {
            var row = `
            <div class="col-md-6 col-10 col-sm-6 col-lg-4 diagnosticbody">
                <div class="card border-0 mb-4" style="background: #ffffff;box-shadow:0px 0px 7px 2px #c1c1c1;">
                    <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                        <img src="${value.image != '0'? location.origin+"/"+value.image : 'frontend/img/hospital.png'}" style="width: 100%; height:160px;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center" style="font-size: 15px;">${value.name}</h5>
                        <p class="card-text text-primary text-center mb-2"><span>${value.diagnostic_type.toUpperCase()}</span> | <span>+880 ${value.phone.substr(1)}</span></p>
                        <ul style="list-style: none;padding:0 0 0 5px;">
                            <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span style="font-size: 13px;">${value.address}, ${value.city.name}</span></li>
                            <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span style="font-size: 13px;">${value.email}</span></li>
                        </ul>
                    </div>
                    <a class="text-decoration-none text-white text-uppercase" target="_blank" href="${'/single-details-diagnostic/'+value.id}">
                    <div class="card-footer border-0 text-center py-3">
                        View Details
                    </div>
                    </a>
                    ${value.discount_amount!=0?"<div class='discount'>-"+value.discount_amount+"%</div>":""}
                </div>
            </div>
        `;
            $(".searchshow").find('.row').append(row)
        }

        function Hospitals(index, value) {
            var row = `
                <div class="col-md-6 col-10 col-sm-6 col-lg-4 hospitalbody">
                    <div class="card border-0 mb-4" style="background: #ffffff;box-shadow:0px 0px 7px 2px #c1c1c1;">
                        <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                            <img src="${value.image != '0'?location.origin+"/"+value.image : 'frontend/img/hospital.png'}" style="width: 100%; height:160px;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center" style="font-size: 15px;">${value.name}</h5>
                            <p class="card-text text-primary text-center mb-2"><span>${value.hospital_type.toUpperCase()}</span> | <span>${value.phone}</span></p>
                            <ul style="list-style: none;padding:0 0 0 5px;">
                                <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span style="font-size: 13px;">${value.address}, ${value.city.name}</span></li>
                                <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span style="font-size: 13px;">${value.email}</span></li>
                            </ul>
                        </div>
                        <a class="text-decoration-none text-white text-uppercase" target="_blank" href="${'/single-details-hospital/'+value.id}">
                        <div class="card-footer border-0 text-center py-3">
                            View Details
                        </div>
                        </a>
                        ${value.discount_amount!=0?"<div class='discount'>-"+value.discount_amount+"%</div>":""}
                    </div>
                </div>
        `;
            $(".searchshow").find('.row').append(row)
        }

        function Ambulances(index, value) {
            var row = `
            <div class="col-md-6 col-10 col-sm-6 col-lg-4 ambulancebody">
                <div class="card border-0 mb-4" style="background: #ffffff;box-shadow:0px 0px 7px 2px #c1c1c1;height:400px;font-size-adjust: 0.58;">
                    <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                        <img src="${value.image != '0'?location.origin+"/"+value.image : 'frontend/img/ambulance.png'}" style="width: 100%; height:160px;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center" style="font-size: 15px;">${value.name}</h5>
                        <p class="card-text text-primary text-center mb-2"><span>${value.ambulance_type.replaceAll(",", " | ")}</span></p>
                        <ul style="list-style: none;padding:0 0 0 5px;">
                            <li><i style="width: 15px;height:15px;" class="fa fa-phone text-info"></i> <span style="font-size: 13px;">+880 ${value.phone}</span></li>
                            <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span style="font-size: 13px;">${value.address}, ${value.city.name}</span></li>
                            <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span style="font-size: 13px;">${value.email}</span></li>
                        </ul>
                    </div>
                    <a href="${'single-details-ambulance/'+value.id}" target="_blank" class="text-uppercase text-white text-decoration-none text-center">
                        <div class="card-footer border-0 py-3">
                            View Details
                        </div>
                    </a>
                </div>
            </div>
        `;
            $(".searchshow").find('.row').append(row)
        }

        function Privatecars(index, value) {
            var row = `
            <div class="col-md-6 col-10 col-sm-6 col-lg-4 privatecarbody">
                <div class="card border-0 mb-4" style="background: #ffffff;box-shadow:0px 0px 7px 2px #c1c1c1;">
                    <div class="img card-img-top m-auto mt-2 w-50 overflow-hidden d-flex justify-content-center border border-2">
                        <img src="${value.image != '0'?location.origin+"/"+value.image : 'frontend/img/privatecar.png'}" style="width: 100%; height:160px;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center" style="font-size: 15px;">${value.name}</h5>
                        <p class="card-text text-primary text-center mb-2"><span>${value.cartype_id.replaceAll(",", " | ")}</span></p>
                        <ul style="list-style: none;padding:0 0 0 5px;">
                            <li><i style="width: 15px;height:15px;" class="fa fa-phone text-info"></i> <span style="font-size: 13px;">+880 ${value.phone.substr(1)}</span></li>
                            <li><i style="width: 15px;height:15px;" class="fa fa-map-marker text-info"></i> <span style="font-size: 13px;">${value.address}, ${value.city.name}</span></li>
                            <li><i style="width: 15px;height:15px;font-size:13px;" class="fa fa-envelope-o text-info"></i> <span style="font-size: 13px;">${value.email}</span></li>
                        </ul>
                    </div>
                    <a href="${'single-details-privatecar/'+value.id}" target="_blank" class="text-uppercase text-white text-decoration-none text-center">
                        <div class="card-footer border-0 py-3">
                            View Details
                        </div>
                    </a>
                </div>
            </div>
            `;
            $(".searchshow").find('.row').append(row)
        }

        function AllDoctor(index, value) {
            var row = `
                    <div class="col-12 col-lg-4 mb-3 doctor_details">
                        <a href="/single-details-doctor/${value.id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:150px;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img height="100%" src="${value.image != '0'?location.origin+"/"+value.image:location.origin+'/uploads/nouserimage.png'}" width="100">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>${value.name}</h6>
                                        <p style="color:#c99913;">${value.department.length > 0 ? value.department[0].specialist.name:''}, ${value.city.name}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;">${value.education.substring(0, 100)}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
            $(".searchshow").find('.row').append(row)
        }
    </script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/63707708daff0e1306d72004/1ghnl1v8d';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>