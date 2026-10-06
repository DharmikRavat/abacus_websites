@extends('client.layout.app')

@section('style')
<style>
    .single-slider {
        position: relative;
    }

    .register-class-btn {
        position: absolute;
        top: 25px;
        right: 30px;
        z-index: 10;

        background: #ffffff;
        color: #1652f0;
        border: none;
        border-radius: 6px;

        padding: 12px 22px;
        font-size: 15px;
        font-weight: 600;

        cursor: pointer;

        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);

        transition: all 0.3s ease;
    }

    .register-class-btn:hover {
        background: #1652f0;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .register-option {
        display: flex;
        align-items: center;
        justify-content: space-between;

        text-decoration: none;

        padding: 18px 20px;

        border: 1px solid #e5e7eb;
        border-radius: 10px;

        color: #222;
        background: #fff;

        transition: all 0.3s ease;
    }

    .register-option:hover {
        border-color: #1652f0;
        background: #f5f8ff;
        color: #1652f0;
    }

    .register-option h5 {
        margin: 0 0 4px;
        font-size: 17px;
        font-weight: 600;
    }

    .register-option p {
        margin: 0;
        font-size: 13px;
        color: #777;
    }

    .register-option span {
        font-size: 24px;
        font-weight: 500;
    }

    @media (max-width: 576px) {
        .register-class-btn {
            top: 15px;
            right: 15px;
            padding: 9px 14px;
            font-size: 13px;
        }
    }
</style>
    <style>
.testimonial-image {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f1f1;
    overflow: hidden;
}

.testimonial-image svg {
    width: 70px;
    height: 70px;
    color: #777;
}
.about-description {
    line-height: 1.6;
    max-height: calc(1.6em * 20);
    overflow: hidden;
}
.section {
    padding: 50px 0;
    text-align: center;
    background: #fff;
    overflow: hidden;
}

.section h2 {
    font-size: 34px;
    font-weight: 600;
    margin-bottom: 50px;
    color: #222;
}

/* SCROLL AREA */
.scroll-wrapper {
    width: 100%;
    overflow: hidden;
}

/* TRACK */
.flags-container {
    display: flex;
    gap: 80px; /* more spacing like image */
    width: max-content;
    animation: scrollLeft 10s linear infinite;
    align-items: center;
}

/* CARD STYLE */
.flag-card {
    min-width: 200px;
    /*background: #fff;*/
    padding: 10px 25px;
    border-radius: 14px;
    text-align: center;
    /*box-shadow: 0 8px 20px rgba(0,0,0,0.08);*/
    transition: 0.3s;
}

/* FLAG IMAGE */
.flag-card img {
    width: 100%;
    height: 110px;
    object-fit: cover;
    border-radius: 8px;
}

/* COUNTRY NAME */
.flag-card h4 {
    margin-top: 15px;
    font-size: 18px;
    font-weight: 500;
    color: #222;
}

/* HOVER EFFECT */
.flag-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

/* RIGHT ➝ LEFT */
@keyframes scrollLeft {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-30%);
    }
}

/* PAUSE ON HOVER */
.scroll-wrapper:hover .flags-container {
    animation-play-state: paused;
}
.slider-section {
    position: relative;
}

.register-gif {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 9999;
    display: block;
    line-height: 0;
}

.register-gif img {
    width: 120px;
    height: 120px;
    display: block;
    cursor: pointer;
}

@media (max-width: 576px) {
    .register-gif {
        top: 15px;
        right: 15px;
    }

    .register-gif img {
        width: 130px;
    }
}

    </style>

@endsection
@section('content')

<!-- Slider Area Start -->
<div class="slider-area">
    <div class="hero-slider owl-carousel">

        @foreach($sliders as $slider)
            @if($slider->is_active == 1)

                <div class="single-slider position-relative"
                     style="background-image: url('{{ asset('uploads/sliders/' . $slider->image) }}')">

                    <!-- Registration GIF -->
                    <a href="javascript:void(0);"
                       class="register-gif"
                       data-bs-toggle="modal"
                       data-bs-target="#registerClassModal">

                        <img src="{{ asset('client/img/indian-abacus-academy-offer.gif') }}"
                             alt="Register for Classes">

                    </a>

                </div>

            @endif
        @endforeach

    </div>
</div>
<!-- Slider Area End -->


<!-- Register Modal -->
<div class="modal fade" id="registerClassModal" tabindex="-1"
     aria-labelledby="registerClassModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="registerClassModalLabel">
                    Register for Classes
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>

            <div class="modal-body">



                <div class="row g-3">

                    <!-- Trial Classes -->
                    <div class="col-12">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSe0a0tQ95QjKLkLctXB29shwSOLbD__x666tqKgbBjLti-iNA/viewform"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="register-option">

                            <div>
                                <h5>Trial Classes</h5>

                            </div>

                            <span>→</span>
                        </a>
                    </div>

                    <!-- Admission -->
                    <div class="col-12">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSftide7sN1hbKSKkNJZWauvf2xGm0qZ6Ix9vtRGDrk_oZvjnw/viewform"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="register-option">

                            <div>
                                <h5>Admission</h5>

                            </div>

                            <span>→</span>
                        </a>
                    </div>

                    <!-- Olympiad -->
                    <div class="col-12">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSfOxx723zZVFXvsaixBvH5W1r3ZHllI6NjnpPoVbZ5IfA_3Qg/closedform"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="register-option">

                            <div>
                                <h5>Olympiad</h5>

                            </div>

                            <span>→</span>
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>




    <!--Course Area Start-->
    <div class="course-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title-wrapper">
                        <div class="section-title">
                            <h3>POPULAR COURSES</h3>
                            <p>There are many variations of passages of Lorem Ipsum</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($academyPrograms->take(4) as $program)

                <div class="col-lg-3 col-md-6 col-12">

                        @if(!empty($program->link))
                            <a href="{{ $program->link }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               style="text-decoration: none; color: inherit;">
                        @endif

                            <div class="single-item mb-50 mt-50">

                                <!-- IMAGE -->
                                <div class="single-item-image overlay-effect">
                                    <img src="{{ $program->image
                                        ? asset($program->image)
                                        : asset('client/img/course/1.jpg') }}"
                                        alt="{{ $program->name }}"
                                        style="height: 80px; width: auto; margin-top: 20px;">
                                </div>

                                <!-- CONTENT -->
                                <div class="single-item-text">

                                    <h4>
                                        {{ $program->name }}
                                    </h4>

                                    <p>
                                        {{ $program->description }}
                                    </p>

                                    <!-- DURATION -->
                                    <div class="single-item-content">
                                        <div class="single-item-comment-view">
                                            <strong>
                                                {{ $program->duration }}
                                            </strong>
                                        </div>
                                    </div>

                                    <!-- PROGRAM IMAGES -->
                                    @if(!empty($program->program_images))
                                        <div class="mb-3">
                                            <div class="program-images mt-3">

                                                @foreach($program->program_images as $image)
                                                    <img src="{{ asset($image) }}"
                                                         alt="{{ $program->name }}"
                                                         class="img-fluid"
                                                         style="
                                                            width: 80px;
                                                            height: 60px;
                                                            object-fit: cover;
                                                            border-radius: 6px;
                                                            margin-right: 6px;
                                                         ">
                                                @endforeach

                                            </div>
                                        </div>
                                    @endif

                                </div>

                            </div>

                        @if(!empty($program->link))
                            </a>
                        @endif

                    </div>

                @endforeach
            </div>
            <a class="button-default" href="{{ route('programs') }}" style="border-radius:50px">Learn More</a>
        </div>
    </div>
    <!--End of Course Area-->
    <!--Fun Factor Area Start-->
<div class="fun-factor-area">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-fun-factor mb-30">
                    <h2>
                        <span class="counter">{{ $statistics->teachers_count ?? 0 }}</span>+
                    </h2>
                    <h4>Teachers</h4>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-fun-factor mb-30">
                    <h2>
                        <span class="counter">{{ $statistics->members_count ?? 0 }}</span>+
                    </h2>
                    <h4>Students</h4>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-fun-factor mb-30">
                    <h2>
                        <span class="counter">{{ $statistics->course_count ?? 0 }}</span>+
                    </h2>
                    <h4>Courses</h4>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-fun-factor mb-30">
                    <h2>
                        <span class="counter">{{ $statistics->countries_count ?? 0 }}</span>+
                    </h2>
                    <h4>Countries</h4>
                </div>
            </div>

        </div>
    </div>
</div>
    <!--End of Fun Factor Area-->
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
                        <div class="about-description">
                            {!! $about->description_one !!}
                        </div>
                        <a class="button-default" href="{{ route('home') }}">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <!--About Image Area Start-->
                    <div class="about-image-area img-full">
                        <img src="{{ asset('client/img/about/about1.jpg') }}" alt="">
                    </div>
                    <!--About Image Area End-->
                </div>
            </div>
        </div>
    </div>
    <!--End of About Area-->

<!-- Global Presence -->
<section class="section">
    <h2>Our Global Presence</h2>

    <div class="scroll-wrapper">
        <div class="flags-container">

            {{-- Original --}}
            @foreach($globalPresences as $country)

                <div class="flag-card">
                    <img
                    src="{{ asset('uploads/global-presence/' . $country->country_flag_image) }}"
                    alt="{{ $country->country_name }}"
                >


                    <!--<h4>{{ $country->country_name }}</h4>-->
                </div>

            @endforeach


        </div>
    </div>
</section>

    <!--End of Online Product Area-->
<div class="testimonial-area">
    <div class="container">
        <div class="row">
            <div class="testimonial-slider owl-carousel">

                @foreach($feedbacks as $feedback)
                    <div class="col-12">
                        <div class="single-testimonial-area">

<div class="testimonial-image">
    <svg xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 24 24"
         width="60"
         height="60"
         fill="currentColor"
         aria-label="User">
        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
    </svg>
</div>

                            <div class="testimonial-content">

                                <!-- Rating -->
                                <div class="testimonial-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $feedback->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>

                                <!-- Feedback -->
                                <p class="author-desc">
                                    {{ $feedback->message }}
                                </p>

                                <!-- User -->
                                <p class="testimonial-author">
                                    {{ $feedback->user->name ?? 'Anonymous User' }}
                                </p>

                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

    <!--Testimonial Area End-->
    <!--Event Area Start-->
    <div class="event-area section-padding bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title-wrapper">
                        <div class="section-title">
                            <h3>OUR GALLERY</h3>
                            <p>There are many events</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--Gallery Area Start-->
            <div class="gallery-area">
                <div class="container">
                    <div class="row">

                        @foreach($dashboardImages as $image)
                            <div class="col-md-3 col-sm-6">
                                <div class="single-gallery-img mb-30">
                                    <a href="{{ asset('uploads/gallery/' . $image->media) }}" data-fancybox="images">
                                        <img src="{{ asset('uploads/gallery/' . $image->media) }}" alt="Gallery Image">
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <!--Gallery Area End-->
        </div>
    </div>
    <!-- FAQ Section Start -->
<div class="testimonial-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <div class="section-title">
                    <h3>Frequently Asked Questions</h3>
                    <p>Find answers to common questions about our services.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="accordion" id="faqAccordion">

                    @forelse($faqs as $faq)
                        <div class="accordion-item mb-3 border">
                            <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                <button
                                    class="accordion-button {{ !$loop->first ? 'collapsed' : '' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $faq->id }}"
                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $faq->id }}">

                                    {{ $faq->question }}
                                </button>
                            </h2>

                            <div id="collapse{{ $faq->id }}"
                                 class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                 aria-labelledby="heading{{ $faq->id }}"
                                 data-bs-parent="#faqAccordion">

                                <div class="accordion-body">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">
                            <p>No FAQs available.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
<!-- FAQ Section End -->
@endsection

@section('script')
    <script>
        window.addEventListener("load", function () {

            const slides = document.querySelectorAll(".single-slider");

            if (slides.length === 0) {
                console.log("No slides found");
                return;
            }

            let current = 0;

            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove("active"));
                slides[index].classList.add("active");
            }

            function nextSlide() {
                current = (current + 1) % slides.length;
                showSlide(current);
            }

            // INIT
            showSlide(current);

            // AUTO SLIDE (3 seconds)
            setInterval(nextSlide, 3000);

        });
    </script>
@endsection