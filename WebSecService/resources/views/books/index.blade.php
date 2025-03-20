@extends('layouts.master')
@section('title', 'Books List')
@section('content')

<div class="container">
    <h1>Book List</h1>
    @auth
    <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
    @endauth

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="list-group mt-3">
        @foreach($books as $book)
            <li class="list-group-item">
                <strong>{{ $book->title }}</strong> by {{ $book->author }} ({{ $book->published_year }})
            </li>
        @endforeach
    </ul>
</div>

@endsection