
@extends('client.layout.app')

@section('style')
    <style>

    </style>

@endsection
@section('content')


    <!--Breadcrumb Banner Area Start-->
    <div class="breadcrumb-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h1 class="text-center">Franchise</h1>
                        <div class="breadcrumb-bar">
                            <ul class="breadcrumb text-center">
                                <li><a href="index.html">Home</a></li>
                                <li>Franchise</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
    <!--Franchise Area Start-->
    <!--Franchise Area Start-->
    
<div class="franchise-area section-padding bg-light">
    <div class="container">

        <!-- Top Section -->
        <div class="row mb-5">

            <div class="col-lg-12 text-center">
                <h2 class="mb-4">
                    {{ $franchise->title ?? 'Training & Franchise' }}
                </h2>
            </div>

            <div class="col-lg-12">
                {!! $franchise->training_description ?? '' !!}
            </div>

        </div>

        <!-- Advantages -->
        <div class="row align-items-start">

            <div class="col-lg-8">

                <h2 class="mb-4">
                    {{ $franchise->advantages_title ?? '' }}
                </h2>

                {!! $franchise->advantages_description ?? '' !!}

            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">

                @if(!empty($franchise?->advantages_image))
                    <div class="franchise-image">
                        <img src="{{ asset($franchise->advantages_image) }}"
                             class="img-fluid rounded shadow"
                             alt="Franchise">
                    </div>
                @endif

            </div>

        </div>

        <!-- Why Join Us -->
        <div class="row mt-5">

            <div class="col-lg-12">

                <div class="why-join-box text-center">
                    <h2 class="mb-4 text-danger">
                        {{ $franchise->why_join_title ?? '' }}
                    </h2>
                </div>

                {!! $franchise->why_join_description ?? '' !!}

            </div>

        </div>

    </div>
</div>
<!--Franchise Area End-->

@endsection

@section('script')

@endsection