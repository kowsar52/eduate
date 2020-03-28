<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\SDB;
use Illuminate\Http\Request;
use App\Mail\TeacherInfo;
use DB,DataTables;

class ModaratorController extends Controller
{
        //
        public function index(){
            return view('principal.modarator');
        }
    
        public function getModerators(Request $request){
            
            $db = SDB::db();
            if ($request->ajax()) {
                $table = 'moderator';
                DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (id varchar(10) NOT NULL,PRIMARY KEY (id),password varchar(256) NOT  NULL,moderator_name varchar(255) NOT NULL,moderator_type varchar(255) NOT NULL,email varchar(150) NOT NULL,phone_number varchar(20) NOT NULL,image_path TEXT NULL,device_id TEXT NULL)");
    
                $data = DB::table($db.'.'.$table)
                            ->orderBy($db.'.'.$table.'.id','DESC')
                            ->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                              $btn ='<a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  editBtn"   data-id="'.$row->id.'"><i class="fa fa-comment text-white text-center"></i></a>';
                              $btn .='<a href="javascript:void(0)" class="edit btn btn-danger btn-sm m-1  deleteBtn"  data-id="'.$row->id.'"><i class="fa fa-trash text-white text-center"></i></a>';
    
                                return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
            return view('principal.modarator');
        }
    
        public function addModarator(Request $request){
    
              $db = SDB::db();
              // form validation
              $validation = $request->validate([
                "modarator_name" => "required",
                "modarator_type" => "required",
                "email" => "required|email",
                "phone_number" => "required",
              ]);
              $password = Hash::make('11223344');
              $last_mod = DB::table($db.'.moderator')->orderBy($db.'.moderator.id','DESC')->first();
              if(!empty($last_mod)){
                  $last_mod_id = str_replace('mod','',$last_mod->id); //remove SCH from id
                  $new_id = $last_mod_id+1;
              } else{
                  $new_id = 1;
              }
              $user_id = 'mod'.$new_id;
                DB::table($db.'.moderator')->insert([
                    'id' => $user_id,
                    'moderator_name' => $request->modarator_name,
                    'moderator_type' => $request->modarator_type,
                    'email' =>  $request->email,
                    'password' =>  $password,
                    'phone_number' =>  $request->phone_number,
                ]);
    
                Mail::to($request->email)->send(new TeacherInfo($username = $user_id , $request->modarator_name));
              return response()->json(['success' => 'Moderator Added Successfully!!']);
    
        }
    

    
        //delete exam 
        public function deleteModarator(Request $request){

            $db = SDB::db();
            $check = Hash::check($request->password, Auth::user()->password);
            if($check === true){
                DB::statement("DELETE FROM $db.moderator WHERE id = '$request->id'");
                return response()->json(['success' => 'Moderator Deleted Successfully!!']);
            }else{
                return response()->json(['error' => 'Please enter valid Password!']);
    
            }
        }
}