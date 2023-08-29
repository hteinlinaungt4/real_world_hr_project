<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\StorePermission;
use App\Http\Requests\UpdateDepartment;
use App\Http\Requests\UpdatePermission;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\PermissionController;

class PermissionController extends Controller
{
     //
     function index(){
        if(!auth()->user()->can('permission_view')){
            abort(403,'Unauthorized Action');
        }
        return view('permission.index');
    }
    // // // datatable
    function ssd(){
        $permission=Permission::query();
        return DataTables::of($permission)
        ->addColumn('actions',function($each){
            $edit = '<a href="'.route('permission.edit',$each->id).'" class="text-primary shadow p-2"><i class="fa-regular fa-pen-to-square p-1 fw-bold"></i></a>';
            $delete='<a href="#" class=" delete_btn text-danger shadow  p-2" data-id="'.$each->id.'" ><i class="fa-solid fa-trash p-1 fw-bold"></i></a>';
            return '<div class="d-flex justify-content-center">'.
                    $edit.$delete
                    .'</div>';
        })
        ->rawColumns(['actions'])
        ->make(true);
    }
    // // edit
    function edit($id){
        if(!auth()->user()->can('permission_edit')){
            abort(403,'Unauthorized Action');
        }
        $permission=Permission::findorfail($id);
        return view('permission.edit',compact('permission'));
    }
    // // delete
    function destroy($id){
        if(!auth()->user()->can('permission_delete')){
            abort(403,'Unauthorized Action');
        }
        Permission::where('id',$id)->delete();
        $data=[
            'msg' => 'success',
        ];
        return response()->json($data, 200);
    }

    // // create
    function create(){
        if(!auth()->user()->can('permission_create')){
            abort(403,'Unauthorized Action');
        }
        return view('permission.create');
    }
    // // update
    function update($id,UpdatePermission $request){
        if(!auth()->user()->can('permission_edit')){
            abort(403,'Unauthorized Action');
        }
        $data=[
            'name' => $request->name,
        ];
        Permission::where('id',$id)->update($data);
        return redirect()->route('permission.index')->with(['successmsg' => 'You are Updated Successfully!']);

    }
    // // store
    function store(StorePermission $request){
        if(!auth()->user()->can('permission_create')){
            abort(403,'Unauthorized Action');
        }
        $role= Permission::create(['guard_name' => 'web', 'name' => $request->name]);
        return redirect()->route('permission.index')->with(['successmsg' => 'You are created Successfully!']);
    }



}
