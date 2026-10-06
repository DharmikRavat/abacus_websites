@extends('client.layout.app')

@section('style')
    <style>
.map-area {
    overflow: hidden;
    border-radius: 10px;
    margin-top: 30px;
}

.map-area iframe {
    display: block;
    width: 100%;
}
    </style>

@endsection
@section('content')


    <!--Breadcrumb Banner Area Start-->
    <div class="breadcrumb-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h1 class="text-center">Contact</h1>
                        <div class="breadcrumb-bar">
                            <ul class="breadcrumb text-center">
                                 <li><a href="{{route('home')}}">Home</a></li>
                                <li>Contact</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
    <!--Contact Area Start-->
                <div class="contact-area pt-100 pb-100">
                    <div class="container">
                        <div class="row g-0">
                           <div class="col-md-12 col-lg-6 blue-bg">
                                <div class="edubuzz-address">
                                    <h2 class="contact-title">You Can Contact With Us</h2>
                                    <p>Cconnect with us for further clarification. <br> To train mind of your child, to make them better human being, to make them better citizen.
                                    <br>Better Minds, Better Future.</p>

                                    <ul>
                                        <li><i class="fa fa-fax"></i> Address : {{ $settings->company_address ?? "" }}</li>
                                        <li><i class="fa fa-phone"></i> Phone : {{ $settings->company_phone ?? "" }}</li>
                                        <li><i class="fa fa-envelope"></i> Email: {{ $settings->company_email ?? "" }}</li>
                                    </ul>
                                    <div class="contact-social">
                                        <h3><strong>Also Can Find Us</strong></h3>
                                        <ul>
                                            <li>
                                                <a href="{{ $settings->facebook_url }}" target="_blank">
                                                    <i class="fa-brands fa-facebook-f"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ $settings->twitter_url }}" target="_blank">
                                                    <i class="fa-brands fa-twitter"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ $settings->google_plus_url }}" target="_blank">
                                                    <i class="fa-brands fa-google-plus-g"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ $settings->instagram_url }}" target="_blank">
                                                    <i class="fa-brands fa-instagram"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                           <div class="col-md-12 col-lg-6 yellow-bg">
                                <div class="contact-form-wrap">
                                    <h2 class="contact-title">SEND YOUR MESSAGE</h2>
                                    <form id="contact-form" action="{{ route('contact.submit') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="contact-form-style mb-20">
                                                    <input name="name" placeholder="Name*" type="text">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="contact-form-style mb-20">
                                                    <input name="phone" placeholder="Phone*" type="text">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="contact-form-style mb-20">
                                                    <input name="email" placeholder="Email*" type="email">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="contact-form-style">
                                                    <textarea name="message" placeholder="Type your message here.."></textarea>
                                                    <button class="button-default" type="submit"><span>Send Message</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    {{-- <p class="form-messege"></p> --}}
                                </div>
                            </div>
                        </div>
                      <!-- Map Section Start -->
<div class="row mt-5">
    <div class="col-12">
        <div class="map-area">
            <iframe
                src="https://www.google.com/maps?q={{ urlencode($settings->company_address ?? '') }}&output=embed"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>
<!-- Map Section End -->
                    </div>
                </div>

@endsection

@section('script')

@endsection