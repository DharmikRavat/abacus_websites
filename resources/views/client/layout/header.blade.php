<header>
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-12">
                    <span>Have any question? {{ $settings->company_phone ?? "" }}</span>
                </div>
                <div class="col-lg-5 col-md-6 col-12">
                    <div class="header-top-right">
                        <span>Phone: {{ $settings->company_phone ?? "" }}</span>
                        <span>Email: {{ $settings->company_email ?? "" }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-logo-menu sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset($settings->company_logo) }}" alt="Logo"
                                style="height:70px; width:auto; object-fit:contain;">

                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-12">
                    <div class="mainmenu-area pull-right">
                        <div class="mainmenu d-none d-lg-block">
                            <nav>
                                <ul id="nav">
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
        class="login-btn"
        data-bs-toggle="modal"
        data-bs-target="#loginModal">
    Login
</button>
                                        @endif

                                    </li>
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