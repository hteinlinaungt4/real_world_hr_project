<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'=>'admin',
            'nrc_number' => '7/YATAYA(N)/181055',
            'email'=>'admin@gmail.com',
            'gender'=>'male',
            'employee_id'=>'Admin-001',
            'birthday'=>'2001-5-19',
            'Address'=>'Aungban',
            'department_id' => '1',
            'phone'=>'09448977540',
            'password'=> Hash::make('12345678'),
        ]);
        Department::create([
            'title' => 'Web Development',
        ]);
    }
}
