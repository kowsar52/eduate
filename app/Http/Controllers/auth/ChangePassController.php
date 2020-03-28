<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class ChangePassController extends Controller
{
    //index method 
    public function index(){
        return view('auth/passwords/changePassword');
    }

    public function changePass(Request $request){
        if($request->ajax()){
            // form validation
            $validation = $request->validate([
                'old_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required',
            ]);
            
            $username = Auth::user()->username;
            $old_pass_check = User::where('username',$username)->first();
            
            if(Hash::check($request->old_password,$old_pass_check->password)){
                if($request->new_password === $request->confirm_password){
                    $new_password = Hash::make($request->new_password);
                    User::where('username',$username)->update([
                        'password' => $new_password,
                    ]);
                    return response()->json(['success' => 'Password Chagne Successfully!']);

                }else{
                    return response()->json(['error' => 'Confirm Paassword does not match.']);
                }
            }else{
                return response()->json(['error' => 'Old Password does not match.']);
            }
        }
       
    }
}
