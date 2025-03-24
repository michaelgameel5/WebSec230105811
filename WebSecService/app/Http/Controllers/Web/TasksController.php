<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;


class TasksController extends Controller
{
    

    public function index()
    {
        $query = Task::query();
    

        // If the user is an admin, show all tasks
        if (auth()->user()->hasRole('Admin')) {
            $tasks = $query->with('user')->get();
        } else {
            $tasks = $query->with('user')->where('user_id', auth()->id())->get();
        }
        
        
    
        return view('tasks.index', compact('tasks'));
    }
    

    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'user_id' => 'nullable|exists:users,id', // Ensure the user ID exists in the users table
        ]);
    
        // Create the task with the validated data
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'user_id' => $request->user_id, // Assign the selected user ID
        ]);
    
        // Redirect back to the task list with a success message
        return redirect()->route('tasks_index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,completed',
            'due_date' => 'required|date',
            'user_id' => 'nullable|exists:users,id', // Ensure the user ID exists in the users table
        ]);
    
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'user_id' => $request->user_id, // Assign the selected user ID
        ]);
    
        return redirect()->route('tasks_index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks_index')->with('success', 'Task deleted successfully.');
    }
}