<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\TaskMember;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $task=new Task();
        $task->project_id = $request->project_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->status = $request->status;
        $task->save();

        $task->task_members()->sync($request->members);


    }
    // task table
    public function task_table(Request $request){
        $id = $request->id;
        $project=Project::with('leaders','members','tasks')
        ->where('id',$id)
        ->where(function($query){
            $query->whereHas('leaders',function($q1){
                $q1->where('user_id',Auth::user()->id);
            })
            ->orwhereHas('members',function($q2){
                $q2->where('user_id',Auth::user()->id);
            });
        })
        ->firstOrFail();
        return view('components.task_table',compact('project'))->render();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $task=Task::findorfail($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->update();

        $task->task_members()->sync($request->members);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task=Task::findorfail($id);
        $task->delete();
        $task->task_members()->detach();

    }
    // sort
    public function task_sort(Request $request){
        $project=Project::with('tasks')->where('id',$request->project_id)->firstOrFail();
        if($request->pendingtask){
            $pendingtask = explode(',',$request->pendingtask);
            foreach ($pendingtask as $key => $task_id) {
                $task = collect($project->tasks)->where('id',$task_id)->first();
                if($task){
                    $task->serial_number = $key;
                    $task->status = "pending";
                    $task->update();
                }
            }
             return "success";
        }
        if($request->inprogresstask){
            $inprogresstask = explode(',',$request->inprogresstask);
            foreach ($inprogresstask as $key => $task_id) {
                $task = collect($project->tasks)->where('id',$task_id)->first();
                if($task){
                    $task->serial_number = $key;
                    $task->status = "in_progress";
                    $task->update();
                }
            }
             return "success";
        }
        if($request->completetask){
            $completetask = explode(',',$request->completetask);
            foreach ($completetask as $key => $task_id) {
                $task = collect($project->tasks)->where('id',$task_id)->first();
                if($task){
                    $task->serial_number = $key;
                    $task->status = "complete";
                    $task->update();
                }
            }
             return "success";
        }
    }
}
