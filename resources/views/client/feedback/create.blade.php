@extends('client.layout.app')

@section('style')
<style>
    .page-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .feedback-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 30px;
        max-width: 600px;
        margin: 0 auto;
    }
    .rating-wrap {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    .rating-wrap input[type="radio"] {
        display: none;
    }
    .rating-wrap label {
        font-size: 30px;
        color: #ccc;
        cursor: pointer;
        transition: 0.2s;
    }
    .rating-wrap label:hover,
    .rating-wrap label:hover ~ label,
    .rating-wrap input[type="radio"]:checked ~ label {
        color: #fbbf24;
    }

    /* To make stars fill left-to-right on hover correctly, we reverse flex direction */
    .rating-container {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
</style>
@endsection

@section('content')
<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Submit Feedback</h1>
        <a href="{{ route('dashboard.index') }}" class="btn btn-outline-primary">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="feedback-card">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('feedbacks.store') }}" method="POST">
            @csrf

            <div class="form-group mb-4">
                <label class="form-label fw-bold">Rate your experience</label>
                <div class="rating-wrap rating-container">
                    <input type="radio" name="rating" id="star5" value="5">
                    <label for="star5"><i class="fa fa-star"></i></label>

                    <input type="radio" name="rating" id="star4" value="4">
                    <label for="star4"><i class="fa fa-star"></i></label>

                    <input type="radio" name="rating" id="star3" value="3">
                    <label for="star3"><i class="fa fa-star"></i></label>

                    <input type="radio" name="rating" id="star2" value="2">
                    <label for="star2"><i class="fa fa-star"></i></label>

                    <input type="radio" name="rating" id="star1" value="1" required>
                    <label for="star1"><i class="fa fa-star"></i></label>
                </div>
                @error('rating')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="message" class="form-label fw-bold">Your Feedback</label>
                <textarea name="message" id="message" rows="5" class="form-control" placeholder="Tell us what you think..." required>{{ old('message') }}</textarea>
                @error('message')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                Submit Feedback
            </button>
        </form>
    </div>
</div>
@endsection
