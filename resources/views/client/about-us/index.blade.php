@extends('client.layout.app')

@section('style')
    <style>
        .about-image-area img {
            width: 100%;
            height: auto;
            display: block;
        }

        .about-content {
            line-height: 1.8;
        }

        .about-section {
            margin-top: 60px;
        }

        .about-section h3 {
            margin-bottom: 20px;
        }

        .about-section-content {
            line-height: 1.8;
        }

        .about-list {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .about-list li {
            position: relative;
            padding-left: 28px;
            margin-bottom: 15px;
            line-height: 1.7;
        }

        .about-list li:before {
            content: "\f00c";
            font-family: FontAwesome;
            position: absolute;
            left: 0;
            top: 2px;
            color: #f5a623;
        }

        .about-advantage-image img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
@endsection

@section('content')

    {{-- Breadcrumb Banner --}}
    <div class="breadcrumb-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="breadcrumb-text">

                        <h1 class="text-center">
                            ABOUT US
                        </h1>

                        <div class="breadcrumb-bar">
                            <ul class="breadcrumb text-center">
                                <li>
                                    <a href="{{ route('home') }}">
                                        Home
                                    </a>
                                </li>

                                <li>
                                    ABOUT US
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- About Area --}}
    <div class="about-area mt-70 pb-70">

        <div class="container">

            {{-- Page Title --}}
            <div class="row">

                <div class="col-md-12">

                    <div class="section-title-wrapper">

                        <div class="section-title">

                            <h3>
                                ABOUT US
                            </h3>

                            <p>
                                Indian Abacus Academy
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- About Content --}}
            <div class="row align-items-center">

                {{-- Description --}}
                <div class="col-lg-7">

                    <div class="about-container">

                        <h3>
                            Bring
                            <span class="orange-color">Fun</span>
                            <span class="orange-color">Life</span>
                            for your kids
                        </h3>

                        <div class="about-content">

                            {!! $about->description_one !!}

                        </div>

                    </div>

                </div>


                {{-- About Image --}}
                <div class="col-lg-5">

                    <div class="about-image-area img-full">

                        @if(!empty($about->user_image))

                            <img
                                src="{{ asset($about->user_image) }}"
                                style="width: 100%; height: auto;"
                                alt="Indian Abacus Academy">

                        @else

                            <img
                                src="{{ asset('client/img/about/about1.jpg') }}"
                                alt="Indian Abacus Academy">

                        @endif

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 ABACUS ADVANTAGES
            ====================================================== --}}

            @if(!empty($about->abacus_advantage))

                <div class="row about-section align-items-center">

                    <div class="col-lg-7">

                        <div class="about-container">

                            <h3>
                                Abacus
                                <span class="orange-color">
                                    Advantages
                                </span>
                            </h3>

                            <div class="about-section-content">

                                {!! $about->abacus_advantage !!}

                            </div>

                        </div>

                    </div>


                    {{-- Advantage Image --}}
                    @if(!empty($about->advantage_image))

                        <div class="col-lg-5">

                            <div class="about-advantage-image">

                                <img
                                    src="{{ asset($about->advantage_image) }}"
                                    alt="Abacus Advantages">

                            </div>

                        </div>

                    @endif

                </div>

            @endif


            {{-- =====================================================
                 OUR VISION
            ====================================================== --}}

            @if(!empty($about->vision))

                <div class="row about-section">

                    <div class="col-md-12">

                        <div class="about-container">

                            <h3>
                                Our
                                <span class="orange-color">
                                    Vision
                                </span>
                            </h3>


                            <ul class="about-list">

                                @foreach($about->vision as $vision)

                                    @if(!empty($vision))

                                        <li>
                                            {{ $vision }}
                                        </li>

                                    @endif

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- =====================================================
                 OUR MISSION
            ====================================================== --}}

            @if(!empty($about->mission))

                <div class="row about-section">

                    <div class="col-md-12">

                        <div class="about-container">

                            <h3>
                                Our
                                <span class="orange-color">
                                    Mission
                                </span>
                            </h3>


                            <ul class="about-list">

                                @foreach($about->mission as $mission)

                                    @if(!empty($mission))

                                        <li>
                                            {{ $mission }}
                                        </li>

                                    @endif

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection


@section('script')

@endsection