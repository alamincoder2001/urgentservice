<section id="footer" class="text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-6">
                <h2 class="text-uppercase text-secondary">About Urgent Service BD</h2>
                <div class="footer-body">
                    <ul>
                        <li><a href="{{route('website')}}">Home</a></li>
                        <li><a href="">About us</a></li>
                        <li><a href="">Contact us</a></li>
                        <li><a href="#">Terms & conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <h2 class="text-uppercase text-secondary">Urgent Service BD Center</h2>
                <div class="footer-body">
                    <ul>
                        <li style="margin-bottom: 5px;">
                            <i class="fa fa-calendar-o" style="background: #937171;padding: 7px;"></i> <span class="text-dark">Monday - Saturday, 8am to 10pm</span>
                        </li>
                        <li style="margin-bottom: 5px;">
                            <i class="fa fa-phone" style="background: #937171;padding: 6px 7px;font-size:19px;"></i> <span class="text-dark">{{$contact->phone}}</span>
                        </li>
                        <li style="margin-bottom: 5px;">
                            <i class="fa fa-envelope-o" style="background: #937171;padding: 7px;"></i> <span class="text-dark">{{$contact->email}}</span>
                        </li>
                    </ul>
                </div>
            </div>
            @php
                $contact = App\Models\Contact::first();    
            @endphp
            <div class="col-md-4 col-12">
                <h2 class="text-uppercase text-secondary">Our Location</h2>
                <p class="mb-2 text-dark text-capitalize">{{$contact->address}}, {{$contact->phone}}</p>

                <div class="footer-body">
                    <h4 class="text-secondary">News Letter</h4>
                    <div class="news-letter">
                        <form action="" class="d-flex m-0">
                            <div class="input-group">
                                <input type="text" placeholder="Your Email">
                                <button class="fa fa-paper-plane"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="positionabsolute">
    <i class="fa fa-arrow-up"></i>
</div>