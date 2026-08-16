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
                        <h1 class="text-center">ABOUT US</h1>
                        <div class="breadcrumb-bar">
                            <ul class="breadcrumb text-center">
                                <li><a href="index.html">Home</a></li>
                                <li>ABOUT US</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
        <!--About Area Start-->
    <div class="about-area mt-70 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title-wrapper">
                        <div class="section-title">
                            <h3>ABOUT US</h3>
                            <p>There are many variations of passages</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="about-container">
                        <h3>Bring <span class="orange-color">Fun</span> <span class="orange-color">Life</span> for your kids
                        </h3>
{!! $about->description_one !!}
                        <a class="button-default" href="{{ route('home') }}">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <!--About Image Area Start-->
                    <div class="about-image-area img-full">
                        <img src="{{  asset($about->user_image) ??  asset('client/img/about/about1.jpg') }}" alt="">
                    </div>
                    <!--About Image Area End-->
                </div>
            </div>
        </div>
    </div>
    <!--End of About Area-->

@endsection

@section('script')

@endsection