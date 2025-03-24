@extends('layouts.master')
@section('title', 'Edit Task')

@section('content')

<form action="{{ route('tasks_update', $task->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Correct HTTP method for update -->
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ $task->title }}" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" required>{{ $task->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
    </div>
    <div class="form-group">
        <label for="due_date">Due Date</label>
        <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $task->due_date }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Assign to User</label>
        <select name="user_id" class="form-select">
            <option value="">Unassigned</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $task->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} (ID: {{ $user->id }})
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Update Task</button>
</form>

@endsection
