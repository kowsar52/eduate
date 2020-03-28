<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\SDB;
use DB,DataTables;

class SubjectController extends Controller
{
    //index method
    public function index(){
        return view('principal.class')->with(['page' => 'kk_subjects']);
    }

    public function getSubjectPage ($id){
        return view('principal.subject')->with(['class_id' => $id]);
    }
    public function getSubject (Request $request){
        $class_id = $_GET['class_id'];
        if ($request->ajax()) {
            $db = SDB::db();
            $table = 'subject_table';
            DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (subject_id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (subject_id),subject_name varchar(255) NOT NULL,class_id varchar(10) NULL)");

            $data = DB::table($db.'.'.$table)
                        ->where($db.'.'.$table.'.class_id',$class_id)
                        ->orderBy($db.'.'.$table.'.subject_id','DESC')
                        ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                          $btn ='<a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  editBtn"  data-subject_name="'.$row->subject_name.'" data-subject_id="'.$row->subject_id.'"><i class="fa fa-edit text-white text-center"></i></a>';
                          $btn .='<a href="javascript:void(0)" class="edit btn btn-danger btn-sm m-1  deleteBtn"  data-subject_id="'.$row->subject_id.'"><i class="fa fa-trash text-white text-center"></i></a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('principal/subject');
    }

    public function addSubject(Request $request){
        $db = SDB::db();
        // form validation
        $validation = $request->validate([
            'subject_name' => 'required',
        ]);

        if($request->action === "edit"){
            DB::table($db.'.subject_table')->where($db.'.subject_table.subject_id',$request->subject_id)->update([
                'subject_name' => $request->subject_name,
                'class_id' =>  $request->class_id,
            ]);
            return response()->json(['success' => 'Subject Updated Successfully!!']);

        }else{
            DB::table($db.'.subject_table')->insert([
                'subject_name' => $request->subject_name,
                'class_id' =>  $request->class_id,
            ]);
            return response()->json(['success' => 'Subject Added Successfully!!']);

        }
    }

    //delete subject
    public function deleteSubject(Request $request){
        $db = SDB::db();
        DB::table($db.'.subject_table')->where($db.'.subject_table.subject_id',$request->subject_id)->delete();
        return response()->json(['success' => 'Subject Delete Successfully!!']);
    }
}
