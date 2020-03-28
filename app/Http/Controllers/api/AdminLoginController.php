<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Carbon\Carbon;

class AdminLoginController extends Controller
{
    //admin / principla login method 
    public function adminLogin(Request $request){
        $table= $request->table;
		$password= $request->password;
		$id= $request->user_id;
		$device_id= $request->device_id;
		
		if($table=="Admin"){

            $user =User::where('username',$id)->where('user_type','super_admin')->first();
           
		}
		else if($table=="Authority"){
            $school_id= $request->school_id;
            $user =User::where('username',$id)->where('school_id',$school_id)->first();
		}
		
		
	
		 
		if($user){
	 
			 if($table=="Admin"){ //admin login check
                if(Hash::check($password, $user->password)){
                    $response="success";
                }else{
                    $response="Incorrect Password";
                }	 
			 } 
			 else if($table=="Authority"){ //principal login check
			 	if($user->account_status === 1){

                    if(Hash::check($password, $user->password)){
                        $response="success ".$user->user_type; 
                        User::where('username',$id)->update([
                            'device_id' => $device_id,
                            'updated_at' => Carbon::now(),
                        ]);
                    }else{
                        $response="Incorrect Password";
                    }	
			 	}
			 	else{

			 		$response="de-active";
			 	}
			 	 
			 }
			
			 	
		}
		else{

			$response="Invalid User";
		} 

    return response()->json($response);
    }


}
