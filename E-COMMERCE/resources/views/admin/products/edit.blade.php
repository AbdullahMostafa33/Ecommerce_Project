@extends('layouts.admin')

@section('title','Edit Product')

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
    <h1>Edit Product</h1>
    <form action="{{  route('admin.products.update', $product->id) }}" method="POST"  enctype="multipart/form-data">
        @csrf       
        @method('PUT')       

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{  $product->price }}" required>
        </div>

        <div class="mb-3">
            <label for="section_id" class="form-label">Section</label>
            <select name="section_id" id="section_id" class="form-select" required>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" {{ $product->section_id == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{  $product->description}}</textarea>
        </div>
          <div class="mb-3">
            <label for="stock" class="form-label">stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{$product->stock}}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">image</label>
            <input type="file" name="image_file" id="image_file" class="form-control" >
        </div>

        <button type="submit" class="btn btn-success">Update Product</button>
    </form>
</div>
@endsection
