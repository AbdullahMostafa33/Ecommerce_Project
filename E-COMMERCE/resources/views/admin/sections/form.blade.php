@extends('layouts.admin')

@section('title','Add New Section')

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
    <h1>Add New Section</h1>
    <form action="{{  route('admin.sections.store') }}" method="POST">
        @csrf       

        <div class="mb-3">
            <label for="name" class="form-label">Section Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Add Section</button>
    </form>
</div>
@endsection
