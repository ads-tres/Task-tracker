<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create()
    {
        $employees = User::where('role', 'employee')->get();
        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'employee_id' => 'required|exists:users,id',
            'deadline' => 'required|date',
            'priority' => 'required|in:Low,Medium,High',
        ]);
        
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'employee_id' => $request->employee_id,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'status' => 'Assigned',
        ]);
        

        return redirect()->route('dashboard')->with('success', 'Task created successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Only the assigned employee can update
        if (auth()->id() !== $task->employee_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Not Started,In Progress,Completed'
        ]);

        $task->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Task status updated.');
    }

    //time spent
    public function logTime(Request $request, Task $task)
    {
        if (auth()->id() !== $task->employee_id) {
            abort(403);
        }

        $request->validate([
            'time_spent' => 'required|integer|min:0',
        ]);

        $task->update([
            'time_spent' => $request->time_spent,
        ]);

        return back()->with('success', 'Time updated successfully.');
    }

    // feedback
    public function submitFeedback(Request $request, Task $task)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'feedback' => 'nullable|string',
        ]);

        $task->update([
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Feedback saved.');
    }


}
