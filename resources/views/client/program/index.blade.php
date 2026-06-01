@extends('client.layout.app')

@section('style')

    <style>
        .program-page {
            background: #fff;
        }

        /* SECTION TITLE */
        .section-title h2 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #2d3e50;
        }

        .section-title p {
            font-size: 16px;
            color: #666;
            line-height: 1.9;
        }

        /* CONTENT */
        .program-content {
            /* max-width: 950px; */
                width: 100%;
            margin: 0 auto;
            text-align: justify;
        }

        .program-content p {
            font-size: 17px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 22px;
        }

        /* PROGRAM CARDS */
        .single-program-card {
            margin-bottom: 30px;
        }

        .program-card-inner {
            background: #fff;
            border-radius: 20px;
            padding: 35px 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
            height: 100%;
            transition: 0.3s;
            text-align: center;
            border: 1px solid #f2f2f2;
        }

        .program-card-inner:hover {
            transform: translateY(-8px);
        }

        .program-card-inner h3 {
            font-size: 28px;
            margin-bottom: 15px;
            color: #111;
            font-weight: 700;
        }

        .program-duration {
            display: inline-block;
            margin-bottom: 18px;
            background: #fff4ed;
            color: #ff6b00;
            padding: 8px 18px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
        }

        .program-card-inner p {
            color: #666;
            line-height: 1.9;
            margin-bottom: 0;
        }

        /* BENEFITS */
        .abacus-benefits {
            background: #fff7f2;
            padding: 50px;
            border-radius: 25px;
        }

        .abacus-benefits ul {
            margin: 0;
            padding: 0;
            columns: 2;
        }

        .abacus-benefits ul li {
            list-style: none;
            margin-bottom: 18px;
            position: relative;
            padding-left: 35px;
            font-size: 17px;
            color: #333;
        }

        .abacus-benefits ul li:before {
            content: "✓";
            position: absolute;
            left: 0;
            top: 0;
            color: #ff6b00;
            font-size: 20px;
            font-weight: bold;
        }

        /* IMAGE */
        .abacus-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        /* FINAL CONTENT */
        .final-program-text {
            padding-left: 20px;
        }

        .final-program-text h3 {
            font-size: 28px;
            line-height: 1.5;
            color: #111;
            font-weight: 700;
        }

        .final-program-text h4 {
            color: #FFAE27;
            font-size: 24px;
            font-weight: 700;
            margin-top: 20px;
        }

        .final-program-text p {
            margin-top: 20px;
            line-height: 1.8;
            color: #666;
            font-size: 16px;
        }

        /* MOBILE */
        @media(max-width: 991px) {

            .final-program-text {
                padding-left: 0;
                margin-top: 40px;
                text-align: center;
            }

        }

        @media(max-width: 767px) {

            .section-title h2 {
                font-size: 30px;
            }

            .program-content p {
                font-size: 15px;
            }

            .abacus-benefits {
                padding: 30px;
            }

            .abacus-benefits ul {
                columns: 1;
            }

            .final-program-text h3 {
                font-size: 24px;
            }

            .final-program-text h4 {
                font-size: 20px;
            }

        }
    </style>

@endsection

@section('content')

    <div class="program-page">

        <!-- BREADCRUMB -->
        <div class="breadcrumb-banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <div class="breadcrumb-text text-center">

                            <h1>PROGRAMS</h1>

                            <div class="breadcrumb-bar">
                                <ul class="breadcrumb justify-content-center">
                                    <li>
                                        <a href="{{ route('home') }}">
                                            Home
                                        </a>
                                    </li>

                                    <li>Programs</li>
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END BREADCRUMB -->

        <!-- PROGRAM SECTION -->
        <div class="container pt-70 pb-100">

            <div class="container">

                <!-- SECTION TITLE -->
                <div class="row justify-content-center">

                    <div class="col-lg-10">

                        <div class="section-title text-center mb-30">

                            <h2>
                                <span class="orange-color">Abacus</span> Program
                            </h2>

                            <p>
                                Empowering children with faster calculation,
                                sharper memory, stronger concentration and
                                complete brain development through Abacus learning.
                            </p>

                        </div>

                    </div>

                </div>

                <!-- INTRO CONTENT -->
                <div class="row justify-content-center">

                    <div class="col-lg-12">

                        <div class="program-content">

                            <p>
                                The future of our children lies in their early mental development.
                                Children need to equip themselves with the building blocks of
                                global thinking by optimizing and integrating the left and right
                                functions of the brain during their early years.
                            </p>

                            <p>
                                The Abacus program aims at enhancing and optimizing the child’s
                                hidden potential such as imagination, creativity and computation
                                skills to evoke their senses and improve comprehension.
                            </p>

                            <p>
                                Abacus is an educational tool through which children can learn
                                fast calculations and numbers in a fun and engaging way. The child
                                uses fingers to move the beads on the abacus and this collaborative
                                movement of the fingers and brain helps create photographic memory.
                            </p>

                            <p>
                                During Abacus practice, children use both hands which activates
                                both the left and right sides of the brain, helping in brain
                                development, faster thinking and improved accuracy.
                            </p>

                        </div>

                    </div>

                </div>

                <!-- PROGRAM LIST -->
                <div class="row">
                    @foreach ($academyPrograms as $program)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-item mb-50 mt-50">

                                <!-- IMAGE -->
                                <div class="single-item-image overlay-effect">
                                    <a href="#">
                                        <img src="{{ $program->image ? asset($program->image) : asset('client/img/course/1.jpg') }}"
                                            alt="{{ $program->name }}" style="height: 80px; width: auto; margin-top: 20px;">
                                    </a>
                                </div>
                                <!-- CONTENT -->
                                <div class="single-item-text">
                                    <h4>
                                        <a href="#">
                                            {{ $program->name }}
                                        </a>
                                    </h4>

                                    <p>
                                        {{ $program->description }}
                                    </p>

                                    <div class="single-item-content">
                                        <div class="single-item-comment-view">
                                            <strong>


                                                {{ $program->duration }}

                                            </strong>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- SECOND CONTENT -->
                <div class="row justify-content-center mt-50">

                    <div class="col-lg-11">

                        <div class="program-content">
                            <p>
                                Indian Abacus Academy Tool also helps children with visual
                                impairments immensely. Allowing them to use numbers in a
                                more physical manner rather than only visual techniques,
                                Abacus education benefits all children.
                            </p>
                            <p>
                                Understanding number systems becomes easier through Abacus
                                training, making mathematics less difficult and more enjoyable.
                                Children can learn addition, subtraction, multiplication and
                                division with confidence.
                            </p>
                            <p>
                                Abacus education helps children reach their true potential,
                                increases confidence levels and prepares them with the right
                                skills to face today’s competitive world.
                            </p>

                        </div>

                    </div>

                </div>

                <!-- BENEFITS -->
                <div class="row justify-content-center mt-60">

                    <div class="col-lg-12">

                        <div class="abacus-benefits">

                            <ul>
                                <li>Better concentration</li>
                                <li>Memory improvement</li>
                                <li>Quick calculation</li>
                                <li>Develop creativity</li>
                                <li>Confidence building</li>
                                <li>Learning ability</li>
                                <li>Reading and writing skills</li>
                                <li>Visualization power</li>
                                <li>Increase mental agility</li>
                                <li>No need of electronic gadgets</li>
                                <li>Efficient use of brain power</li>
                            </ul>

                        </div>

                    </div>

                </div>

                <!-- IMAGE + CONTENT -->
                <div class="row align-items-center mt-80">

                    <!-- IMAGE -->
                    <div class="col-lg-5">

                        <div class="abacus-image">

                            <img src="{{ asset('client/img/program/programs.jpg') }}" alt="Abacus Program">

                        </div>

                    </div>

                    <!-- CONTENT -->
                    <div class="col-lg-7">

                        <div class="final-program-text">

                            <h3>
                                DEVELOPING THE RIGHT AND LEFT BRAIN PARTS AT THE SAME TIME
                            </h3>

                            <h4>
                                NO FEAR FROM MATHS = WHOLE BRAIN DEVELOPMENT
                            </h4>

                            <p>
                                Abacus education trains children to think faster,
                                calculate accurately and improve their overall brain
                                development. It strengthens concentration, memory,
                                creativity and confidence from an early age.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <!-- END PROGRAM SECTION -->

    </div>

@endsection

@section('script')

@endsection