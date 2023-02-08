@extends("layouts.master")

@push("style")
<style>
    #aboutus .aboutus-header {
        background-image: url("{{asset('frontend')}}/img/aboutus.png");
        background-position: center;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        height: 300px;
    }

    #aboutus h1 {
        font-size: 65px;
        font-weight: 900;
        color: #180d56;
        animation-name: example;
        animation-duration: 10s;
        animation-iteration-count: infinite;
    }

    @keyframes example {
        0% {
            color: red;
        }

        25% {
            color: gray;
        }

        50% {
            color: blue;
        }

        100% {
            color: green;
        }
    }
</style>
@endpush

@section("content")
<section id="aboutus">
    <div class="container py-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <h1 class="text-uppercase">About Us</h1>
            </div>
            <div class="col-md-6">
                <div class="aboutus-header border"></div>
            </div>
        </div>

        <div class="aboutus-body">
            <p class="py-2" style="text-align: justify;">
                The Doctors in our country and several other states are selected through the use of gruelling and cumbersome selection procedures. The exams are confusing and hard to crack. The systems are complicated because of the profession, which calls for strict testing. The doctors are entrusted with the duty of saving lives, and hence it is important to know if they are trustworthy. Many doctors are essential in the field of research. They not only help build a better and healthier country but also provide for important medicines that can save lives.
                An organization called Doctors without borders helps provide free and cheap healthcare to the rural areas of various countries across the world. These doctors travel to the interiors of the world where diseases are common and often incurable. They find medicines and treatments for the same through vigorous research and documentation. They document rare cases and medical problems to find a solution for the same in the long run.
                Doctors run a nation where healthcare is of pivotal importance. If the safety of the citizen is not looked after, then the quality of human resources that a country is looking to nurture will be dismal. We can hence conclude that the Doctor is capable of performing multiple tasks.
            </p>

            <h4 style="color: #565555;">Mission:</h4>
            <p>Sardar Pharma is on a mission to make quality healthcare affordable and accessible for over millions Bangladeshi citizens. We believe in empowering our users with the most accurate, comprehensive, and curated information and care, enabling them to make better healthcare decisions.</p>
            <h4 style="color: #565555;">Services:</h4>
            <ol class="p-0 pl-3" style="margin-left: 18px;">
                <li style="font-size: 13px;">Doctors Appointment.</li>
                <li style="font-size: 13px;">Hospital Information.</li>
                <li style="font-size: 13px;">Diagnostic Information.</li>
                <li style="font-size: 13px;">Blood Donar Information</li>
                <li style="font-size: 13px;">Ambulance Service</li>
                <li style="font-size: 13px;">Sample collection for Diagnostics.</li>
            </ol>
        </div>
    </div>
</section>
@endsection
