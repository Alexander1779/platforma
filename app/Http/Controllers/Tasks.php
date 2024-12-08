<?php

namespace App\Http\Controllers;

use App\Jobs\TaskEnded;
use App\Jobs\TaskPublic;
use App\Models\Task;
use App\Models\TaskUser;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Tasks extends Controller
{
    //
    public function index()
    {
        $id = Auth::user()->id;
        return Inertia::render('Tasks', [
            'tasks' => Task::where('start', '<=', now() )
                            ->where('end', '>=', now()->addDays(1) )
                            ->where('public', '=', true )
                            ->orWhere('user_id', '=', $id)
                            ->with('taskUsers')
                            ->get(),
            'user' => $id,
        ]);
    }

    public function store(Request $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'start' => $request->start,
            'end' => $request->end,
        ]);
        if ($task->start < now() && $task->end > now() ){
            TaskPublic::dispatch($task);
        }elseif ($task->start > now() && $task->end > now() ) {
            TaskPublic::dispatch($task)->delay(now()->addSeconds(now()->diffInSeconds(Carbon::parse($task->start))));
        }
        if($task->end > now()){
            TaskEnded::dispatch($task)->delay(now()->addSeconds(now()->diffInSeconds(Carbon::parse($task->end))));
        }
    }
    public function update(Request $request)
    {
        dd($request->all());
        $task = Task::find($request->id);
        if ($task && $task->created_by_user_id == Auth::user()->id) {
            $task->title = $request->title;
            $task->description = $request->description;
            $task->taked_user_id = $request->taked_user_id;
            $task->start = $request->start;
            $task->end = $request->end;
            $task->save();
        }
    }
    public function delete(Task $task)
    {
        if ($task && $task->user_id == Auth::user()->id) {
            $task->delete();
        }
    }
    public function take(Task $task)
    {
        $taskUser = TaskUser::where('user_id', '=', Auth::user()->id)
                        ->where('task_id', '=', $task->id)->first();
        if (!$taskUser) {
            TaskUser::create([
                'user_id' => Auth::user()->id,
                'task_id' => $task->id,
            ]);
        }
    }
    public function cancel(Task $task)
    {
        $taskUser = TaskUser::where('user_id', '=', Auth::user()->id)
                        ->where('task_id', '=', $task->id)->first();
        if ($task) {
            $taskUser->delete();
        }
    }
    public function compleate(Task $task)
    {
        $task->update([
            'status' => 'completed',
        ]);
    }
}
