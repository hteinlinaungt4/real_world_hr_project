<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProjectLeader;
use App\Models\ProjectMember;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreProject;
use App\Http\Requests\UpdateProject;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
     //
    function index(){
        if(!auth()->user()->can('project_view')){
            abort(403,'Unauthorized Action');
        }
        return view('project.index');
    }
    // // datatable
    function ssd(){
        $project=Project::with('leaders','members');
        return DataTables::of($project)
        ->editColumn('priority',function($each){
            if($each->priority == "high"){
                $output ='<span class=" badge badge-pill badge-danger bg-danger mx-2 p-2">High</span>';
            }else if($each->priority == "middle"){
                $output ='<span class=" badge badge-pill text-black badge-danger bg-info mx-2 p-2 fw-bold">Middle</span>';
            }else{
                $output ='<span class=" badge badge-pill badge-danger bg-primary mx-2 p-2">Low</span>';
            }
            return $output;

        })
        ->editColumn('description',function($each){
            return '<p style="overflow:auto; text-wrap: wrap;justify-content:left !important;
            width:300px; height:300px;">'. Str::limit($each->description, 100 ).'</p>';
        })
        ->editColumn('status',function($each){
            if($each->status == "pending"){
                $output ='<span class=" badge badge-pill badge-danger bg-danger mx-2 p-2">Pending</span>';
            }else if($each->status == "in_progress"){
                $output ='<span class=" badge badge-pill text-black badge-danger bg-info mx-2 p-2 fw-bold">In_Progress</span>';
            }else{
                $output ='<span class=" badge badge-pill badge-danger bg-primary mx-2 p-2">Complete</span>';
            }
            return $output;
        })
        ->addColumn('leader',function($each){
            $output = '';
           foreach($each->leaders as $leader){
                if($leader->img_path() == null){
                    $output .= ' <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                    style="width: 50px; height:50px;" class=" mb-1 border border-success p-1 rounded rounded-circle mx-1">';
                }else{
                     $output .='<img style="width:50px;height:50px;" class=" mb-1 border border-success p-1 rounded rounded-circle mx-1"  src="'.$leader->img_path().'">';
                }
            }
            return '<div class="text-center text-wrap" >'.$output
            .'</div>';
        })
        ->addColumn('member',function($each){
            $output = '';
           foreach($each->members as $member){
                if($member->img_path() == null){
                    $output .= ' <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                    style="width: 50px; height:50px;" class=" mb-1 border border-success p-1 rounded rounded-circle mx-1">';
                }else{
                     $output .='<img style="width:50px;height:50px;" class="mb-1   border border-success p-1 rounded rounded-circle mx-1"  src="'.$member->img_path().'">';

                }
            }
            return '<div class="text-center text-wrap" >'.$output
            .'</div>';
        })
        ->addColumn('actions',function($each){
            $detail = '<a href="'.route('project.show',$each->id).'" class="text-info shadow p-2"><i class="fa-solid fa-info p-1 fw-bold"></i></a>';
            $edit = '<a href="'.route('project.edit',$each->id).'" class="text-primary shadow p-2"><i class="fa-regular fa-pen-to-square p-1 fw-bold"></i></a>';
            $delete='<a href="#" class=" delete_btn text-danger shadow  p-2" data-id="'.$each->id.'" ><i class="fa-solid fa-trash p-1 fw-bold"></i></a>';
            return '<div class="d-flex justify-content-center">'.
                    $edit.$detail.$delete
                    .'</div>';
        })
        ->rawColumns(['actions','priority','status','leader','member','description'])
        ->make(true);
    }
    // edit
    function edit($id){
        if(!auth()->user()->can('project_edit')){
            abort(403,'Unauthorized Action');
        }
        $project=Project::findorfail($id);
        $users=User::orderBy('name')->get();
        return view('project.edit',compact('project','users'));
    }
    // delete
    function destroy($id){
        if(!auth()->user()->can('project_delete')){
            abort(403,'Unauthorized Action');
        }
        $project=Project::findorFail($id);
        if($project->images != null){
            foreach ($project->images as $oldimage) {
                Storage::delete('public/project/'.$oldimage);
            }
        }
        if($project->files != null){
            foreach ($project->files as $oldimage) {
                Storage::delete('public/project/'.$oldimage);
            }
        }

        $project->leaders()->detach();
        $project->members()->detach();



        $project->delete();

        $data=[
            'msg' => 'success',
        ];
        return response()->json($data, 200);
    }

    // create
    function create(){
        if(!auth()->user()->can('project_create')){
            abort(403,'Unauthorized Action');
        }
        $users=User::orderBy('name')->get();
        return view('project.create',compact('users'));
    }
    // update
    function update($id,UpdateProject $request){
        if(!auth()->user()->can('project_edit')){
            abort(403,'Unauthorized Action');
        }
        $project=Project::findOrFail($id);
        $images_name=$project->images;
        $filename=$project->files;
            if($request->hasFile('images')){
                if($project->images != null){
                    foreach ($project->images as $oldimage) {
                        Storage::delete('public/project/'.$oldimage);
                    }
                }
                $images_name=[];
                $files=$request->file('images');
                foreach ($files as $file) {
                    $file_name=uniqid().'_'.time().'_'.$file->getClientOriginalName();
                    Storage::disk('public')->put('project/'.$file_name,file_get_contents($file));
                    $images_name[]=$file_name;
                }
            }

            if($request->hasFile('files')){
                if($project->files != null){
                    foreach ($project->files as $oldimage) {
                        Storage::delete('public/project/'.$oldimage);
                    }
                }
                $filename=[];
                $files=$request->file('files');

                foreach ($files as $file) {
                    $file_name=uniqid().'_'.time().'_'.$file->getClientOriginalName();
                    Storage::disk('public')->put('project/'.$file_name,file_get_contents($file));
                    $filename[]=$file_name;
                }
            }

        $project->title = $request->title;
        $project->description = $request->description;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->files = $filename;
        $project->images = $images_name;
        $project->update();

        $project->leaders()->sync($request->leader);
        $project->members()->sync($request->member);




  return redirect()->route('project.index')->with(['successmsg' => 'You are Updated Successfully!']);

    }
         // show
    function show($id){
        if(!auth()->user()->can('employee_view')){
            abort(403,'Unauthorized Action');
        }
        $project=Project::findorfail($id);
        return view('project.show',compact('project'));
    }

    // store
    function store(StoreProject $request){
        if(!auth()->user()->can('project_create')){
            abort(403,'Unauthorized Action');
        }
        $imagesname=null;
        $filename=null;
        if($request->hasFile('images')){
            $imagesname=[];
            $files=$request->file('images');
            foreach ($files as $file) {
                $file_name=uniqid().'_'.time().'_'.$file->getClientOriginalName();
                Storage::disk('public')->put('project/'.$file_name,file_get_contents($file));
                $imagesname[]=$file_name;
            }
        }
        if($request->hasFile('files')){
            $filename=[];
            $files=$request->file('files');

            foreach ($files as $file) {
                $file_name=uniqid().'_'.time().'_'.$file->getClientOriginalName();
                Storage::disk('public')->put('/project/'.$file_name,file_get_contents($file));
                $filename[]=$file_name;
            }
        }
        $project=new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->files = $filename;
        $project->images = $imagesname;
        $project->save();

        $project->leaders()->sync($request->leader);
        $project->members()->sync($request->member);

        return redirect()->route('project.index')->with(['successmsg' => 'You are created Successfully!']);
    }



}

