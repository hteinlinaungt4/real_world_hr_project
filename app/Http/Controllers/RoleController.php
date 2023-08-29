<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use Yajra\DataTables\DataTables;
use App\Http\Requests\UpdateRole;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
     //
     function index(){
        if(!auth()->user()->can('role_view')){
            abort(403,'Unauthorized Action');
        }
        return view('role.index');
    }
    // // datatable
    function ssd(){
        $role=Role::query();
        return DataTables::of($role)
        ->addColumn('permission',function($each){
            $output = "";
            foreach($each->permissions as $permission){
                 $output .= '<span class="badge badge-pill badge-danger bg-success mx-2 p-2">'.$permission->name.'</span>';
            }
            return '<div style=" overflow: auto;
            max-width: 900px;
            text-wrap: wrap;
            padding: 10px;
            line-height: 50px;">'.$output.'</div>';
        })
        ->addColumn('actions',function($each){
            $edit = '<a href="'.route('role.edit',$each->id).'" class="text-primary shadow p-2"><i class="fa-regular fa-pen-to-square p-1 fw-bold"></i></a>';
            $delete='<a href="#" class=" delete_btn text-danger shadow  p-2" data-id="'.$each->id.'" ><i class="fa-solid fa-trash p-1 fw-bold"></i></a>';
            return '<div class="d-flex justify-content-center">'.
                    $edit.$delete
                    .'</div>';
        })
        ->rawColumns(['actions','permission'])
        ->make(true);
    }
    // edit
    function edit($id){
        if(!auth()->user()->can('role_edit')){
            abort(403,'Unauthorized Action');
        }
        $permissions=Permission::all();
        $role=Role::findorfail($id);
        $oldpermission=$role->permissions->pluck('id')->toArray();
        return view('role.edit',compact('role','permissions','oldpermission'));
    }
    // delete
    function destroy($id){
        if(!auth()->user()->can('role_delete')){
            abort(403,'Unauthorized Action');
        }
        Role::where('id',$id)->delete();
        $data=[
            'msg' => 'success',
        ];
        return response()->json($data, 200);
    }

    // create
    function create(){
        if(!auth()->user()->can('role_create')){
            abort(403,'Unauthorized Action');
        }
        $permissions=Permission::all();
        return view('role.create',compact('permissions'));
    }
    // update
    function update($id,UpdateRole $request){
        if(!auth()->user()->can('role_edit')){
            abort(403,'Unauthorized Action');
        }
        $role =Role::findOrFail($id);
        $role->name=$request->name;
        $role->update();
        $oldpermission=$role->permissions->pluck('name')->toArray();
        $role->revokePermissionTo($oldpermission);
        $role->givePermissionTo($request->permissions);
        return redirect()->route('role.index')->with(['successmsg' => 'You are Updated Successfully!']);

    }
    // store
    function store(StoreRole $request){
        if(!auth()->user()->can('role_create')){
            abort(403,'Unauthorized Action');
        }
        $role = new Role();
        $role= Role::create(['guard_name' => 'web', 'name' => $request->name]);
        $role->save();
        $role->givePermissionTo($request->permissions);
        return redirect()->route('role.index')->with(['successmsg' => 'You are created Successfully!']);
    }



}
