<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //login method 
    public function login(Request $request){

        $validatedData = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required',
            'user_type' => 'required',
        ]);
        
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $role = Auth::user()->user_type;

            if($role === "super_admin"){
                return redirect('admin/dashboard');
            } 
            else if($role === "principal"){
                return redirect('principal/dashboard');
            }
            else if($role === "vice_principal"){
                return redirect('vice_principal/dashboard');
            }
            else if($role === "accountant"){
                return redirect('accountant/dashboard');
            }
            else if($role === "stuff"){
                return redirect('stuff/dashboard');
            }
            else if($role === "student"){
                return redirect('student/dashboard');
            }
              
        }
        return Redirect::to("/");

    }
}
