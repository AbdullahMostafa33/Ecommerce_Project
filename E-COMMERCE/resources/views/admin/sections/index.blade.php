@extends('layouts.admin')

@section('title', 'Manage Sections')

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>            
        </div>
    @endif

<div class="main-content">
    <h1>Manage Sections</h1>
    <a href="{{ route('admin.sections.create') }}" class="btn btn-primary mb-3">Add New Section</a>
     <div class="filter-search">
            <form action="{{route('admin.sections.index')}}">
            <input type="text" name="search" class="search-input" placeholder="Search by name ">
            <button class="button">Search</button>
            </form>
        </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
             @php $i=0;@endphp
            @foreach($sections as $section)           
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $section->name }}</td>
                    <td>
                        <a href="{{ route('admin.sections.edit', $section->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.sections.destroy', $section->id) }}" method="POST" class="d-inline">
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
