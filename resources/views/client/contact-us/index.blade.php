@extends('client.layout.app')

@section('style')
    <style>

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
                                <li><a href="index.html">Home</a></li>
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
                                            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-google-plus-g"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-12 col-lg-6 yellow-bg">
                                <div class="contact-form-wrap">
                                    <h2 class="contact-title">SEND YOUR MESSAGE</h2>
                                    <form id="contact-form" action="mail.php" method="post">
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
                                                    <button class="button-default" type="submit"><span>Send Email</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <p class="form-messege"></p>
                                </div>
                            </div>
                        </div>
                        <div>Map section</div>
                    </div>
                </div>
    
@endsection

@section('script')

@endsection