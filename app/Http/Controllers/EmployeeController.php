<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreEmployee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateEmployee;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    //index
    function index(){
        if(!auth()->user()->can('employee_view')){
            abort(403,'Unauthorized Action');
        }
        return view('employee.index');
    }

    // datatable
    function ssd(){
        $employee=User::with('department');
        return DataTables::of($employee)
        ->filterColumn('department_name',function($query,$keyword){
            $query->whereHas('department',function($q1) use ($keyword){
                $q1->where('title','like','%'.$keyword.'%');
            });
        })
        ->addColumn('role',function($each){
            $output = "";
            foreach($each->roles as $role){
                 $output .='<span class=" badge badge-pill badge-danger bg-success mx-2 p-2">'.$role->name.'</span>';
            }
            return $output;
        })
        ->editColumn('image',function($each){
            return ($each->image != null ) ?  '<img src="'.$each->img_path().'"
            class="p-3" width="150"> <p>'.$each->name.'</p>' : '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
            class="p-3" width="150"> <p>'.$each->name.'</p>';
        })
        ->addColumn('department_name',function($each){
            return $each->department ? $each->department->title : '_';
        })
        ->editColumn('is_present', function($each) {
            if($each->is_present == 1){
                return '<span class=" badge badge-pill badge-success bg-success p-2">Present</span>';
            }else{
                return '<span class=" badge badge-pill badge-danger bg-danger p-2">Leave</span>';
            }
        })
        ->addColumn('actions',function($each){
            $userid=Auth::user()->id;

            $edit = '<a href="'.route('employee.edit',$each->id).'" class="text-primary shadow p-2"><i class="fa-regular fa-pen-to-square p-1 fw-bold"></i></a>';
            $detail = '<a href="'.route('employee.show',$each->id).'" class="text-info shadow  p-2"><i class="fa-solid fa-info p-1 fw-bold"></i></a>';
            $delete=  ($each->id != $userid ) ? '<a href="#" class=" delete_btn text-danger shadow  p-2" data-id="'.$each->id.'" ><i class="fa-solid fa-trash p-1 fw-bold"></i></a>' : "";
            return '<div class="d-flex justify-content-between">'.
                    $edit.$detail.$delete
                    .'</div>';
        })
        ->rawColumns(['is_present','actions','image','role'])
        ->make(true);
    }

    // create
    function create(){
        if(!auth()->user()->can('employee_create')){
            abort(403,'Unauthorized Action');
        }
        $roles=Role::all();
        $departments=Department::get();
        return view('employee.create',compact('departments','roles'));
    }
    // store
    function store(StoreEmployee $request){
        if(!auth()->user()->can('employee_create')){
            abort(403,'Unauthorized Action');
        }
        $filename=null;
        if($request->hasFile('image')){
           $filename=uniqid().'_'.time().'_'.$request->file('image')->getClientOriginalName();
           $request->file('image')->storeAs('public/'.$filename);
        }
        $employee=new User();
        $employee->employee_id = $request->employee_id;
        $employee->name =$request->name;
        $employee->pin_code =$request->pin_code;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->nrc_number = $request->nrc_number;
        $employee->gender = $request->gender;
        $employee->birthday = $request->birthday;
        $employee->address = $request->address;
        $employee->department_id = $request->department_id;
        $employee->date_of_join = $request->date_of_join;
        $employee->is_present = $request->is_present;
        $employee->image=$filename;
        $employee->password = Hash::make($request->password);
        $employee->save();
        $employee->syncRoles($request->roles);

        return redirect()->route('employee.index')->with(['successmsg' => 'You are created Successfully!']);
    }
    // edit
    function edit($id){
        if(!auth()->user()->can('employee_edit')){
            abort(403,'Unauthorized Action');
        }
        $roles=Role::all();
        $employee=User::findorfail($id);
        $oldrole=$employee->roles->pluck('id')->toArray();
        $departments=Department::get();
        return view('employee.edit',compact('departments','employee','oldrole','roles'));
    }
     // update
     function update($id,UpdateEmployee $request){
        $employee=User::findOrFail($id);
        if($request->file('image')){
            $oldimage=User::select('image')->where('id',$id)->first();
            $oldimage=$oldimage['image'];
            if($oldimage != null){
                Storage::delete('public/'.$oldimage);
            }
            $filename=uniqid().'_'.time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/'.$filename);
            $employee->image=$filename;
        }
        $employee->employee_id = $request->employee_id;
        $employee->name = $request->name;
        $employee->pin_code = $request->pin_code;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->nrc_number = $request->nrc_number;
        $employee->gender = $request->gender;
        $employee->birthday = $request->birthday;
        $employee->address = $request->address;
        $employee->department_id = $request->department_id;
        $employee->date_of_join = $request->date_of_join;
        $employee->is_present = $request->is_present;
        $employee->update();
        $employee->syncRoles($request->roles);

        return redirect()->route('employee.index')->with(['successmsg' => 'You are Updated Successfully!']);

    }
     // show
     function show($id){
        if(!auth()->user()->can('employee_view')){
            abort(403,'Unauthorized Action');
        }
        $employee=User::findorfail($id);
        return view('employee.show',compact('employee'));
    }
     // delete
    function destroy($id){
        if(!auth()->user()->can('employee_delete')){
            abort(403,'Unauthorized Action');
        }
        $oldimage=User::select('image')->where('id',$id)->first();
        $oldimage=$oldimage['image'];
        if($oldimage != null){
            Storage::delete('public/'.$oldimage);
         }
        User::where('id',$id)->delete();
        $data=[
            'msg' => 'success',
        ];
        return response()->json($data, 200);
    }
}
