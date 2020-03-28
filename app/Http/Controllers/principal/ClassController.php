<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables,DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SDB;

class ClassController extends Controller
{
    protected $page;
    //
    public function index(){
        return view('principal.class')->with(['page' => 'kk_classes']);
    }

    public function allClasses(Request  $request ){
        // dd($request->all());
        $this->request = $request->url();
        $db = SDB::db();
        if ($request->ajax()) {
            $table = 'class_table';
            $medium = $request->medium;
            $this->page = $request->page;
            DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (class_id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (class_id),class_name varchar(50) NOT NULL,medium varchar(50) NOT NULL)");

            DB::statement("CREATE TABLE IF NOT EXISTS $db.section (id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (id),`section_name` varchar(50) NOT NULL, `shift_name` varchar(50) NOT NULL,`class_id` int(11) NOT NULL,`class_teacher_id` varchar(10) DEFAULT NULL)");
            $data = DB::table($db.'.class_table')
                        ->where($db.'.class_table.medium',$medium)
                        ->orderBy($db.'.class_table.class_id','DESC')
                        ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                          $btn ='<a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  editBtn"  data-class_name="'.$row->class_name.'" data-class_id="'.$row->class_id.'"><i class="fa fa-edit text-white text-center"></i></a>';
                          $btn .='<a href="javascript:void(0)" class="edit btn btn-danger btn-sm m-1  deleteBtn"  data-class_id="'.$row->class_id.'"><i class="fa fa-trash text-white text-center"></i></a>';
                          
                            if (strpos($this->page, 'kk_subjects') !== false) {
                                $btn .= '<a href="'.url('/principal/subject').'/'.$row->class_id.'" class="edit btn btn-success btn-sm m-1  sectionBtn" data-class_id="'.$row->class_id.'">Subjects</a>';
                            }else if(strpos($this->page, 'kk_exams') !== false){
                                $btn .= '<a href="'.url('/principal/section').'/'.$row->class_id.'?page=create_exam" class="edit btn btn-success btn-sm m-1  sectionBtn" data-class_id="'.$row->class_id.'">Section</a>';
                            }else if(strpos($this->page, 'kk_students') !== false){
                                $btn .= '<a href="'.url('/principal/section').'/'.$row->class_id.'?page=add_students" class="edit btn btn-success btn-sm m-1  sectionBtn" data-class_id="'.$row->class_id.'">Section</a>';
                            }else if(strpos($this->page, 'kk_assign_teach') !== false){
                                $btn .= '<a href="'.url('/principal/section').'/'.$row->class_id.'?page=assign_teacher" class="edit btn btn-success btn-sm m-1  sectionBtn" data-class_id="'.$row->class_id.'">Section</a>';

                            }else{
                                $btn .= '<a href="'.url('/principal/section').'/'.$row->class_id.'?page=section" class="edit btn btn-success btn-sm m-1  sectionBtn" data-class_id="'.$row->class_id.'">Section</a>';
                            }

                            return $btn;
                    })
                    ->addColumn('total_section', function($row){
                        $db = SDB::db();

                        $classes= DB::table($db.'.section')->where($db.'.section.class_id',$row->class_id)->get();
                        return count($classes);
                    })
                    ->addColumn('total_student', function($row){
                        $db = SDB::db();

                        if (strpos($this->page, 'kk_subjects') !== false) {
                            $classes= DB::table($db.'.subject_table')->where($db.'.subject_table.class_id',$row->class_id)->get();
                        }else {
                            $classes= DB::table($db.'.student')->where($db.'.student.class_id',$row->class_id)->get();

                        }
                        return count($classes);
                    })
                    ->rawColumns(['action','total_section','total_student'])
                    ->make(true);
        }
      
        return view('principal/class');
    }


    //add new class method 
    public function addClass(Request $request){
                // dd($request->all());

        $db = SDB::db();
        $table = 'class_table';

        // form validation
        $validation = $request->validate([
            'class_name' => 'required',
            // 'class_name' => 'required|unique:'.$db.'.'.$table.'.class_name',
            'section_name' => 'required',
            'shift_name' => 'required',
        ]);
    
        $uni_chk =  DB::table($db.'.'.$table)->where('class_name',$request->class_name)->first();
    if($uni_chk === null){
        $class_id = DB::table($db.'.'.$table)->insertGetId([
            'class_name' => $request->class_name,
            'medium' => $request->medium,
        ]);

        DB::table($db.'.section')->insert([
            'section_name' => $request->section_name,
            'shift_name' => $request->shift_name,
            'class_id' =>  $class_id,
        ]);
    }else{
            return response()->json(['error' => ['class_name' => 'This Class Name already Exist!']]);
    }
        return response()->json(['success' => 'Class Added Successfully!!']);
    }

    //editClass class 
    public function editClass(Request $request){
        $db = SDB::db();
        
        DB::table($db.'.class_table')->where($db.'.class_table.class_id',$request->class_id)->update([
            'class_name' => $request->class_name,
        ]);
        return response()->json(['success' => 'Class updated Successfully!!']);
    }
    //delete class 
    public function deleteClass(Request $request){
        $db = SDB::db();
        DB::table($db.'.section')->where($db.'.section.class_id',$request->class_id)->delete();
        DB::table($db.'.class_table')->where($db.'.class_table.class_id',$request->class_id)->delete();
        return response()->json(['success' => 'Class Successfully!!']);
    }

}
