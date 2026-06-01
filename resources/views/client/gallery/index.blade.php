@extends('client.layout.app')

@section('style')
 
{{-- ================= CUSTOM CSS ================= --}}
<style>

.gallery-tabs .nav-link{
    border-radius: 30px;
    padding: 10px 30px;
    margin: 0 8px;
    background: #FFAE27;
    color: #111;
    border: none;
    font-weight: 600;
    transition: 0.3s;
}

.gallery-tabs .nav-link.active{
    background: #1F3971;
    color: #fff;
}

.single-gallery-img{
    overflow: hidden;
    border-radius: 12px;
    position: relative;
}

.single-gallery-img img{
    width: 100%;
    height: 260px;
    object-fit: cover;
    transition: 0.4s;
    border-radius: 12px;
}

.single-gallery-img:hover img{
    transform: scale(1.08);
}

.video-gallery-item{
    border-radius: 12px;
    overflow: hidden;
}

.video-gallery-item iframe{
    width: 100%;
    border: none;
    border-radius: 12px;
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
                        <h1 class="text-center">Gallery</h1>
                        <div class="breadcrumb-bar">
                            <ul class="breadcrumb text-center">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li>Gallery</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
        <!--Gallery Area Start-->
{{-- ================= GALLERY AREA START ================= --}}
<div class="about-area mt-30 pb-70">
    <div class="container">

        {{-- SECTION TITLE --}}
        <div class="row">
            <div class="col-md-12">
                <div class="section-title-wrapper text-center mb-40">
                    <div class="section-title">
                        <h3>Gallery</h3>
                        <p>Explore our images and videos</p>
                    </div>
                </div>
            </div>
        </div>

        @php
            $images = $galleryItems->where('media_type', 1);
            $videos = $galleryItems->where('media_type', 2);
        @endphp

        {{-- TABS --}}
        <div class="row mb-40">
            <div class="col-md-12 text-center">

                <ul class="nav nav-pills gallery-tabs justify-content-center" id="galleryTab" role="tablist">

                    {{-- IMAGES TAB --}}
                    <li class="nav-item">
                        <button class="nav-link active"
                                id="images-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#images"
                                type="button">
                            Images
                        </button>
                    </li>

                    {{-- VIDEOS TAB --}}
                    <li class="nav-item">
                        <button class="nav-link"
                                id="videos-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#videos"
                                type="button">
                            Videos
                        </button>
                    </li>

                </ul>

            </div>
        </div>

        {{-- TAB CONTENT --}}
        <div class="tab-content" id="galleryTabContent">

            {{-- ================= IMAGES ================= --}}
            <div class="tab-pane fade show active"
                 id="images"
                 role="tabpanel">

                <div class="gallery-area">
                    <div class="row">

                        @forelse($images as $image)

                            <div class="col-lg-3 col-md-4 col-sm-6">

                                <div class="single-gallery-img mb-30">

                                    <a href="{{ asset('uploads/gallery/' . $image->media) }}"
                                       data-fancybox="images">

                                        <img src="{{ asset('uploads/gallery/' . $image->media) }}"
                                             alt="{{ $image->title }}"
                                             class="img-fluid">

                                    </a>

                                </div>

                            </div>

                        @empty

                            <div class="col-md-12 text-center">
                                <p>No Images Found</p>
                            </div>

                        @endforelse

                    </div>
                </div>

            </div>

            {{-- ================= VIDEOS ================= --}}
            <div class="tab-pane fade"
                 id="videos"
                 role="tabpanel">

                <div class="gallery-area">
                    <div class="row">

                        @forelse($videos as $video)

                            <div class="col-lg-4 col-md-6">

                                <div class="video-gallery-item mb-30">

                                    <div class="ratio ratio-16x9">

                                        <iframe
                                            src="https://www.youtube.com/embed/{{ $video->youtube_link }}"
                                            title="{{ $video->title }}"
                                            allowfullscreen>
                                        </iframe>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="col-md-12 text-center">
                                <p>No Videos Found</p>
                            </div>

                        @endforelse

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
{{-- ================= GALLERY AREA END ================= --}}

    <!--End of Gallery Area-->

@endsection

@section('script')

@endsection