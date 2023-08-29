<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanySetting;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    //
    public function show($id){
        $setting=CompanySetting::findOrFail($id);
        return view('company_setting.show',compact('setting'));
    }
    public function edit($id){
        $setting=CompanySetting::findOrFail($id);
        return view('company_setting.edit',compact('setting'));
    }

    public function update($id,UpdateCompanySetting $request){
        $data=[
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_phone' => $request->company_phone,
            'company_address' => $request->company_address,
            'office_start_time' => $request->office_start_time,
            'office_end_time' => $request->office_end_time,
            'break_start_time' => $request->break_start_time,
            'break_end_time' => $request->break_end_time,
        ];

        CompanySetting::where('id',$id)->update($data);
        return redirect()->route('company_setting.show',1)->with(['successmsg' => 'You are Updated Successfully!']);


    }
}
