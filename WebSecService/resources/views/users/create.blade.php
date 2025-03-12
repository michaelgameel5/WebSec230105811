@extends('layouts.master')
@section('title', 'Create User')
@section('content')
<div class="container mt-5">
    <h2 class="text-primary">Create New User</h2>

    <form action="{{ route('users_store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create User</button>
    </form>

    <a href="{{ route('users_index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection