@extends('layouts.app')

@section('title', $product->name)

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="product-details-container">
    <div class="product-image">
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
    </div>
    <div class="product-info">
        <h1>{{ $product->name }}</h1>
        <p class="price"><span style="color: #666">Price:</span> ${{ $product->price }}</p>
                 <div class="comment-rating">
                    @for ($i = 0; $i < 5; $i++)
                        @if ($i < $rate)
                            <span class="star">&#9733;</span>
                        @else
                            <span class="star">&#9734;</span>
                        @endif
                    @endfor
                </div>
        <p class="description"><span style="color: #666">Description:</span> <br> {{ $product->description }}</p>
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
            @csrf
            <div class="quantity-container">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1">
            </div>
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
    </div>
</div>

<div class="comments-section">
    @auth
    <form action="{{$userComment?route('product.comment.update',$userComment->id):route('product.comment',$product->id)}}" method="POST" class="comment-form">
        @csrf
        <div class="form-group">
            <label for="comment">{{$userComment?' Your Comment ':' Add a Comment'}} </label>
            <textarea id="comment" name="comment" rows="4" required >{{$userComment?$userComment->comment:''}}</textarea>
        </div>
        <div class="form-group">
    <label for="rating">{{$userComment?'Your rate':'Rating'}}</label>
    @if ($userComment)
         <div class="comment-rating">
                    @for ($i = 0; $i < 5; $i++)
                        @if ($i < $userComment->rating)
                            <span class="star">&#9733;</span>
                        @else
                            <span class="star">&#9734;</span>
                        @endif
                    @endfor
                </div>
    @else       

    <div class="rating-stars">
        <input type="radio" id="star5" name="rating" value="5" />
        <label for="star5" title="5 stars">&#9734;</label>
        <input type="radio" id="star4" name="rating" value="4" />
        <label for="star4" title="4 stars">&#9734;</label>
        <input type="radio" id="star3" name="rating" value="3" />
        <label for="star3" title="3 stars">&#9734;</label>
        <input type="radio" id="star2" name="rating" value="2" />
        <label for="star2" title="2 stars">&#9734;</label>
        <input type="radio" id="star1" name="rating" value="1" />
        <label for="star1" title="1 star">&#9734;</label>
    </div>
     @endif
</div>
        <button type="submit" class="btn btn-primary">{{$userComment?'Update':'Submit'}} </button>
    </form>
    @endauth

    <div class="comment-list">
        @foreach($product->comments as $comment)
        <div class="comment-card">
            <div class="comment-header">
                <img src="{{ asset($comment->user->image) }}" alt="{{ $comment->user->name }}" class="comment-user-image">
                <strong>{{ $comment->user->name }}</strong>
                <div class="comment-rating">
                    @for ($i = 0; $i < 5; $i++)
                        @if ($i < $comment->rating)
                            <span class="star">&#9733;</span>
                        @else
                            <span class="star">&#9734;</span>
                        @endif
                    @endfor
                </div>
            </div>
            <p class="comment-text">{{ $comment->comment }}</p>
           
        </div>
        @endforeach
    </div>
</div>

<style>
    .product-details-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .product-image {
        flex: 1;
        min-width: 300px;
        text-align: center;
    }

    .product-image img {
        max-width: 100%;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .product-image img:hover {
        transform: scale(1.05);
    }

    .product-info {
        flex: 2;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .product-info h1 {
        font-size: 2rem;
        margin-bottom: 10px;
        color: #333;
    }

    .product-info .price {
        font-size: 1.5rem;
        color: #007bff;
        margin-bottom: 20px;
    }

    .product-info .description {
        font-size: 1rem;
        color: #666;
        margin-bottom: 20px;
    }

    .add-to-cart-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .quantity-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-container label {
        font-size: 1rem;
        color: #333;
    }

    .quantity-container input {
        width: 60px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        border-radius: 4px;
        text-align: center;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .comments-section {
        margin-top: 40px;
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .comment-form {
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 1rem;
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    .form-group textarea, .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        transition: border-color 0.3s ease;
    }

    .form-group textarea:focus, .form-group input:focus {
        border-color: #007bff;
        outline: none;
    }

    .rating-stars {
        display: flex;
        gap: 5px;
        direction: rtl;
    }

    .rating-stars input {
        display: none;
    }

    .rating-stars label {
        color: #ffd700;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .rating-stars input:checked ~ label {
        color: #ffd700;
    }

    .comment-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .comment-card {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .comment-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .comment-user-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .comment-header strong {
        font-size: 1.1rem;
        color: #333;
    }

    .comment-rating {
        display: flex;
        gap: 2px;
    }

    .star {
        font-size: 1.5rem;
        color: #ffd700;
    }

    .comment-text {
        font-size: 1rem;
        color: #666;
        margin-bottom: 10px;
    }

    .comment-footer {
        text-align: right;
    }

    .btn-like {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-like:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.rating-stars label');
        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.innerHTML = '&#9733;'; // Filled star
                    } else {
                        s.innerHTML = '&#9734;'; // Empty star
                    }
                });
            });
        });
    });
</script>
@endsection
