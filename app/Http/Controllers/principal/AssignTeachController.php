<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SDB;
use Illuminate\Http\Request;
use DB;

class AssignTeachController extends Controller
{
    //index method
    public function index(){
        return view('principal.class')->with(['page' => 'kk_assign_teach']);
    }

    public function getAssignTeacher(){
        $section_id = $_GET['section_id'];
        $db = SDB::db();
        $table = "subject_assigned_table";
        DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (ass_id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (ass_id),class_name varchar(255) NOT NULL,teacher_name varchar(255) NOT NULL,subject_name varchar(255) NOT NULL,class_id int NOT NULL,section_id int NOT NULL,teacher_id varchar(255) NOT NULL,subject_id int NOT NULL,start_time TIME NULL,end_time TIME NULL,day varchar(50) NULL,duration varchar(50) NULL)");
        
        $section = DB::table($db.'.section')->where($db.'.section.id',$section_id)->first();
        $class = DB::table($db.'.class_table')->where($db.'.class_table.class_id',$section->class_id)->first();
        $subjects = DB::table($db.'.subject_table')->where($db.'.subject_table.class_id',$section->class_id)->get();
        $teachers = DB::table($db.'.teacher')->orderBy($db.'.teacher.id',"DESC")->get();

        return view('principal.assignTeacher')->with(['section' => $section,'class' => $class,'subjects' => $subjects, 'teachers' => $teachers]);
    }


    public function saveAssignTeacher(Request $request){
        $db = SDB::db();
        $table = "subject_assigned_table";
        // form validation
        $validation = $request->validate([
          "teacher_id" => "required",
          "start_time" => "required",
          "duration" => "required",
          "subject_id" => "required",
          "day" => "required",
        ]);

        $section = DB::table($db.'.section')->where($db.'.section.id',$request->section_id)->first();
        $class = DB::table($db.'.class_table')->where($db.'.class_table.class_id',$section->class_id)->first();
        $subjects = DB::table($db.'.subject_table')->where($db.'.subject_table.subject_id',$request->subject_id)->first();
        $teacher = DB::table($db.'.teacher')->where($db.'.teacher.id',$request->teacher_id)->first();

        //make end time 
        $end_time= "";
        $time = strtotime($request->start_time);
        $start_time = date("H:i", strtotime($request->start_time));
        $end_time = date("H:i", strtotime('+'.$request->duration.' minutes', $time));
        if($request->action === "create"){
            DB::table($db.'.'.$table)->insert([
                'class_name' => $class->class_name,
                'teacher_name' => $teacher->teacher_name,
                'subject_name' =>  $subjects->subject_name,
                'class_id' =>  $class->class_id,
                'section_id' =>  $request->section_id,
                'teacher_id' =>  $request->teacher_id,
                'subject_id' =>  $request->subject_id,
                'duration' =>  $request->duration,
                'start_time' =>  $start_time,
                'end_time' =>  $end_time,
                'day' =>  $request->day,
            ]);
            return response()->json(['success' => 'Teacher Assign  Successfully!!']);

        }else if($request->action === "edit"){
            DB::table($db.'.'.$table)->where($db.'.'.$table.'.ass_id',$request->ass_id)->update([
                'class_name' => $class->class_name,
                'teacher_name' => $teacher->teacher_name,
                'subject_name' =>  $subjects->subject_name,
                'class_id' =>  $class->class_id,
                'section_id' =>  $request->section_id,
                'teacher_id' =>  $request->teacher_id,
                'subject_id' =>  $request->subject_id,
                'duration' =>  $request->duration,
                'start_time' =>  $start_time,
                'end_time' =>  $end_time,
                'day' =>  $request->day,
            ]);
            return response()->json(['success' => 'Teacher Assign Updated Successfully!!']);
        }
        

    }


    //get edit data
    public function editData(Request $request){

        $db = SDB::db();
        $table = "subject_assigned_table";
       $data = DB::table($db.'.'.$table)->where($db.'.'.$table.'.ass_id',$request->ass_id)->first();
        return response()->json($data);
    }



    public function getAssignData(){
        $section_id = $_GET['section_id'];
        $db = SDB::db();

        $section = DB::table($db.'.section')->where($db.'.section.id',$section_id)->first();
        $class = DB::table($db.'.class_table')->where($db.'.class_table.class_id',$section->class_id)->first();
        $subjects = DB::table($db.'.subject_table')->where($db.'.subject_table.class_id',$section->class_id)->get();

        $html = "";
        foreach($subjects as $subject){
            $assign = DB::table($db.'.subject_assigned_table')->where($db.'.subject_assigned_table.section_id',$section_id)->where($db.'.subject_assigned_table.subject_id',$subject->subject_id)->get();
            $td = "";
            foreach($assign as $value){
                $td .='<tr>
                    <th scope="row">'.$value->teacher_name.'</th>
                    <td>'.$value->day.'</td>
                    <td>'.$value->start_time.'</td>
                    <td>'.$value->end_time.'</td>
                    <td>
                    <button class="btn  btn-success editBtn btn-sm" data-ass_id="'.$value->ass_id.'"><i class="fa fa-edit"></i></button>
                    <button class="btn  btn-danger deleteBtn btn-sm" data-ass_id="'.$value->ass_id.'"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>';
                }
            $html .= '
            <div class="card mb-2" style="">
            <div class="card-body">
              <h6 class="card-title text-center">'.$subject->subject_name.'</h6>
              <table class="table border">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Teacher</th>
                    <th scope="col">Day</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>'.$td.'</tbody>
              </table>
              <button data-subject_id="'.$subject->subject_id.'" class="btn btn-warning float-right AddModalBtn" >Add New</button>
            </div>
          </div> 
            ';
        }
        if($html === ""){
            $empty_html= '<p class="text-center text-warning">No Subject Added Yet!</p>';
            return response()->json($empty_html);
        }else{
            return response()->json($html);
        }
     
    }


    public function assignTechDelete(Request $request){
        $db = SDB::db();
        $assign = DB::table($db.'.subject_assigned_table')->where($db.'.subject_assigned_table.ass_id',$request->ass_id)->delete();
        return response(['success' => "Teacher Assign Deleted Successfully!"]);
    }
}
