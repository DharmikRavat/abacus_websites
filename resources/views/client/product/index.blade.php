@extends('client.layout.app')

@section('style')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --secondary-color: #10b981;
        --text-main: #1f2937;
        --text-muted: #6b7280;
        --bg-light: #f3f4f6;
    }

    body {
        background-color: #f8fafc;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #312e81 100%);
        padding: 40px 0;
        border-radius: 16px;
        margin-bottom: 40px;
        color: white;
        box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.3);
        position: relative;
        overflow: hidden;
    }

    .page-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin-top: 8px;
        font-weight: 400;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    .product-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 0;
        text-align: left;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(229, 231, 235, 0.5);
        position: relative;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    }

    .product-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background-color: #ef4444;
        color: white;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 20px;
        z-index: 10;
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);
    }

    .product-image-container {
        width: 100%;
        height: 240px;
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 25px;
        border-bottom: 1px solid #f3f4f6;
        position: relative;
    }

    .product-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-content {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        background-color: #fff;
    }

    .product-brand {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 8px;
    }

    .product-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--text-main);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-desc {
        font-size: 14px;
        color: var(--text-muted);
        flex-grow: 1;
        margin-bottom: 20px;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .price-wrapper {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        margin-bottom: 20px;
    }

    .product-price {
        font-size: 26px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1;
    }

    .original-price {
        font-size: 16px;
        color: #9ca3af;
        text-decoration: line-through;
        font-weight: 500;
        margin-bottom: 3px;
    }

    .product-actions {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }

    .btn-view {
        flex: 1;
        background-color: #f3f4f6;
        color: #374151;
        border: none;
        padding: 12px 0;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        text-align: center;
        text-decoration: none;
    }

    .btn-view:hover {
        background-color: #e5e7eb;
        color: #111827;
        text-decoration: none;
    }

    .btn-cart {
        flex: 1;
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 12px 0;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-cart:hover {
        background-color: var(--primary-hover);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        color: var(--text-muted);
        grid-column: 1 / -1;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background-color: #f3f4f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
        color: #9ca3af;
    }
</style>
@endsection

@section('content')
<div class="container mt-4 mb-5">

    <!-- Page Header -->
    <div class="page-header px-4 px-md-5 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Discover Our Products</h1>
            <p class="page-subtitle">Browse through our exclusive collection of high-quality items.</p>
        </div>
        <a href="{{ route('dashboard.index') }}" class="btn btn-light shadow-sm d-none d-md-flex align-items-center gap-2" style="border-radius: 12px; font-weight: 600; padding: 10px 20px;">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- Mobile Back Button -->
    <div class="d-md-none mb-4">
        <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary w-100" style="border-radius: 12px; font-weight: 600;">
            <i class="fa fa-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>

    <!-- Product Grid -->
    <div class="product-grid">
        @forelse($products as $product)
        <div class="product-card">
            @if($product->discount_on_item > 0)
                <div class="product-badge">
                    {{ number_format($product->discount_on_item, 0) }}% OFF
                </div>
            @endif

            <div class="product-image-container">
                @if($product->item_image)
                    <img src="{{ asset($product->item_image) }}" alt="{{ $product->item_name }}" class="product-image">
                @else
                    <img src="https://via.placeholder.com/400x400?text=No+Image" alt="No Image" class="product-image">
                @endif
            </div>

            <div class="product-content">
                @if($product->item_brand)
                    <div class="product-brand">{{ $product->item_brand }}</div>
                @endif

                <h3 class="product-title">{{ $product->item_name }}</h3>
                <p class="product-desc">{{ $product->item_description }}</p>

                <div class="price-wrapper">
                    <div class="product-price">₹{{ number_format($product->item_price, 2) }}</div>
                    @if($product->discount_on_item > 0)
                        @php
                            $originalPrice = $product->item_price / (1 - ($product->discount_on_item / 100));
                        @endphp
                        <div class="original-price">₹{{ number_format($originalPrice, 2) }}</div>
                    @endif
                </div>

                <div class="product-actions">
                    <a href="#" class="btn-view">View Details</a>
                    <a href="#" class="btn-cart">
                        <i class="fa fa-shopping-cart"></i> Add to Cart
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa fa-box-open"></i>
            </div>
            <h3 class="mt-3 font-weight-bold text-dark">No Products Found</h3>
            <p class="text-muted mb-4">We couldn't find any products at the moment. Please check back later.</p>
            <a href="{{ route('dashboard.index') }}" class="btn btn-primary" style="border-radius: 10px; padding: 10px 24px; font-weight: 600;">Return Home</a>
        </div>
        @endforelse
    </div>
</div>
@endsection
