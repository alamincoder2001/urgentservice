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
        <div class="row d-flex justify-content-center doctor_details">
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
        function searchSubmit(event) {
            event.preventDefault();
            var formdata = new FormData(event.target)
            var selectName = $("#services").val();
            if (selectName == '') {
                alert("Must be select service")
                return
            }
            var url;
            var formdata;
            if (selectName == "Doctor") {
                url = "{{route('filter.doctor')}}"
                formdata = {
                    doctor_name: $(".searchName").val()
                }
            } else if (selectName == "Hospital") {
                url = "{{route('filter.hospital')}}"
                formdata = {
                    hospital_name: $(".searchName").val()
                }
            } else if (selectName == "Diagnostic") {
                url = "{{route('filter.diagnostic')}}"
                formdata = {
                    diagnostic_name: $(".searchName").val()
                }
            } else if (selectName == "Ambulance") {
                url = "{{route('filter.ambulance')}}"
                formdata = {
                    ambulance_name: $(".searchName").val()
                }
            } else {
                url = "{{route('filter.privatecar')}}"
                formdata = {
                    privatecar_name: $(".searchName").val()
                }
            }

            $.ajax({
                url: url,
                method: "POST",
                data: formdata,
                beforeSend: () => {
                    $("main").html("");
                    $(".searchshow").removeClass("d-none")
                    $(".Loading").removeClass("d-none")
                    $(".searchshow").find(".row").html("")
                },
                success: res => {
                    if (res.status == true && res.message.length == 0) {
                        $(".searchshow").find('.row').html(`<h3 class="text-center m-0">Not Found Data</h3>`)
                    } else if (res.status == true) {
                        $.each(res.message, (index, value) => {
                            if (selectName == "Doctor") {
                                Doctors(index, value);
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
                    } else {
                        $(".searchshow").find('.row').html(`<h3 class="text-center m-0">${res.message}</h3>`)
                    }
                },
                complete: () => {
                    $(".Loading").addClass("d-none")
                }
            })
        }

        function Diagnostics(index, value) {
            var row = `
                    <div class="col-md-4 mb-3">
                        <a href="/single-details-diagnostic/${value.id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex position-relative" style="padding: 5px;gap: 8px;">
                                    ${value.discount_amount > 0 ? '<p style="position: absolute;bottom: 5px;right: 10px;" class="m-0 text-danger">সকল প্রকার সার্ভিসের উপরে <span class="text-decoration-underline">'+value.discount_amount+'%</span> ছাড়।</p>':''}
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="${value.image != '0' ?'/'+value.image: '/frontend/img/diagnostic.png'}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>${value.name}</h6>
                                        <p class="text-capitalize" style="color:#c99913;">${value.diagnostic_type}, ${value.city_name}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> ${value.address}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
        `;
            $(".searchshow").find('.row').append(row)
        }

        function Hospitals(index, value) {
            var row = `
                    <div class="col-md-4 mb-3">
                        <a href="/single-details-hospital/${value.id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex position-relative" style="padding: 5px;gap: 8px;">
                                    ${value.discount_amount > 0 ? '<p style="position: absolute;bottom: 5px;right: 10px;" class="m-0 text-danger">সকল প্রকার সার্ভিসের উপরে <span class="text-decoration-underline">'+value.discount_amount+'%</span> ছাড়।</p>':''}
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="${value.image != '0' ?'/'+value.image: '/frontend/img/hospital.png'}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>${value.name}</h6>
                                        <p class="text-capitalize" style="color:#c99913;">${value.hospital_type}, ${value.city_name}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> ${value.address}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
        `;
            $(".searchshow").find('.row').append(row)
        }

        function Ambulances(index, value) {
            var row = `
                    <div class="col-md-4 mb-3">
                        <a href="/single-details-ambulance/${value.id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="${value.image != '0' ? value.image:'/frontend/img/ambulance.png'}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>${value.name}</h6>
                                        <p style="color:#c99913;">${value.ambulance_type}, ${value.city_name}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> ${value.address}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
        `;
            $(".searchshow").find('.row').append(row)
        }

        function Privatecars(index, value) {
            var row = `
                    <div class="col-md-4 mb-3">
                        <a href="/single-details-privatecar/${value.privatecar_id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="${value.image != '0' ? '/'+value.image:'/frontend/img/privatecar.png'}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>${value.name}</h6>
                                        <p style="color:#c99913;">${value.cartype}, ${value.city_name}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> ${value.address}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            `;
            $(".searchshow").find('.row').append(row)
        }

        function Doctors(index, value) {
            var row = `
                    <div class="col-md-4 mb-3">
                        <a href="/single-details-doctor/${value.doctor_id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;overflow:hidden;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img height="100%" src="${value.image != '0'?value.image:'/uploads/nouserimage.png'}" width="100">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>${value.name}</h6>
                                        <p style="color:#c99913;">${value.department_name}, ${value.city_name}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;">${value.education}</p>
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
            s1.src = 'https://embed.tawk.to/642e8c394247f20fefea22e2/1gtat7h2i';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>