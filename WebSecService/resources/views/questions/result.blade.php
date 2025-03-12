@extends('layouts.master')
@section('title', 'Exam Results')
@section('content')
<div class="container mt-5">
    <h2 class="text-primary text-center">Exam Results</h2>

    <div class="alert alert-info">
        <h4>Your Score: {{ $score }} / {{ $total }}</h4>
    </div>

    <a href="{{ route('questions.start') }}" class="btn btn-secondary">Retake Exam</a>
</div>
@endsection
