@extends('client.layout.app')

@section('style')

<style>

.policy-area {
    padding: 70px 0;
}

.policy-card {
    background: #fff;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .10);
}

.policy-icon {
    font-size: 38px;
    color: #1F3971;
    margin-bottom: 15px;
}

.policy-title {
    color: #1F3971;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 25px;
}

.policy-content {
    color: #666;
    font-size: 16px;
    line-height: 1.9;
}

.policy-content p {
    margin-bottom: 15px;
}

.no-policy {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,.08);
}

.no-policy i {
    font-size: 50px;
    color: #1F3971;
    margin-bottom: 15px;
}

.no-policy h4 {
    color: #1F3971;
    font-weight: 600;
}

.no-policy p {
    color: #777;
}

@media(max-width: 767px) {

    .policy-card {
        padding: 25px 20px;
    }

    .policy-title {
        font-size: 23px;
    }

    .policy-content {
        font-size: 15px;
    }

}

</style>

@endsection


@section('content')

<!-- Breadcrumb Banner Area Start -->

<div class="breadcrumb-banner-area">

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="breadcrumb-text">

                    <h1 class="text-center">
                        PRIVACY POLICY
                    </h1>

                    <div class="breadcrumb-bar">

                        <ul class="breadcrumb text-center">

                            <li>
                                <a href="{{ route('home') }}">
                                    Home
                                </a>
                            </li>

                            <li>
                                PRIVACY POLICY
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Breadcrumb Banner Area End -->


<!-- Privacy Policy Area Start -->

<div class="policy-area">

    <div class="container">

        @if($privacyPolicy)

            <div class="policy-card">

                <div class="policy-icon">
                    <i class="fa fa-shield"></i>
                </div>

                <h2 class="policy-title">
                    {{ $privacyPolicy->title }}
                </h2>

                <div class="policy-content">

                    {!! $privacyPolicy->description !!}

                </div>

            </div>

        @else

            <div class="no-policy">

                <i class="fa fa-shield"></i>

                <h4>
                    Privacy Policy Not Available
                </h4>

                <p>
                    There is currently no active privacy policy available.
                </p>

            </div>

        @endif

    </div>

</div>

<!-- Privacy Policy Area End -->

@endsection


@section('script')

<script>

</script>

@endsection