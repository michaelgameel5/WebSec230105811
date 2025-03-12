@extends('layouts.master')
@section('title', 'Edit User')
@section('content')
<div class="container mt-5">
    <h2 class="text-primary">Edit User</h2>

    <form action="{{ route('users_update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>

    <a href="{{ route('users_index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection