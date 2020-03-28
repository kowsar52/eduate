<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SDB;
use Illuminate\Http\Request;
use DB,DataTables;

class OtherController extends Controller
{
    //get all students 
    public function getAllStudents(Request $request){
        
        $db = SDB::db();
        if ($request->ajax()) {
            $table = 'student';
            DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (id varchar(10) NOT NULL,PRIMARY KEY (id),password varchar(256) NOT NULL,student_name varchar(256) NOT NULL,email varchar(150) NOT NULL,phone_number varchar(20) NOT NULL,class_id varchar(100) NOT NULL,section_id varchar(100) NOT NULL,image_path TEXT NULL,gender varchar(256) NULL,birth_date varchar(256) NULL,religion varchar(256) NULL,blood_group varchar(256) NULL,class_roll INT,father_name varchar(256) NULL,mother_name varchar(256) NULL,father_contact varchar(256) NULL,mother_contact varchar(256) NULL,father_occupation varchar(256) NULL,mother_occupation varchar(256) NULL,alt_email varchar(256) NULL,emergency_contact varchar(256) NULL,present_address varchar(256) NULL,permanent_address varchar(256) NULL,device_id TEXT NULL)");

            $data = DB::table($db.'.'.$table)
                        ->orderBy($db.'.'.$table.'.id','DESC')
                        ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                          $btn ='<a href="'.url('/principal/sendMessage/student/').'/'.$row->id.'" class="edit btn btn-primary btn-sm m-1  messageBtn"  data-id="'.$row->id.'"><i class="fa fa-comment text-white text-center"></i></a>';
                          $btn .='<a href="'.url('/principal/profile/student/').'/'.$row->id.'" class="edit btn btn-warning btn-sm m-1  viewBtn"  data-id="'.$row->id.'"><i class="fa fa-eye text-white text-center"></i></a>';

                            return $btn;
                    })
                    ->addColumn('image', function($row){
                          
                          if(!empty($row->image_path)){
                            $image_path = '<img src="'.$row->image_path.'" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                        }else{
                            $image_path = '<img src="'.url('/').'/uploads/students/demo_student.jpg" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                        }
                            return $image_path;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        return view('principal.Allstudents');
    }
}
