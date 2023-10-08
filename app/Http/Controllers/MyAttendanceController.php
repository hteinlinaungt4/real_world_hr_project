<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use App\Models\CheckinCheckout;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class MyAttendanceController extends Controller
{
    //
    function ssd(Request $request){
        logger($request->months);
        $attendance=CheckinCheckout::with('employee')->where('user_id',Auth::user()->id);
        if($request->months){
            $attendance=$attendance->whereMonth('date',$request->months);
        }
        if($request->years){
            $attendance=$attendance->whereYear('date',$request->years);
        }
        return DataTables::of($attendance)
        ->filterColumn('employee_name',function($query,$keyword){
            $query->whereHas('employee',function($q1) use ($keyword){
                $q1->where('name','like','%'.$keyword.'%');
            });
        })
        ->editColumn('checkin_time',function($each){
            return $each->checkin_time ? Carbon::parse($each->checkin_time)->format("H:i:s") : '_';
        })
        ->editColumn('checkout_time',function($each){
            return $each->checkout_time ? Carbon::parse($each->checkout_time)->format("H:i:s") : '_';
        })
         ->addColumn('employee_name',function($each){
            return $each->employee ? $each->employee->name : '_';
        })
        ->make(true);
    }


    function overview_table(Request $request){
        $month=$request->months;
        $year=$request->years;
        $startOfMonth=$year.'-'.$month.'-01'; //2023-02-01
        $endOfMonth=Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');

        $companysettings=CompanySetting::find('1')->first();
        $periods= $periods = CarbonPeriod::create($startOfMonth,$endOfMonth);
        $employees=User::orderBy('employee_id')->where('name',Auth::user()->name)->get();
        $attendances=CheckinCheckout::whereMonth('date',$month)->whereYear('date',$year)->get();
        return view('components.attendance_overview_table',compact('periods','employees','attendances','companysettings'))->render();
    }
}
