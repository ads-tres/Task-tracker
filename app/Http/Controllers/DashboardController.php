<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(Request $request)
    {

        //fetching role
        $user = auth()->user();

        if ($user->role === 'admin') {

            $today = Carbon::today();

            // Stats
            $tasksDueToday = Task::whereDate('deadline', $today)->count();
            $tasksCompletedToday = Task::where('status', 'Completed')->whereDate('updated_at', $today)->count();
            $tasksOverdue = Task::where('status', '!=', 'Completed')->whereDate('deadline', '<', $today)->count();
        
            // Task Query with Filters
            $query = Task::with('employee');
        
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
        
            if ($request->filled('priority')) {
                $query->where('priority', $request->priority);
            }
        
            $tasks = $query->latest()->paginate(5);
        
            return view('dashboard.admin', compact(
                'tasks',
                'tasksDueToday',
                'tasksCompletedToday',
                'tasksOverdue'
            ));

    
        } 


        else {
            // For employees            
            $query = Task::where('employee_id', $user->id);

            // Checks if the user selected a status filter in the dropdown
            if (request('status')) {
                $query->where('status', request('status'));
            }
            // if (request('priority')) {
            //     $query->where('priority', request('priority'));
            // }
            

            $tasks = $query->latest()->get();

            return view('dashboard.employee', compact('tasks'));
        }
    }
}




