@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif
<div class="main-content">
    <h1>Manage Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Add New Product</a>
     <div class="filter-search">
            <form action="{{route('admin.products.index')}}">
            <input type="text" name="search" class="search-input" placeholder="Search by name ">
            <button class="button">Search</button>
            </form>
        </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Section</th>
                <th>Description</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><img src="{{asset($product->image) }}" alt="img" width="50" height="50"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->section->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{$product->stock}}</td>                    
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
<style>
    filter-status, .filter-search {
    display: flex;
    direction: rtl;
}

</style>
