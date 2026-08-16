@extends('client.layout.app')

@section('style')
    <style>

    </style>

@endsection
@section('content')

    <!--Slider Area Start-->
    <div class="slider-area">
        <div class="hero-slider owl-carousel">

            @foreach($sliders as $slider)
                @if($slider->is_active  == 1)
                    <div class="single-slider" style="background-image: url('{{ asset('uploads/sliders/' . $slider->image) }}')">

                    </div>
                @endif
            @endforeach

        </div>
    </div>
    <!--Slider Area End-->

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
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-item">
                        <div class="single-item-image overlay-effect">
                            <a href="courses-details.html">
                                <img src="{{ asset('client/img/course/course1.jpg') }}" alt=""
                                 style="height: 200px; object-fit: cover;"
                                >
                            </a>

              
                        </div>

                        <div class="single-item-text">
                            <h4><a href="courses-details.html">Abacus</a></h4>

                            <p>
                                Abacus is first calculating devices used for develop mental math calculations.
                                Initially a flat surface with sand spread across it was used for fast counting number.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-item">
                        <div class="single-item-image overlay-effect">
                            <a href="courses-details.html">
                                <img src="{{ asset('client/img/course/course2.png') }}" alt=""
                                 style="height: 200px; object-fit: cover;"
                                >
                            </a>
                        </div>

                        <div class="single-item-text">
                            <h4><a href="courses-details.html">Vedic Maths</a></h4>

                            <p>
                                Vedic Mathematics is a collection of techniques and sutras to solve
                                mathematical arithmetic in an easy and faster way.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-item">
                        <div class="single-item-image overlay-effect">
                            <a href="courses-details.html">
                                <img src="{{ asset('client/img/course/course3.png') }}" alt=""
                                 style="height: 200px; object-fit: cover;"
                                >
                            </a>
                        </div>

                        <div class="single-item-text">
                            <h4><a href="courses-details.html">Midbrain Activation</a></h4>

                            <p>
                                An advanced program that boosts your child’s finding potential and
                                unleashes hidden creativity and confidence.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-item">
                        <div class="single-item-image overlay-effect">
                            <a href="courses-details.html">
                                <img src="{{ asset('client/img/course/course4.webp') }}" alt=""
                                 style="height: 200px; object-fit: cover;"
                                >
                            </a>

                        </div>

                        <div class="single-item-text">
                            <h4><a href="courses-details.html">Rubik’s Cube</a></h4>

                            <p>
                                Rubik’s Cube is a 3-D combination puzzle that improves concentration,
                                memory, and logical problem-solving skills in children.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--End of Course Area-->
    <!--Fun Factor Area Start-->
    <div class="fun-factor-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-fun-factor mb-30">
                        <h2><span class="counter">79</span>+</h2>
                        <h4>Teachers</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-fun-factor mb-30">
                        <h2><span class="counter">120</span>+</h2>
                        <h4>Members</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-fun-factor mb-30">
                        <h2><span class="counter">36</span>+</h2>
                        <h4>Courses</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-fun-factor mb-30">
                        <h2><span class="counter">20</span>+</h2>
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
                        <p>Do you know ? Our left hand connected by right brain and right hand connected by left brain.
                            Brain has left and right hemi-spheres. The left brain is the conventional brain and right brain
                            is the base of intelligence. </p>
                        <p>About 90% of us use only the left brain. But with Indian Abacus
                            Academy program children are trained to use their right brain more, resulting in increased
                            performance in all their activities.</p>
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


    <!--End of Online Product Area-->
    <div class="testimonial-area">
        <div class="container">
            <div class="row">
                <div class="testimonial-slider owl-carousel">
                    <div class="col-12">
                        <!--Single Testimonial Area Start-->
                        <div class="single-testimonial-area">
                            <div class="testimonial-image">
                                <img src="{{ asset('client/img/testimonial/testimonial1.png') }}" alt="">
                            </div>
                            <div class="testimonial-content">
                                <p class="author-desc"> All Perfect !! I have three sites with magento , this
                                    theme is the best !! Excellent support , advice theme installation package ,
                                    sorry for English, are Italian but I had no problem !! Thank you ! ..</p>
                                <p class="testimonial-author">Alva Ono</p>
                            </div>
                        </div>
                        <!--Single Testimonial Area End-->
                    </div>
                    <div class="col-12">
                        <!--Single Testimonial Area Start-->
                        <div class="single-testimonial-area">
                            <div class="testimonial-image">
                                <img src="{{ asset('client/img/testimonial/testimonial2.png') }}" alt="">
                            </div>
                            <div class="testimonial-content">
                                <p class="author-desc">Perfect Themes and the best of all that you have many
                                    options to choose! Best Support team ever!Very fast responding and experts
                                    on their fields! Thank you very much! ..</p>
                                <p class="testimonial-author">Amber Laha</p>
                            </div>
                        </div>
                        <!--Single Testimonial Area End-->
                    </div>
                    <div class="col-12">
                        <!--Single Testimonial Area Start-->
                        <div class="single-testimonial-area">
                            <div class="testimonial-image">
                                <img src="{{ asset('client/img/testimonial/testimonial3.png') }}" alt="">
                            </div>
                            <div class="testimonial-content">
                                <p class="author-desc"> Code, template and others are very good. The support has
                                    served me immediately and solved my problems when I need help. Are to be
                                    congratulated. Att Renan Andrade ..</p>
                                <p class="testimonial-author">Dewey Tetzlaff</p>
                            </div>
                        </div>
                        <!--Single Testimonial Area End-->
                    </div>
                    <div class="col-12">
                        <!--Single Testimonial Area Start-->
                        <div class="single-testimonial-area">
                            <div class="testimonial-image">
                                <img src="{{ asset('client/img/testimonial/testimonial4.png') }}" alt="">
                            </div>
                            <div class="testimonial-content">
                                <p class="author-desc"> All Perfect !! I have three sites with magento , this
                                    theme is the best !! Excellent support , advice theme installation package ,
                                    sorry for English, are Italian but I had no problem !! Thank you ! ..</p>
                                <p class="testimonial-author">Lavina Wilderman</p>
                            </div>
                        </div>
                        <!--Single Testimonial Area End-->
                    </div>
                    <div class="col-12">
                        <!--Single Testimonial Area Start-->
                        <div class="single-testimonial-area">
                            <div class="testimonial-image">
                                <img src="{{ asset('client/img/testimonial/testimonial5.png') }}" alt="">
                            </div>
                            <div class="testimonial-content">
                                <p class="author-desc"> All Perfect !! I have three sites with magento , this
                                    theme is the best !! Excellent support , advice theme installation package ,
                                    sorry for English, are Italian but I had no problem !! Thank you ! ..</p>
                                <p class="testimonial-author">Stefano</p>
                            </div>
                        </div>
                        <!--Single Testimonial Area End-->
                    </div>
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