@extends('client.layout.app')

@section('style')
<style>
.form-fild{
    position: relative;
}

.form-fild .fa-eye{
    position: absolute;
    right: 15px;
    top: 62%;
    cursor: pointer;
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
                                    <h1 class="text-center">Login</h1>
                                    <div class="breadcrumb-bar">
                                        <ul class="breadcrumb text-center">
                                            <li><a href="{{ route('home') }}">Home</a></li>
                                            <li>Login</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <!--Login Register Area Strat-->
    <div class="login-register-area pt-100 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <!--Login Form Start-->
                <div class="col-md-6 col-sm-6">
                    <div class="customer-login-register">
                        <div class="form-login-title">
                            <h2>Login</h2>
                        </div>
                        <div class="login-form">
                            {{-- SHOW ERROR --}}
                            @if(session('error'))
                                <div style="color:red; margin-bottom:10px;">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ url('/login') }}" method="POST">
                                @csrf
                                <input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">
                                <!-- EMAIL -->
                                <div class="form-fild">
                                    <p>
                                        <label>Email Address <span class="required">*</span></label>
                                    </p>
                                    <input name="email" type="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span style="color:red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- PASSWORD -->
<div class="form-fild">
    <p>
        <label>Password <span class="required">*</span></label>
    </p>

    <input name="password" type="password" id="password" required>

    <i onclick="togglePassword()" class="fa fa-eye"></i>

    @error('password')
        <span style="color:red;">{{ $message }}</span>
    @enderror
</div>
                                <div class="login-submit">
                                    <button type="submit" class="button-default">Login</button>
                                    <label>
                                        <input class="checkbox" name="rememberme" value="" type="checkbox">
                                        {{-- <span>Remember me</span> --}}
                                    </label>
                                </div>
                                <!-- Links Section -->
                                <div class="login-links"
                                    style="margin-top: 15px; display: flex; justify-content: space-between;">

                                    <a href="#" style="color: #d9534f; font-size: 14px;">
                                        Forgot Password?
                                    </a>

                                    {{-- <a href="{{ route('register') }}" style="color: #0275d8; font-size: 14px;">
                                        New here? Register
                                    </a> --}}

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Login Form End-->

            </div>
        </div>
    </div>
    <!--Login Register Area End-->

@endsection

@section('script')

<script>
function togglePassword() {
    const password = document.getElementById('password');

    if (password.type === 'password') {
        password.type = 'text';
    } else {
        password.type = 'password';
    }
}

window.onload = function () {
    if (!navigator.geolocation) return;

    navigator.geolocation.getCurrentPosition(function (position) {
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
    });
};
</script>
@endsection