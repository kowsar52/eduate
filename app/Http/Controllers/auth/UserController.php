<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SDB;
use Illuminate\Http\Request;
use App\User;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
{
    //login method 
    public function login(Request $request){

        $validatedData = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required',
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
            // else if($role === "vice_principal"){
            //     return redirect('vice_principal/dashboard');
            // }
            // else if($role === "accountant"){
            //     return redirect('accountant/dashboard');
            // }
            // else if($role === "stuff"){
            //     return redirect('stuff/dashboard');
            // }
            // else if($role === "student"){
            //     return redirect('student/dashboard');
            // }
              
        }
        return back();
    }

    
    //all school user login 
    public function userLogin(Request $request){

        $db = 'clevproc_'.$request->school_id;//dattabase

        $validatedData = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required',
            'user_type' => 'required',
            'school_id' => 'required',
        ]);
        
        if($request->user_type === "teacher"){
            session_start();
            //teacher table
            $table = "teacher";
            $user = DB::table($db.'.'.$table)->where($db.'.'.$table.'.id',$request->username)->first();
            $password_chk = Hash::check($request->password, $user->password);
            if($password_chk === true){
                $_SESSION["db"] = $db;
                $_SESSION["user"] = $user->id;
                $_SESSION["school_id"] = str_replace('clevproc_','',$db);
                return redirect('stuff/dashboard');
            }else{
                $error = "Password Does not match.";
                return $error;
            }
        }
        else if($request->user_type === "principal"){
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                // Authentication passed...
                $role = Auth::user()->user_type;
    
                if($role === "principal"){
                    return redirect('principal/dashboard');
                }
                  
            }
        }

    }   
    public function userLogout(){
        session_start();
        unset($_SESSION["user"]);
        $_SESSION["logout_msg"] = "Logout Successfully";
        return redirect('/');
    }
}
