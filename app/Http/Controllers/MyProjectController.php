<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyProjectController extends Controller
{
    //index
    function index(){
        return view('myproject.index');
    }
     // // datatable
     function ssd(){
        $project=Project::with('leaders','members')->whereHas('leaders',function($query){
            $query->where('user_id',Auth::user()->id);
        })->orWhereHas('members',function($query){
            $query->where('user_id',Auth::user()->id);
        });
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
            $detail = '<a href="'.route('myproject.show',$each->id).'" class="text-info shadow p-2"><i class="fa-solid fa-info p-1 fw-bold"></i></a>';
            return '<div class="d-flex justify-content-center">'.
                    $detail
                    .'</div>';
        })
        ->rawColumns(['actions','priority','status','leader','member','description'])
        ->make(true);
    }
           // show
    function show($id){
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
        return view('myproject.show',compact('project'));
    }
}
