@extends('layouts.app')

@section('title', 'Sections')

@section('content')
<div class="main-content">
    <h1>Sections</h1>
    <div class="section-grid">
        @foreach($sections as $section)
            <div class="section-card">
                <img src="{{ asset($section->image) }}" alt="{{ $section->name }}" class="section-image">
                <h3 class="section-name">{{ $section->name }}</h3>
                <a href="{{ route('products.index', $section->id) }}" class="btn btn-primary">View Products</a>
            </div>
        @endforeach
    </div>
</div>
<style>
    /* Section Index Styles */
.section-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.section-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
    padding: 10px;
}

.section-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.section-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.section-name {
    font-size: 1rem;
    color: #333;
    margin: 10px 0;
}

/* Section Show Styles */
.section-image-large {
    width: 100%;
    height: 300px;
    object-fit: cover;
    margin-bottom: 20px;
}

</style>
@endsection
