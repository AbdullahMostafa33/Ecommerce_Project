@extends('layouts.admin')

@section('title',  'Edit Section')

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
    <h1>Edit Section</h1>
    <form action="{{ route('admin.sections.update', $section->id) }}" method="POST">
        @csrf       
        @method('PUT')       

        <div class="mb-3">
            <label for="name" class="form-label">Section Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $section->name) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Section</button>
    </form>
</div>
@endsection
