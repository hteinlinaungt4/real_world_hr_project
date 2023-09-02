<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;

class ProfileController extends Controller
{
    //
    function optionlogin(Request $request){
    $request->validate([
        'email' => 'required',
    ]);
      $email=$request->email;
      return view('optionlogin',compact('email'));
    }
    function loginpage(){
        return view('login');
    }
    public function profile(){
        // $id=Auth::user()->id;
        // $figureprint=DB::table('webauthn_credentials')->where('user_id',$id)->get();
        // dd($figureprint);
        return view('Profile');
    }
}
