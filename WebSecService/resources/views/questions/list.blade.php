@extends('layouts.master')
@section('title', 'MCQ Questions')
@section('content')
<div class="container mt-5">
    <h2 class="text-primary text-center">MCQ Questions</h2>

    {{-- Add New Question Button --}}
    <a href="{{ route('questions.create') }}" class="btn btn-success mb-3">Add New Question</a>

    {{-- Start Exam Button --}}
    <a href="{{ route('questions.start') }}" class="btn btn-primary mb-3 float-end">Start Exam</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Questions Table --}}
    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>Question</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->text }}</td>
                    <td>
                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this question?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
