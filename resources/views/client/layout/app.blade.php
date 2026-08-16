<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $settings->company_name ?? "In" }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    <!-- favicon
============================================ -->
<link rel="shortcut icon"
      type="image/x-icon"
      href="{{ !empty($settings->company_logo) ? asset('storage/' . $settings->company_logo) : asset('client/img/favicon.ico') }}">

    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}">

    <!-- Fontawsome CSS
		============================================ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Metarial Iconic Font CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('client/css/material-design-iconic-font.min.css')}}">

    <!-- Plugin CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('client/css/plugin.css') }}">

    <!-- Style CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('client/style.css') }}">

    <!-- Responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('client/css/responsive.css') }}">
    @yield('style')

    <style>
    .floating-whatsapp {
    position: fixed;
    width: 65px;
    height: 65px;
    bottom: 25px;
    right: 25px;
    background: #25D366;
    color: #fff !important;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    text-decoration: none;
    z-index: 99999;
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    transition: all 0.4s ease;
    animation: whatsappPulse 2s infinite;
}

.floating-whatsapp:hover {
    transform: scale(1.12);
    color: #fff !important;
    background: #1ebe5d;
}

@keyframes whatsappPulse {
    0% {
        box-shadow: 0 0 0 0 rgba(37,211,102,0.7);
    }
    70% {
        box-shadow: 0 0 0 18px rgba(37,211,102,0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(37,211,102,0);
    }
}

@media (max-width: 768px) {
    .floating-whatsapp {
        width: 58px;
        height: 58px;
        font-size: 30px;
        right: 20px;
        bottom: 90px;
    }
}
        /* LOGIN BUTTON */
.login-btn{
    background: #1F3971;
    color: #ffffff;
    border: none;
    outline: none;
    display: inline-block;
    font-size: 14px;
    padding: 15px 35px;
    text-transform: uppercase;
    font-family: 'Montserrat', sans-serif;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    border-radius: 30px;
    margin-left: 10px;
}

.login-btn:hover{
    background: #FFAE27;
    color: #ffffff;
}
        /* MODAL BUTTONS */
        .login-type-btn {
            display: block;
            width: 100%;
            padding: 14px;
            margin-bottom: 15px;
            border-radius: 6px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .teacher-btn {
            background: #28a745;
        }

        .student-btn {
            background: #007bff;
        }

        .admin-btn {
            background: #dc3545;
        }

        .login-type-btn:hover {
            color: #fff;
            opacity: 0.9;
        }
    </style>

</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!--Loading Area Start-->
    <div class="loading">
        <div class="text-center middle">
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!--Loading Area End-->
    <!--Main Wrapper Start-->
    <div class="as-mainwrapper">
        <!--Bg White Start-->
        <div class="bg-white">
            <!--Header Area Start-->
            @include('client.layout.header')
            <!--End of Header Area-->
            @yield('content')
            <!--End of Event Area-->
            @include('client.layout.footer')
        </div>
        <!--End of Bg White-->
    </div>
    <!--End of Main Wrapper Area-->



    <!-- jquery
		============================================ -->
    <script src="{{ asset('client/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('client/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('client/js/vendor/jquery-migrate-3.3.2.min.js') }}"></script>

    <!-- popper JS
		============================================ -->
    <script src="{{ asset('client/js/popper.min.js') }}"></script>

    <!-- bootstrap JS
		============================================ -->
    <script src="{{ asset('client/js/bootstrap.min.js') }}"></script>

    <!-- AJax Mail JS
		============================================ -->
    <script src="{{ asset('client/js/ajax-mail.js') }}"></script>

    <!-- plugins JS
		============================================ -->
    <script src="{{ asset('client/js/plugins.js') }}"></script>

    <!-- main JS
		============================================ -->
    <script src="{{ asset('client/js/main.js') }}"></script>

    {{-- Login Modal --}}
    <!-- LOGIN MODAL -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">
                        Select Login Type
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <!-- BODY -->
                <div class="modal-body text-center">

                    <a href="{{ url('/teacher/login') }}" class="login-type-btn teacher-btn"
                        onclick="closeLoginModal()">
                        Teacher Login
                    </a>

                    <a href="{{ url('/student-login') }}" class="login-type-btn student-btn"
                        onclick="closeLoginModal()">
                        Student Login
                    </a>

                    <a href="{{ url('/admin/login') }}" class="login-type-btn admin-btn" onclick="closeLoginModal()">
                        Admin Login
                    </a>

                </div>

            </div>
        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const modalElement = document.getElementById('loginModal');

            if (modalElement) {

                // Remove modal open class
                document.body.classList.remove('modal-open');

                // Remove backdrop
                document.querySelectorAll('.modal-backdrop').forEach(el => {
                    el.remove();
                });

                // Hide modal if already open
                const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                modalInstance.hide();
            }
        });
    </script>
    <script>
        function closeLoginModal() {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('loginModal')
            );

            if (modal) {
                modal.hide();
            }
        }
    </script>
    @yield('script')
    @php
    $whatsappMessage = urlencode('Hello India Abacus Academy, I would like to enquire about a demo class. Please share the details and available timings.');
    $whatsappNumber = preg_replace('/[^0-9]/', '', $settings->company_mobile ?? '');
@endphp

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappMessage }}"
   class="floating-whatsapp"
   target="_blank">

    <i class="fab fa-whatsapp"></i>

</a>
</body>

</html>