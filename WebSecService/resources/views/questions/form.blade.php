@extends('layouts.master')
@section('title', isset($question) ? 'Edit Question' : 'Add Question')
@section('content')
<div class="container mt-5">
    <h2 class="text-primary text-center">{{ isset($question) ? 'Edit Question' : 'Add Question' }}</h2>

    <form action="{{ isset($question) ? route('questions.update', $question->id) : route('questions.store') }}" method="POST">
        @csrf
        @isset($question)
            @method('PUT')
        @endisset

        <div class="mb-3">
            <label for="text" class="form-label">Question:</label>
            <input type="text" name="text" class="form-control" value="{{ $question->text ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label for="options" class="form-label">Options (Comma separated):</label>
            <input type="text" name="options" class="form-control" value="{{ isset($question) ? implode(',', $question->options) : '' }}" required>
        </div>

        <div class="mb-3">
            <label for="correct_answer" class="form-label">Correct Answer:</label>
            <input type="text" name="correct_answer" class="form-control" value="{{ $question->correct_answer ?? '' }}" required>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($question) ? 'Update' : 'Create' }}</button>
    </form>
</div>
@endsection
