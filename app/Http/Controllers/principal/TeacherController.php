<?php

namespace App\Http\Controllers\principal;

use Illuminate\Support\Facades\Mail;
use App\Mail\TeacherInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables,DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Http\Controllers\SDB;

class TeacherController extends Controller
{
   
    //school list display method 
    public function getTeacher(Request $request){
        
        $db = SDB::db();
        if ($request->ajax()) {

            //create teacher table
            $table = 'teacher';


            DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (id varchar(10) NOT NULL,PRIMARY KEY (id),`password` varchar(256) NOT NULL,teacher_name varchar(255) NOT NULL,email varchar(150) NOT NULL,phone_number varchar(20) NOT NULL,class_id varchar(100) NULL,subject_id varchar(150) NULL,image_path TEXT NULL,device_id TEXT NULL,created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL)");
                        
            $data = DB::table($db.'.teacher')->orderBy($db.'.teacher.id','DESC')->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm m-1  editBtn" data-id="'.$row->id.'"><i class="fa fa-edit text-white text-center"></i></a>';
                           $btn .= '<a href="'.url('principal/profile/teacher/').'/'.$row->id.'" class="edit btn btn-warning btn-sm m-1  viewBtn" data-id="'.$row->id.'"><i class="fa fa-eye text-white text-center"></i></a>';
                           $btn .= '<a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  messageBtn" data-id="'.$row->id.'"><i class="fa fa-comment text-white text-center"></i></a>';
                           $btn .= '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm m-1  deleteBtn" data-id="'.$row->id.'"><i class="fa fa-trash text-white text-center"></i></a>';
                            return $btn;
                    })
                    ->addColumn('image', function($row){
                        if(!empty($row->image_path)){
                            $image_path = '<img src="'.$row->image_path.'" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                        }else{
                            $image_path = '<img src="'.url('/').'/uploads/teachers/demo.jpg" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                        }
                            return $image_path;
                    })
                    ->addColumn('teacher_id', function($row){
                         return '<span class="font-weight-bold text-uppercase">'.$row->id.'</span>';
                    })
                    ->addColumn('assign_class', function($row){
                        if(!empty($row->class_id)){
                            $db = SDB::db();
                            $data = DB::table($db.'.class_table')->where($db.'.class_table.class_id',$row->class_id)->first();
                            $class = $data->class_name;
                        }else{
                            $class = '<span class="badge badge-danger">Not Assinged</span>';
                        }
                         return $class;
                    })
                    ->addColumn('assign_subject', function($row){
                        if(!empty($row->subject_id)){
                            $db = SDB::db();
                            $data = DB::table($db.'.subject_table')->where($db.'.subject_table.subject_id',$row->subject_id)->first();
                            $class = $data->subject_name;
                        }else{
                            $class = '<span class="badge badge-danger">Not Assinged</span>';
                        }
                         return $class;
                    })
                    ->rawColumns(['teacher_id','action','image','assign_class','assign_subject'])
                    ->make(true);
        }
        $class = DB::table($db.'.class_table')->orderBy('class_id','DESC')->get();
        $subject = DB::table($db.'.subject_table')->orderBy('subject_id','DESC')->get();
        return view('principal/teacher')->with(['classes' => $class, 'subjects' => $subject]);
    }



    // a method 
    public function addTeacher(Request $request){
        
       
        //create teacher table
        $table = 'teacher';
        $db = SDB::db();

            // form validation
            $validation = $request->validate([
                'teacher_name' => 'required',
                'phone_number' => 'required',
                'email' => 'required|email',
            ]);
 

          
            $password = Hash::make('11223344'); //generate password
        if($request->action === "create"){
            $last_teacher = DB::table($db.'.'.$table)->orderBy('id','DESC')->first();
            if(!empty($last_teacher)){
                $last_teacher_id = str_replace('teach','',$last_teacher->id); //remove SCH from id
                $new_id = $last_teacher_id+1;
            } else{
                $new_id = 1;
            }

            DB::table($db.'.'.$table)->insert([
                'id' => 'teach'.$new_id,
                'email' => $request->email,
                'password' => $password,
                'teacher_name' => $request->teacher_name,
                'phone_number' => $request->phone_number,
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'created_at' => Carbon::now(),
            ]);
            Mail::to($request->email)->send(new TeacherInfo($username = 'teach'.$new_id , $request->teacher_name));
            return response()->json(['success' => 'Teacher Added Successfully!!']);
        }else if($request->action === "edit"){
            DB::table($db.'.'.$table)->where($db.'.'.$table.'.id',$request->id)->update([
                'email' => $request->email,
                'teacher_name' => $request->teacher_name,
                'phone_number' => $request->phone_number,
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'updated_at' => Carbon::now(),
            ]);
            return response()->json(['success' => 'Teacher Updated Successfully!!']);
        }
            
        
    }
    //get edit data
    public function editData(Request $request){
        $db = SDB::db();

        $data = DB::table($db.'.teacher')->where($db.'.teacher.id',$request->id)->first();
        return response()->json($data);
    }

    //active deactive user status
    public function deleteTeacher(Request $request){
 
        //create teacher table
        $table = 'teacher';
        $db = SDB::db();
        $check = Hash::check($request->password, Auth::user()->password);
        if($check === true){
            DB::statement("DELETE FROM $db.teacher WHERE id = '$request->id'");
            return response()->json(['success' => 'Teacher Deleted Successfully!!']);
        }else{
            return response()->json(['error' => 'Please enter valid Password!']);

        }
    }


}
