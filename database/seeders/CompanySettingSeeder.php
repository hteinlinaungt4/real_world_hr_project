<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
            CompanySetting::create([
                'company_name' => 'T42 Company',
                'company_email' => 't42@gmail.com',
                'company_phone' => '09448977540',
                'company_address' => 'Taunggyi',
                'office_start_time' => '09:00:00',
                'office_end_time' => '18:00:00',
                'break_start_time' => '12:00:00',
                'break_end_time' => '13:00:00',
            ]);

    }
}
