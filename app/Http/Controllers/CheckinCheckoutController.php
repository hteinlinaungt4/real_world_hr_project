<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Log\Logger;
use Illuminate\Http\Request;
use App\Models\CheckinCheckout;
use Illuminate\Support\Facades\Hash;

class CheckinCheckoutController extends Controller
{
    //index
    public function index(){
        $hash_value=Hash::make(Carbon::parse(now())->format( 'Y-m-d H'));
        return view('checkin_checkout',compact('hash_value'));
    }
    public function pincode(Request $request){
        $pincode=$request->value;
        $message="";
        $pincode=User::where('pin_code',$pincode)->first();
        if(!$pincode){
            $data =[
                'status' => 'fail',
                'message' => "Pin Code is Wrong",
            ];
             return response()->json($data, 200);
        }
        $checkincheckoutdata= CheckinCheckout::firstOrCreate(
            [
                'user_id'=>$pincode->id,
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
