<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Salary;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalary;
use App\Http\Requests\UpdateSalary;
use Illuminate\Log\Logger;
use Yajra\DataTables\Facades\DataTables;

class SalaryController extends Controller
{
    function index(){
        if(!auth()->user()->can('salary_view')){
            abort(403,'Unauthorized Action');
        }
        return view('salary.index');
    }
    // // datatable
    function ssd(){
        $salary=Salary::with('employee');
        return DataTables::of($salary)
        ->filterColumn('employee_name',function($query,$keyword){
            $query->whereHas('employee',function($q1) use ($keyword){
                $q1->where('name','like','%'.$keyword.'%');
            });
        })
        ->editColumn('salary',function($each){
            return number_format($each->salary);
        })
        ->editColumn('month',function($each){
            return Carbon::parse($each->year.'-'.$each->month.'-01')->format('M');
        })

        ->addColumn('employee_name',function($each){
            return $each->employee ? $each->employee->name : '_';
        })
        ->addColumn('actions',function($each){
            $edit = '<a href="'.route('salary.edit',$each->id).'" class="text-primary shadow p-2"><i class="fa-regular fa-pen-to-square p-1 fw-bold"></i></a>';
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
        if(!auth()->user()->can('salary_edit')){
            abort(403,'Unauthorized Action');
        }
        $user=User::all();
        $salary=Salary::findorfail($id);
        return view('salary.edit',compact('salary','user'));
    }
    // delete
    function destroy($id){
        if(!auth()->user()->can('salary_delete')){
            abort(403,'Unauthorized Action');
        }
        salary::where('id',$id)->delete();
        $data=[
            'msg' => 'success',
        ];
        return response()->json($data, 200);
    }

    // create
    function create(){
        if(!auth()->user()->can('salary_create')){
            abort(403,'Unauthorized Action');
        }
        $user=User::all();
        return view('salary.create',compact('user'));
    }
    // update
    function update($id,UpdateSalary $request){
        Logger('gg');
        if(!auth()->user()->can('salary_edit')){
            abort(403,'Unauthorized Action');
        }
        $data=[
            'user_id' => $request->employee,
            'month' => $request->month,
            'year' => $request->year,
            'salary' => $request->salary,
        ];
        Salary::where('id',$id)->update($data);
        return redirect()->route('salary.index')->with(['successmsg' => 'You are Updated Successfully!']);

    }
    // store
    function store(StoreSalary $request){
        if(!auth()->user()->can('salary_create')){
            abort(403,'Unauthorized Action');
        }
        $data=[
            'user_id' => $request->employee,
            'month' => $request->month,
            'year' => $request->year,
            'salary' => $request->salary,
        ];
        Salary::create($data);
        return redirect()->route('salary.index')->with(['successmsg' => 'You are created Successfully!']);
    }



}
