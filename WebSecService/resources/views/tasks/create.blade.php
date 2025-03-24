@extends('layouts.master')
@section('title', 'Create Task')

@section('content')
<div class="container">
    <h2>Create Task</h2>
    <form action="{{ route('tasks_store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Assign to User</label>
            <select name="user_id" class="form-select">
                <option value="">Unassigned</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} (ID: {{ $user->id }})
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Create Task</button>
    </form>
</div>
@endsection
