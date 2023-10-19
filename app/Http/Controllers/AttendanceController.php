<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use App\Models\CheckinCheckout;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreAttendance;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateAttendance;
use App\Http\Requests\UpdateDepartment;

class AttendanceController extends Controller
{
     //
     function index(){
        if(!auth()->user()->can('attendance_view')){
            abort(403,'Unauthorized Action');
        }
        return view('attendance.index');
    }

    // overviewtable
    function overview_table(Request $request){
        $month=$request->months;
        $year=$request->years;
        $startOfMonth=$year.'-'.$month.'-01'; //2023-02-01
        $endOfMonth=Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');

        $companysettings=CompanySetting::find('1')->first();
        $periods= $periods = CarbonPeriod::create($startOfMonth,$endOfMonth);
        $employees=User::orderBy('employee_id')->where('name','like','%'.$request->employee.'%')->get();
        $attendances=CheckinCheckout::whereMonth('date',$month)->whereYear('date',$year)->get();
        return view('components.attendance_overview_table',compact('periods','employees','attendances','companysettings'))->render();
    }

    // overview
    public function overview(){
      return view('attendance_overview');
    }
    // // datatable
    function ssd(){
        $attendance=CheckinCheckout::with('employee');
        return DataTables::of($attendance)
        ->filterColumn('employee_name',function($query,$keyword){
            $query->whereHas('employee',function($q1) use ($keyword){
                $q1->where('name','like','%'.$keyword.'%');
            });
        })
         ->addColumn('employee_name',function($each){
            return $each->employee ? $each->employee->name : '_';
        })

        ->addColumn('actions',function($each){
            $edit = '<a href="'.route('attendance.edit',$each->id).'" class="text-primary shadow p-2"><i class="fa-regular fa-pen-to-square p-1 fw-bold"></i></a>';
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
        if(!auth()->user()->can('attendance_edit')){
            abort(403,'Unauthorized Action');
        }
        $user = User::get();
        $attendance=CheckinCheckout::findorfail($id);
        return view('attendance.edit',compact('attendance','user'));
    }
    // delete
    function destroy($id){
        if(!auth()->user()->can('attendance_delete')){
            abort(403,'Unauthorized Action');
        }
        CheckinCheckout::where('id',$id)->delete();
        $data=[
            'msg' => 'success',
        ];
        return response()->json($data, 200);
    }

    // create
    function create(){
        if(!auth()->user()->can('attendance_create')){
            abort(403,'Unauthorized Action');
        }
        $user = User::get();
        return view('attendance.create',compact('user'));
    }
    // update
    function update($id,UpdateAttendance $request){
        if(!auth()->user()->can('attendance_edit')){
            abort(403,'Unauthorized Action');
        }
        $attendance =CheckinCheckout::findOrFail($id);
        if(CheckinCheckout::where('user_id',$request->user)->where('date',$request->date)->where('id','!=',$attendance->id)->exists()){
            return back()->withErrors(['fails' => 'Already Defined Date!'])->withInput();
        }
        $attendance->date =  $request->date;
        $attendance->user_id =  $request->user;
        $attendance->checkin_time =  $request->date.' '.$request->checkin_time;
        $attendance->checkout_time = $request->date.' '.$request->checkout_time;
        $attendance->update();
        return redirect()->route('attendance.index')->with(['successmsg' => 'You are Updated Successfully!']);

    }
    // store
    function store(StoreAttendance $request){
        if(!auth()->user()->can('attendance_create')){
            abort(403,'Unauthorized Action');
        }
        if(now()->format('D') == "Sat" || now()->format('D') == "Sun"){
            return back()->withErrors(['fails' => 'Today is Off Day!'])->withInput();
        }
        if(CheckinCheckout::where('user_id',$request->user)->where('date',$request->date)->exists()){
            return back()->withErrors(['fails' => 'Already Defined Date!'])->withInput();
        }
        $data=[
            'date' => $request->date,
            'user_id' => $request->user,
            'checkin_time' =>$request->date.' '.$request->checkin_time,
            'checkout_time' =>$request->date.' '.$request->checkout_time,
        ];
        CheckinCheckout::create($data);
        return redirect()->route('attendance.index')->with(['successmsg' => 'You are created Successfully!']);
    }





}
