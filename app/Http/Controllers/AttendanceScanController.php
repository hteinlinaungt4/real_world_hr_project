<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CheckinCheckout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AttendanceScanController extends Controller
{
    //
    public function scan(){
        return view('attendance_scan');
    }
    public function store(Request $request){
        $hash_value=$request->value;
        $user=Auth::user();
        $message="";
        if(!Hash::check(Carbon::parse(now())->format('Y-m-d H'),$hash_value)){
            $data =[
                'status' => 'fail',
                'message' => "Qr Code is Invalid!",
            ];
             return response()->json($data, 200);
        }
        $checkincheckoutdata= CheckinCheckout::firstOrCreate(
            [
                'user_id'=>$user->id,
                'date'=> now()->format('Y-m-d')

            ]

        );
        if(!is_null($checkincheckoutdata->checkin_time) && !is_null($checkincheckoutdata->checkout_time)){
            $data =[
                'message' => "You are Already Check In && Check Out Today ",
            ];
             return response()->json($data, 200);
        }

        if(is_null($checkincheckoutdata->checkin_time)){
            $checkincheckoutdata->checkin_time= now();
            $message  = "Successfully check in at".now();

        }else{
            if(is_null($checkincheckoutdata->checkout_time)){
                $checkincheckoutdata->checkout_time= now();
                $message  = "Successfully check out at".now();
            }
        }
        $checkincheckoutdata->update();
        $data =[
            'message' => $message,
        ];
     return response()->json($data, 200);

    }
}
