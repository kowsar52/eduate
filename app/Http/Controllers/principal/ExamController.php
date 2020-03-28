<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SDB;
use Illuminate\Http\Request;
use DB,DataTables;

class ExamController extends Controller
{
        //
    public function index(){
        return view('principal.class')->with(['page' => 'kk_exams']);
    }

    public function getExams(Request $request){
        $section_id = $_GET['section_id'];
        $db = SDB::db();
        if ($request->ajax()) {
            $table = 'exam';
            DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (id),exam_type varchar(50) NOT NULL,exam_name TEXT NOT NULL,subject_id varchar(10) NOT NULL,subject_name TEXT NOT NULL,section_id varchar(50) NOT NULL,class_id varchar(50) NOT NULL,create_date DATE NOT NULL,create_time TEXT NOT NULL,result_status BOOLEAN default 0,marks int default 0)");

            $data = DB::table($db.'.'.$table)
                        ->where($db.'.'.$table.'.section_id',$section_id)
                        ->orderBy($db.'.'.$table.'.id','DESC')
                        ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                          $btn ='<a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  editBtn"   data-id="'.$row->id.'"><i class="fa fa-edit text-white text-center"></i></a>';
                          $btn .='<a href="javascript:void(0)" class="edit btn btn-danger btn-sm m-1  deleteBtn"  data-id="'.$row->id.'"><i class="fa fa-trash text-white text-center"></i></a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $class_id = DB::table($db.'.section')->where($db.'.section.id',$section_id)->first();
        $subjects = DB::table($db.'.subject_table')->where($db.'.subject_table.class_id',$class_id->class_id)->orderBy($db.'.subject_table.subject_id','desc')->get();
        return view('principal.exams')->with(['section_id' => $section_id, 'subjects' => $subjects]);
    }

    public function addexam(Request $request){

          $db = SDB::db();
          // form validation
          $validation = $request->validate([
            "exam_type" => "required",
            "exam_name" => "required",
            "section_id" => "required",
            "subject_id" => "required",
            "create_date" => "required",
            "create_time" => "required",
            "marks" => "required",
          ]);
          $subject_name = DB::table($db.'.subject_table')->where($db.'.subject_table.subject_id',$request->subject_id)->first();
          $section = DB::table($db.'.section')->where($db.'.section.id',$request->section_id)->first();
          if($request->action === "edit"){
              DB::table($db.'.exam')->where($db.'.exam.id',$request->exam_id)->update([
                  'exam_type' => $request->exam_type,
                  'exam_name' => $request->exam_name,
                  'subject_id' =>  $request->subject_id,
                  'subject_name' =>  $subject_name->subject_name,
                  'section_id' =>  $request->section_id,
                  'class_id' =>  $section->class_id,
                  'create_date' =>  $request->create_date,
                  'create_time' =>  $request->create_time,
                  'marks' =>  $request->marks,
              ]);
          }else{
            DB::table($db.'.exam')->insert([
                'exam_type' => $request->exam_type,
                'exam_name' => $request->exam_name,
                'subject_id' =>  $request->subject_id,
                'subject_name' =>  $subject_name->subject_name,
                'section_id' =>  $request->section_id,
                'class_id' =>  $section->class_id,
                'create_date' =>  $request->create_date,
                'create_time' =>  $request->create_time,
                'marks' =>  $request->marks,
            ]);
          }

  
          return response()->json(['success' => 'Exam Added Successfully!!']);

    }

    //get edit dara
    public function getEditData(Request $request){
        $db = SDB::db();
        $data = DB::table($db.'.exam')->where($db.'.exam.id',$request->id)->first();
        return response()->json($data);
    }

    //delete exam 
    public function examDelete(Request $request){
        $db = SDB::db();
        DB::table($db.'.exam')->where('id',$request->id)->delete();
        return response()->json(['success' => 'exam delete Successfully!!']);
    }
    
}
