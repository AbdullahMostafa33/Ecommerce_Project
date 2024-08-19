@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="main-content">
    <h1>Add New Product</h1>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf      

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label for="section_id" class="form-label">Section</label>
            <select name="section_id" id="section_id" class="form-select" required>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">image</label>
            <input type="file" name="image_file" id="image_file" class="form-control" value="{{ old('image') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Add Product</button>
    </form>
</div>
@endsection
