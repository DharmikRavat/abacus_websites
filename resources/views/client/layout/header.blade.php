<header>
<div class="header-banner">
    <div class="header-banner-overlay">
        <div class="container">
            <div class="header-banner-content">


                {{-- Logo + Academy Text --}}
                <div class="header-brand">

<a href="{{ route('home') }}" class="header-banner-logo">
    <img src="{{ !empty($settings->company_logo)
            ? asset($settings->company_logo)
            : asset('client/abacusacademyLogo.png') }}"
         alt="{{ $settings->company_name ?? 'India Abacus Academy' }}"
         style="height:80px; width:auto; object-fit:contain;">
</a>

                    <div class="header-brand-text">
                        <div class="academy-name">
                            Indian Abacus Academy
                        </div>

                        <div class="academy-tagline">
                            An international institute of mental math and brain development
                        </div>
                    </div>

                </div>


                {{-- Login Right --}}
                <div class="header-login">
<div class="iso-certified">
    ISO 9001:2015 Certified Institute
</div>
                    @if(session()->has('student_id'))

                        <div class="dropdown">

                            <a href="#"
                               class="d-flex align-items-center dropdown-toggle"
                               data-bs-toggle="dropdown"
                               style="text-decoration:none; color:inherit;">

                                <div style="
                                    width:40px;
                                    height:40px;
                                    border-radius:50%;
                                    background:#007bff;
                                    color:white;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-weight:600;
                                ">
                                    {{ strtoupper(substr(session('student_name'), 0, 1)) }}
                                </div>

            {{-- Full Student Name Outside Circle --}}
            <span style="
                margin-left:10px;
                font-size:14px;
                font-weight:600;
                color:#333;
                white-space:nowrap;
            ">
                {{ session('student_name') }}
            </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                       href="{{ url('/dashboard') }}">
                                        <i class="fa fa-tachometer" style="margin-right:8px;"></i>
                                        Dashboard
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                       href="{{ route('logout') }}">
                                        <i class="fa fa-power-off" style="margin-right:8px;"></i>
                                        Logout
                                    </a>
                                </li>

                            </ul>

                        </div>

                    @else

                        <button type="button"
                                class="login-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#loginModal">
                            <i class="fas fa-right-to-bracket"></i>
                            Login
                        </button>

                    @endif

                </div>

            </div>
        </div>
    </div>
</div>

    <div class="header-logo-menu sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="mainmenu-area pull-right">
                        <div class="mainmenu d-none d-lg-block">
                            <nav>
                                <ul id="nav">
                                    <li><a href="{{ route('home') }}"><i class="fas fa-home m-2"></i>Home</a></li>
                                    <li><a href="{{ route('about-us') }}"><i class="fas fa-circle-info m-2"></i>About Us</a></li>
                                    <li><a href="{{ route('gallery') }}"> <i class="fas fa-images m-2"></i>Gallery</a>
                                    </li>
                                    <li><a href="{{ route('programs') }}"> <i class="fas fa-graduation-cap m-2"></i>Programs</a>
                                    </li>
                                    <li><a href="{{ route('franchise') }}"> <i class="fas fa-handshake m-2"></i>Franchise</a></li>
                                    <li>
                                        <a href="{{ session()->has('student_id') ? url('/dashboard') : url('student-login') }}">
                                            <i class="fas fa-file-pen m-2"></i>Exam/Test
                                        </a>
                                    </li>
                                    {{-- https://eazypay.icicibank.com/eazypayLink?P1=3oKg52vCU3oCVzaDaX4oRw== --}}
                                       <li><a href="https://eazypay.icicibank.com/eazypayLink?P1=3oKg52vCU3oCVzaDaX4oRw==" target="_blank">  <i class="fas fa-credit-card m-2"></i>Payment</a>
                                    </li>
                                    {{-- <li><a href="#">Payment</a>
                                    </li> --}}

                                    <li><a href="{{ route('contact-us') }}">  <i class="fas fa-envelope m-2"></i>Contact Us</a></li>
                                    <!-- LOGIN BUTTON -->

                                </ul>
                            </nav>
                        </div>

                        {{--
                        <ul class="header-search">
                            <li class="search-menu">
                                <i id="toggle-search" class="zmdi zmdi-search"></i>
                            </li>

                        </ul> --}}
                        <!--Search Form-->
                        {{-- <div class="search">
                            <div class="search-form">
                                <form id="search-form" action="#">
                                    <input type="search" placeholder="Search here..." name="search" />
                                    <button type="submit">
                                        <span><i class="fa fa-search"></i></span>
                                    </button>
                                </form>
                            </div>
                        </div> --}}
                        <!--End of Search Form-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area start -->
    <div class="mobile-menu-area">
        <div class="container clearfix">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul>
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('about-us') }}">About</a></li>
                                    <li><a href="{{ route('gallery') }}">Gallery</a>
                                    </li>
                                    <li><a href="{{ route('programs') }}">Programs</a>
                                    </li>
                                    <li><a href="{{ route('franchise') }}">Franchise</a></li>
                                    <li><a href="{{ route('exam-test') }}">Exam/Test</a>
                                    {{-- https://eazypay.icicibank.com/eazypayLink?P1=3oKg52vCU3oCVzaDaX4oRw== --}}
                                       <li><a href="https://eazypay.icicibank.com/eazypayLink?P1=3oKg52vCU3oCVzaDaX4oRw==" target="_blank">Payment</a>
                                    </li>
                                    {{-- <li><a href="#">Payment</a>
                                    </li> --}}

                                    <li><a href="{{ route('contact-us') }}">Contact</a></li>
                                    <!-- LOGIN BUTTON -->
                                    <li>

                                        @if(session()->has('student_id'))

                                                                    <div class="dropdown">

                                                                        <a href="#" class="d-flex align-items-center dropdown-toggle"
                                                                            data-bs-toggle="dropdown"
                                                                            style="text-decoration: none; color: inherit;">

                                                                            {{-- Profile Icon --}}
                                                                            <div style="
                                                width:40px;
                                                height:40px;
                                                border-radius:50%;
                                                background:#007bff;
                                                color:white;
                                                display:flex;
                                                align-items:center;
                                                justify-content:center;
                                                font-weight:600;
                                                margin-right:10px;
                                            ">
                                                                                {{ strtoupper(substr(session('student_name'), 0, 1)) }}
                                                                            </div>

                                                                            {{-- Student Name --}}
                                                                            {{-- <span>
                                                                                {{ session('student_name') }}
                                                                            </span> --}}

                                                                        </a>

                                                                        {{-- Dropdown Menu --}}
                                                                        {{-- Dropdown Menu --}}
                                                                        <ul class="dropdown-menu">

                                                                            <li>
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="{{ url('/dashboard') }}">

                                                                                    <i class="fa fa-tachometer" style="margin-right:8px;"></i>

                                                                                    Dashboard
                                                                                </a>
                                                                            </li>

                                                                            <li>
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="{{ route('logout') }}">

                                                                                    <i class="fa fa-power-off" style="margin-right:8px;"></i>

                                                                                    Logout
                                                                                </a>
                                                                            </li>

                                                                        </ul>

                                                                    </div>

                                        @else

                                            {{-- LOGIN BUTTON --}}
                                          <button type="button"
        class="login-btn mt-3"
        data-bs-toggle="modal"
        data-bs-target="#loginModal">
    Login
</button>
                                        @endif

                                    </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area end -->
</header>