@extends('client.layout.app')

@section('style')

<style>
.feedback-card {
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .10);
    transition: .3s;
    height: 100%;
}

.feedback-card:hover {
    transform: translateY(-5px);
}

.feedback-icon {
    font-size: 38px;
    color: #1F3971;
    margin-bottom: 12px;
}

.feedback-rating {
    margin-bottom: 15px;
}

.feedback-rating i {
    color: #f5b301;
    font-size: 17px;
    margin-right: 3px;
}

.feedback-text {
    color: #666;
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 25px;
    min-height: 90px;
}

.feedback-user {
    display: flex;
    align-items: center;
    border-top: 1px solid #eee;
    padding-top: 20px;
}

.feedback-image-placeholder {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: #1F3971;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-right: 15px;
}

.feedback-name {
    font-size: 17px;
    font-weight: 700;
    color: #1F3971;
    margin-bottom: 3px;
}

.feedback-designation {
    color: #888;
    font-size: 13px;
}

.no-feedback {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,.08);
}

.no-feedback i {
    font-size: 50px;
    color: #1F3971;
    margin-bottom: 15px;
}

.no-feedback h4 {
    color: #1F3971;
    font-weight: 600;
}

.no-feedback p {
    color: #777;
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

                <h1 class="text-center">FEEDBACK</h1>

                <div class="breadcrumb-bar">
                    <ul class="breadcrumb text-center">
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>FEEDBACK</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>


</div>
<!-- Breadcrumb Banner Area End -->

<!-- Feedback Area Start -->

<!-- Feedback Area Start -->

<div class="feedback-area mt-70 pb-70">


    <div class="container">

        <div class="text-center mb-5">

            <h2>What Our Students Say</h2>

            <p>
                Read what our students have to say about their learning experience.
            </p>

        </div>

        @if($feedbacks->count() > 0)

            <div class="row">

                @foreach($feedbacks as $feedback)

                    <div class="col-md-6 col-lg-4 mb-4">

                        <div class="feedback-card">

                            <!-- Quote -->
                            <div class="feedback-icon">
                                <i class="fa fa-quote-left"></i>
                            </div>


                            <!-- Rating -->
                            <div class="feedback-rating">

                                @for($i = 1; $i <= 5; $i++)

                                    @if($i <= $feedback->rating)

                                        <i class="fa fa-star"></i>

                                    @else

                                        <i class="fa fa-star-o"></i>

                                    @endif

                                @endfor

                            </div>


                            <!-- Message -->
                            <div class="feedback-text">

                                {{ $feedback->message }}

                            </div>


                            <!-- User -->
                            <div class="feedback-user">

                                <div class="feedback-image-placeholder">

                                    <i class="fa fa-user"></i>

                                </div>


                                <div>

                                    <div class="feedback-name">

                                        {{ $feedback->user->name ?? 'Student' }}

                                    </div>

                                    <div class="feedback-designation">

                                        {{ \Carbon\Carbon::parse($feedback->date)->format('d M Y') }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="row">

                <div class="col-md-12">

                    <div class="no-feedback">

                        <i class="fa fa-comments"></i>

                        <h4>No Feedback Available</h4>

                        <p>
                            There are currently no feedbacks available.
                        </p>

                    </div>

                </div>

            </div>

        @endif

    </div>

    </div>
    <!-- Feedback Area End -->

<!-- Feedback Area End -->

@endsection

@section('script')

<script>

    // Feedback page scripts can be added here if required.

</script>

@endsection
