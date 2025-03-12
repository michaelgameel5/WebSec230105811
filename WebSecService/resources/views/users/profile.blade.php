@extends('layouts.master')
@section('title', 'Profile Page')
@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body text-center">
            <h1 class="mb-4 text-primary">User Profile</h1>
            <p class="fs-5"><strong>Name:</strong> {{ $user->name }}</p>
            <p class="fs-5"><strong>Email:</strong> {{ $user->email }}</p>
        </div>
    </div>
</div>
@endsection