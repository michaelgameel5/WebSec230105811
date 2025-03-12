@extends('layouts.master')
@section('title', 'Start Exam')
@section('content')
<div class="container mt-5">
    <h2 class="text-primary text-center">Start MCQ Exam</h2>
    
    <form action="{{ route('questions.submit') }}" method="POST">
        @csrf

        @foreach($questions as $question)
            <div class="mb-4">
                <p><strong>{{ $question->text }}</strong></p>
                @foreach($question->options as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" required>
                        <label class="form-check-label">{{ $option }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Submit Exam</button>
    </form>
</div>
@endsection
