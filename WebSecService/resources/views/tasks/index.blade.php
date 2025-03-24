@extends('layouts.master')
@section('title', 'Task List')
@section('content')

    @can('view_tasks')

    <div class="container">
        <h2>Task List</h2>
        @can('add_tasks')
        <a href="{{ route('tasks_create') }}" class="btn btn-success mb-2">Add Task</a>
        @endcan
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Assigned User</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->user ? $task->user->name : 'Unassigned' }}</td>
                    <td>
                        @can('edit_tasks')
                        <a href="{{ route('tasks_edit', $task->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        @endcan
                        @can('delete_tasks')
                        <form action="{{ route('tasks_destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No tasks found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endcan

@endsection