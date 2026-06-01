@extends('client.layout.app')

@section('style')
    <style>
        .exam-section {
            background: #fff;
        }

        .exam-box {
            padding: 40px 35px;
            min-height: 690px;
            position: relative;
        }

        .practice-box {
            background: #dfe7ff;
        }

        .test-box {
            background: #e6f6df;
        }

        .exam-main-box {
            background: #f2f2f2;
        }

        /* ICON */
        .exam-top-icon {
            position: absolute;
            right: 25px;
            top: 20px;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .exam-top-icon.green {
            background: #3db54a;
        }

        .exam-top-icon.dark {
            background: #222;
        }

        .exam-top-icon img {
            width: 24px;
        }

        /* TITLE */
        .exam-box h2 {
            text-align: center;
            margin-bottom: 35px;
            font-size: 32px;
            font-weight: 600;
            color: #333;
        }

        .green-text {
            color: #2daa3f !important;
        }

        /* FORM */
        .exam-form-group {
            margin-bottom: 30px;
        }

        .exam-form-group label {
            display: block;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 10px;
            color: #333;
        }

        .exam-form-group input {
            height: 50px;
            border-radius: 5px;
            border: 1px solid #d9d9d9;
            box-shadow: none;
            padding-left: 15px;
        }

        /* BUTTON GROUP */
        .mode-wrapper {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .mode-btn {
            flex: 1;
            height: 48px;
            border: 1px solid #0d6efd;
            background: transparent;
            color: #0d6efd;
            border-radius: 5px;
            font-size: 18px;
            font-weight: 500;
            transition: .3s;
        }

        .mode-btn.active,
        .mode-btn:hover {
            background: #0d6efd;
            color: #fff;
        }

        /* GREEN */
        .green-btn {
            border-color: #3db54a;
            color: #2daa3f;
        }

        .green-btn.active,
        .green-btn:hover {
            background: #3db54a;
            color: #fff;
        }

        /* DARK */
        .dark-btn {
            border-color: #777;
            color: #444;
        }

        .dark-btn:hover {
            background: #333;
            color: #fff;
        }

        /* LEVEL BUTTON */
        .level-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-top: 20px;
        }

        .level-btn {
            width: 52px;
            height: 52px;
            border-radius: 6px;
            border: 1px solid #0d6efd;
            background: transparent;
            color: #0d6efd;
            font-size: 24px;
            transition: .3s;
        }

        .level-btn:hover {
            background: #0d6efd;
            color: #fff;
        }

        /* GREEN LEVEL */
        .green-level {
            border-color: #3db54a;
            color: #2daa3f;
        }

        .green-level.active,
        .green-level:hover {
            background: #3db54a;
            color: #fff;
        }

        /* DARK LEVEL */
        .dark-level {
            border-color: #777;
            color: #444;
        }

        .dark-level:hover {
            background: #333;
            color: #fff;
        }

        /* START BUTTON */
        .exam-btn-area {
            text-align: center;
            margin-top: 55px;
        }

        .start-btn {
            min-width: 330px;
            height: 50px;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 20px;
            font-weight: 500;
            transition: .3s;
        }

        .practice-btn {
            background: #0d6efd;
        }

        .test-btn {
            background: #34b44a;
        }

        .exam-btn-dark {
            background: #343a40;
        }

        .start-btn:hover {
            transform: translateY(-3px);
        }

        /* MOBILE */
        @media(max-width:991px) {

            .exam-box {
                min-height: auto;
            }

            .start-btn {
                min-width: 100%;
            }

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
                        <h1 class="text-center">Exam/Test</h1>
                        <div class="breadcrumb-bar">
                            <ul class="breadcrumb text-center">
                                <li><a href="index.html">Home</a></li>
                                <li>Exam/Test</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->

    <!--Exam Area Start-->
    <!--Exam Area Start-->
    <div class="exam-section pt-80 pb-80">
        <div class="container px-0">

            <div class="row">

                <!-- FREE PRACTICE -->
                <div class="col-lg-4">
                    <div class="exam-box practice-box">

                        <div class="exam-top-icon">
                            <a href="{{ route('exam-score') }}"><img src="{{ asset('client/img/program/practice-score.png') }}"
                                    alt=""></a>
                        </div>

                        <h2>Free Practice</h2>

                        <!-- INPUT -->
                        <div class="exam-form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter Your Full Name">
                        </div>

                        <div class="exam-form-group">
                            <label>Center</label>
                            <input type="text" class="form-control" placeholder="Enter Your Center Name">
                        </div>

                        <!-- MODE -->
                        <div class="exam-form-group">
                            <label>Choose Mode</label>

                            <div class="mode-wrapper">
                                <button class="mode-btn active">Easy</button>
                                <button class="mode-btn">Medium</button>
                                <button class="mode-btn">Hard</button>
                            </div>
                        </div>

                        <!-- LEVEL -->
                        <div class="exam-form-group">
                            <label>Choose Level</label>

                            <div class="level-wrapper">
                                @for ($i = 0; $i <= 10; $i++)
                                    <button class="level-btn">
                                        {{ $i }}
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <div class="exam-btn-area">
                            <button class="start-btn practice-btn">
                                Start Practice
                            </button>
                        </div>

                    </div>
                </div>

                <!-- ONLINE TEST -->
                <div class="col-lg-4">
                    <div class="exam-box test-box">

                        <div class="exam-top-icon green">
                            <a href="{{ route('exam-score') }}"><img src="{{ asset('client/img/program/practice-score.png') }}"
                                    alt=""></a>
                        </div>

                        <h2 class="green-text">Online Test</h2>

                        <!-- INPUT -->
                        <div class="exam-form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter Your Full Name">
                        </div>

                        <div class="exam-form-group">
                            <label>Center</label>
                            <input type="text" class="form-control" placeholder="Enter Your Center Name">
                        </div>

                        <!-- TEST TYPE -->
                        <div class="exam-form-group">
                            <label>Choose Test Type</label>

                            <div class="mode-wrapper">
                                <button class="mode-btn green-btn active">
                                    Weekly Test
                                </button>

                                <button class="mode-btn green-btn">
                                    Monthly Test
                                </button>
                            </div>
                        </div>

                        <!-- LEVEL -->
                        <div class="exam-form-group">
                            <label>Choose Level</label>

                            <div class="level-wrapper">
                                @for ($i = 0; $i <= 10; $i++)
                                    <button class="level-btn green-level {{ $i == 0 ? 'active' : '' }}">
                                        {{ $i }}
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <div class="exam-btn-area">
                            <button class="start-btn test-btn">
                                Start Test
                            </button>
                        </div>

                    </div>
                </div>

                <!-- ONLINE EXAM -->
                <div class="col-lg-4">
                    <div class="exam-box exam-main-box">

                        <div class="exam-top-icon dark">
                            <a href="{{ route('exam-score') }}"><img src="{{ asset('client/img/program/practice-score.png') }}"
                                    alt=""></a>
                        </div>

                        <h2>Online Exam</h2>

                        <!-- INPUT -->
                        <div class="exam-form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter Your Full Name">
                        </div>

                        <div class="exam-form-group">
                            <label>Center</label>
                            <input type="text" class="form-control" placeholder="Enter Your Center Name">
                        </div>

                        <!-- EXAM TYPE -->
                        <div class="exam-form-group">
                            <label>Choose Exam Type</label>

                            <div class="mode-wrapper">
                                <button class="mode-btn dark-btn">
                                    Olympiad
                                </button>

                                <button class="mode-btn dark-btn">
                                    Final Exam
                                </button>
                            </div>
                        </div>

                        <!-- LEVEL -->
                        <div class="exam-form-group">
                            <label>Choose Level</label>

                            <div class="level-wrapper">
                                @for ($i = 0; $i <= 10; $i++)
                                    <button class="level-btn dark-level">
                                        {{ $i }}
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <div class="exam-btn-area">
                            <button class="start-btn exam-btn-dark">
                                Start Exam
                            </button>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
    <!--Exam Area End-->
    <!--Exam Area End-->

@endsection

@section('script')

@endsection