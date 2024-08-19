@extends('layouts.app')

@section('title', 'Welcome to Our Store')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Discover the Latest Fashion Trends</h1>
        <p class="hero-subtitle">Shop the new collection with amazing discounts</p>
        <a href="{{route("products.sections")}}" class="btn btn-primary hero-btn">Shop Now</a>
    </div>
    <div class="hero-image">
        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDJ8fGZhc2hpb258fDB8fHx8MTY5MTY1MTM5Ng&ixlib=rb-1.2.1&q=80&w=1080" alt="Fashion Collection">
    </div>
</div>

<div class="featured-products">
    <h2 class="section-title">Featured Products</h2>
    <div class="product-grid">
        @foreach($products as $product)
        <div class="product-card">
            <img src="{{asset($product->image) }}" alt="{{ $product->name }}" >
             <h3 class="product-name">{{ $product->name }}</h3>
            <p class="product-price">${{$product->price}}</p>
            <a href="{{ route('product.show', $product->id) }}" class="btn btn-secondary">View Product</a>
        </div>
        @endforeach
    </div>
</div>

<div class="about-us">
    <div class="about-content">
        <h2 class="section-title">About Us</h2>
        <p>We are a leading fashion retailer, offering the latest styles and trends at unbeatable prices. Our mission is to make fashion accessible to everyone. Join us on our journey to redefine fashion.</p>
        <a href="" class="btn btn-primary">Learn More</a>
    </div>
    <div class="about-image">
        <img src="https://t3.ftcdn.net/jpg/01/28/44/76/360_F_128447604_6deYSrg6bgH2F3YaoU0icdhvxNu4ReDN.jpg" alt="About Us">
    </div>
</div>

<div class="testimonials">
    <h2 class="section-title">What Our Customers Say</h2>
    <div class="testimonial-grid">
        @foreach($comments as $comment)
        <div class="testimonial-card">
            <img src='{{asset($comment->user->image) }}' alt="user" class="testimonial-image">
            <p class="testimonial-text">"{{$comment->comment}}"</p>
            <strong class="testimonial-name">{{ $comment->user->name}}</strong>
        </div>
        @endforeach
    </div>
</div>



<style>
    .hero-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f8f9fa;
        padding: 40px;
        border-radius: 10px;
        margin-bottom: 40px;
    }

    .hero-content {
        flex: 1;
        padding-right: 20px;
    }

    .hero-title {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 10px;
    }

    .hero-subtitle {
        font-size: 1.5rem;
        color: #666;
        margin-bottom: 20px;
    }

    .hero-btn {
        font-size: 1.2rem;
        padding: 10px 20px;
    }

    .hero-image {
        flex: 1;
        text-align: center;
    }

    .hero-image img {
        max-width: 100%;
        border-radius: 10px;
    }

    .featured-products {
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 2rem;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .product-grid {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .product-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-card img {
    
        width: 250px;
        height: 250px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .product-name {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 1.5rem;
        color: #007bff;
        margin-bottom: 20px;
    }

    .about-us {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 40px;
        background-color: #f8f9fa;
        padding: 40px;
        border-radius: 10px;
    }

    .about-content {
        flex: 1;
        padding-right: 20px;
    }

    .about-image {
        flex: 1;
        text-align: center;
    }

    .about-image img {
        max-width: 100%;
        border-radius: 10px;
    }

    .testimonials {
        margin-bottom: 40px;
    }

    .testimonial-grid {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .testimonial-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
    }

    .testimonial-image {
        max-width: 80px;
        border-radius: 50%;
        margin-bottom: 15px;
    }

    .testimonial-text {
        font-size: 1rem;
        color: #666;
        margin-bottom: 10px;
    }

    .testimonial-name {
        font-size: 1.1rem;
        color: #333;
    }
</style>
@endsection
