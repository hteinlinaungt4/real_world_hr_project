<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use App\Models\CheckinCheckout;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    // index
    function index(){
        return view('payroll');
    }
    //table
    function overview_table(Request $request){
        $month=$request->months;
        $year=$request->years;
        $startOfMonth=$year.'-'.$month.'-01'; //2023-02-01
        $endOfMonth=Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');
        // use day of Month
        $dayofMonth=Carbon::parse($startOfMonth)->daysInMonth;

        // use working day
        $workingdays= Carbon::parse($startOfMonth)->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, Carbon::parse($endOfMonth)->addDays(1));
        // offday
        $offdays=$dayofMonth-$workingdays;
        // leave

        $companysettings=CompanySetting::find('1')->first();
        $periods = CarbonPeriod::create($startOfMonth,$endOfMonth);
        $employees=User::orderBy('employee_id')->where('name','like','%'.$request->employee.'%')->get();
        $attendances=CheckinCheckout::whereMonth('date',$month)->whereYear('date',$year)->get();
        return view('components.payroll_table',compact('periods','employees','attendances','companysettings','dayofMonth','workingdays','offdays','month','year'))->render();
    }

}
