<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;

class DepartmentController extends Controller
{
     //
     function index(){
        if(!auth()->user()->can('department_view')){
            abort(403,'Unauthorized Action');
        }
        return view('department.index');
    }
    // // datatable
    function ssd(){
        $department=Department::query();
        return DataTables::of($department)
        ->addColumn('actions',function($each){
            $edit = '<a href="'.route('department.edit',$each->id).'" class="text-primary shadow p-2"><i class="fa-regular fa-pen-to-square p-1 fw-bold"></i></a>';
            $delete='<a href="#" class=" delete_btn text-danger shadow  p-2" data-id="'.$each->id.'" ><i class="fa-solid fa-trash p-1 fw-bold"></i></a>';
            return '<div class="d-flex justify-content-center">'.
                    $edit.$delete
                    .'</div>';
        })
        ->rawColumns(['actions'])
        ->make(true);
    }
    // edit
    function edit($id){
        if(!auth()->user()->can('department_edit')){
            abort(403,'Unauthorized Action');
        }
        $department=Department::findorfail($id);
        return view('department.edit',compact('department'));
    }
    // delete
    function destroy($id){
        if(!auth()->user()->can('department_delete')){
            abort(403,'Unauthorized Action');
        }
        Department::where('id',$id)->delete();
        $data=[
            'msg' => 'success',
        ];
        return response()->json($data, 200);
    }

    // create
    function create(){
        if(!auth()->user()->can('department_create')){
            abort(403,'Unauthorized Action');
        }
        return view('department.create');
    }
    // update
    function update($id,UpdateDepartment $request){
        if(!auth()->user()->can('department_edit')){
            abort(403,'Unauthorized Action');
        }
        $data=[
            'title' => $request->title,
        ];
        Department::where('id',$id)->update($data);
        return redirect()->route('department.index')->with(['successmsg' => 'You are Updated Successfully!']);

    }
    // store
    function store(StoreDepartment $request){
        if(!auth()->user()->can('department_create')){
            abort(403,'Unauthorized Action');
        }
        $data=[
            'title' => $request->title,
        ];
        Department::create($data);
        return redirect()->route('department.index')->with(['successmsg' => 'You are created Successfully!']);
    }



}
