<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\CheckinCheckout;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CheckinCheckOutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users=User::all();
        foreach ($users as $user) {
            $periods = CarbonPeriod::create('2020-01-01', '2020-12-31');
            foreach ($periods as $period) {
                $checkincheckout=new CheckinCheckout();
                $checkincheckout->user_id = $user->id;
                $checkincheckout->checkin_time=Carbon::parse( $period->format('Y-m-d').' '.'09:00:00')->subMinutes(rand(1,55));
                $checkincheckout->checkout_time=Carbon::parse($period->format('Y-m-d').' '.'18:00:00')->subMinutes(rand(1,55));
                $checkincheckout->date=$period;
                $checkincheckout->save();
            }

        }
    }
}
