@extends('layouts.master')
@section('title', 'Create Book')
@section('content')

<div class="container">
    <h1>Add a New Book</h1>

    <form action="{{ route('bookts.sore') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Author:</label>
            <input type="text" name="author" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Published Year:</label>
            <input type="number" name="published_year" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Add Book</button>
    </form>
</div>

@endsection