<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * list pending tasks
     */
    public function index()
    {
        $tasks = Task::where('status','Pending')->get();
        return view('tasks.index', compact('tasks'));
    }
    
    /**
     * add task
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|unique:tasks,task',
        ]);

        $task = new Task();
        $task->task = $request->input('task');
        $task->status = $request->input('status')?? "Pending";
        $task->save();
        return response()->json($task);
    }

    /**
     * update task status to completed
     */
    public function markCompleted(Task $task)
    {
        $task->update(['status' => 'Completed']);
        return response()->json($task);
    }

    /**
     * delete task
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['success' => 'Task deleted successfully.']);
    }

    /**
     * list all tasks
     */
    public function showAllTasks()
    {
        $tasks = Task::get();
        return response()->json($tasks);
    }
}
