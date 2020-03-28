<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\PrincipalInfo;
use Illuminate\Http\Request;
use App\School;
use App\User;
use DataTables,DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Controllers\xmlapi;

class SuperAdminController extends Controller
{
    //school list display method 
    public function getSchool(Request $request){

        if ($request->ajax()) {
            $data = User::where('user_type','!=','super_admin')
                        ->join('schools','schools.school_id','=','users.school_id')
                        ->orderBy('schools.school_id','DESC')
                        ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm viewBtn" data-school_id="'.$row->school_id.'"><i class="fa fa-eye text-white text-center"></i></a>';
                            return $btn;
                    })
                    ->addColumn('image', function($row){
                        if(!empty( $image_path)){
                           $image_path = '<img src="'.$row->image_path.'" width="100px"/>';
                        }else{
                            $image_path = '<img src="'.url('/').'/uploads/schools/default_school.jpg" width="100px"/>';
                        }
                    return $image_path;
                    })
                    ->addColumn('status', function($row){
                        if($row->account_status === 1){

                            $btn = '<a href="javascript:" class="btn badge badge-success statusBtn" data-id="'.$row->id.'">Active</a>';
                        }else{
                            $btn = '<a href="javascript:" class="btn badge badge-danger statusBtn" data-id="'.$row->id.'">Deactive</a>';
                        }
                            return $btn;
                    })
                    ->addColumn('author', function($row){
                         return $row->name;
                    })
                    ->addColumn('school_id', function($row){
                         return '<span class="font-weight-bold text-uppercase">'.$row->school_id.'</span>';
                    })
                    ->addColumn('school_name', function($row){
                        $school = School::where('school_id',$row->school_id)->first();
                         return $school->school_name;
                    })
                    ->rawColumns(['school_id','action','image','status','author','school_name'])
                    ->make(true);
        }
      
        return view('admin/schools');
    }



    // add new authority/school method 
    public function addSchool(Request $request){

            // form validation
            $validation = $request->validate([
                'school_name' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users',
            ]);

            $password = Hash::make('11223344'); //generate password
            $last_school = School::orderBy('school_id','DESC')->first();
            if(!empty($last_school)){
                $last_school_id = str_replace('sch','',$last_school->school_id); //remove SCH from id
                $new_id = $last_school_id+1;
            } else{
                $new_id = 1;
            }
            
          

            School::insert([
                'school_id' => 'sch'.$new_id,
                'school_name' => $request->school_name,
                'created_at' => Carbon::now(),
            ]);

            //last inserted school id 
            $school_id = School::orderBy('school_id','DESC')->first('school_id');

            $last_principal = User::where('user_type','!=','super_admin')->orderBy('username','DESC')->first();
            if(!empty($last_principal)){
                $last_pricnipal_id = str_replace('pri','',$last_principal->username); //remove SCH from id
                $new_principal_id = $last_pricnipal_id+1;
                $username = 'pri'.$new_principal_id;
            } else{
                $username = "pri1";
            }

            User::insert([
                'name' => $request->name,
                'username' => $username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => $password,
                'school_id' => $school_id->school_id,
                'user_type' => 'principal',
                'created_at' => Carbon::now(),
            ]);
            
            $this->create_db($db = $school_id->school_id); //create new database for school
            Mail::to($request->email)->send(new PrincipalInfo($username, $request->name));
            return response()->json(['success' => 'School Added Successfully!!']);
        
    }

    //active deactive user status
    public function activeDeactive(Request $request){
        $school = User::where('id',$request->id)->first();
        if($school->account_status === 1){
            User::where('id',$request->id)->update([
                'account_status' => 0,
                'updated_at' => Carbon::now(),
            ]);
        }else{
            User::where('id',$request->id)->update([
                'account_status' => 1,
                'updated_at' => Carbon::now(),
            ]);
        }

        return response()->json(['success' => 'School Updated Successfully!!']);
    }

    // schoolDetails method 
    public function schoolDetails(Request $request){
        if($request->ajax()){
            $response = School::where('schools.school_id',$request->school_id)
                        ->join('users','users.school_id','=','schools.school_id')
                        ->first();
            
            return response()->json($response);
        }
    }

    //profile method 
    public function profile(){
        return view('admin/profile');
    }
    
    public function create_db($db){

        if(url('/') === "http://eduate.test"){
            //this code for localhost
            DB::statement("CREATE DATABASE IF NOT EXISTS clevproc_$db");

        }else{
            //this code for cpanel 

            require "create_db/init.php";

            $parameter = [ 'name' => 'clevproc_'.$db];
            $result = $cPanel->execute('uapi', 'Mysql', 'create_database', $parameter);
            if (!$result->status == 1) {
                setE("Cannot create database : {$result->errors[0]}");
            }
        }
    }


}
