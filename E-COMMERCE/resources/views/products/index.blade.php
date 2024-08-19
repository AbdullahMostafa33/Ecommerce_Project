@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="main-content">
    <h1>Products in Section</h1>

    <!-- Search Form -->
    <form action="" method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card">
                <img src="{{asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                <h3 class="product-name">{{ $product->name }}</h3>
                <p class="product-price">${{ $product->price }}</p>
                <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">View Details</a>
            </div>
        @endforeach
    </div>
</div>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.main-content {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 40px;
}

/* Search Form Styles */
.search-form {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.search-form input[type="text"] {
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ddd;
    border-radius: 4px 0 0 4px;
    width: 300px;
}

.search-form button {
    padding: 10px 20px;
    font-size: 1rem;
    border: none;
    background-color: #007bff;
    color: #fff;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-form button:hover {
    background-color: #0056b3;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.product-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
    padding: 10px;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.product-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-image:hover {
    transform: scale(1.05);
}

.product-name {
    font-size: 1rem;
    color: #333;
    margin: 10px 0;
}

.product-price {
    font-size: 0.9rem;
    color: #007bff;
    margin-bottom: 15px;
}

.btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 15px;
    font-size: 0.875rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border-radius: 4px;
    text-decoration: none;
}

.btn:hover {
    background-color: #0056b3;
}

</style>
@endsection
