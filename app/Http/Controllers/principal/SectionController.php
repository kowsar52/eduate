<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables,DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SDB;

class SectionController extends Controller
{
    //index method 
    public function index($id){
        $db = SDB::db();
        $teachers = DB::table($db.'.teacher')->orderBy($db.'.teacher.id','desc')->get();
        return view('principal.section')->with(['class_id'=>$id,'teachers' => $teachers]);
    }


    //get class wise section 
    public function getSection(Request $request){

        $page = $_GET['page'];
        $db = SDB::db();
        $sections= DB::table($db.'.section')->where($db.'.section.class_id',$request->class_id)->get();
        $res = "";
        $i = 1;
        foreach($sections as $section){
            if(!empty($section->class_teacher_id)){
                $class_teacher_info = DB::table($db.'.teacher')->where($db.'.teacher.id',$section->class_teacher_id)->first('teacher_name');
                $class_teacher = $class_teacher_info->teacher_name;
            }else{
                $class_teacher = '<span class="badge badge-danger">Not Assinged</span>';
            }
            $res .= '<tr>
                <th scope="row">'.$i.'</th>
                <td>'.$section->section_name.'</td>
                <td>'.$section->shift_name.'</td>
                <td>'.$class_teacher.'</td>
                <td>
                <a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  editBtn"  data-class_id="'.$section->class_id.'" data-id="'.$section->id.'"><i class="fa fa-edit text-white text-center"></i></a>
                <a href="javascript:void(0)" class="edit btn btn-danger btn-sm m-1  deleteBtn"  data-class_id="'.$section->class_id.'" data-id="'.$section->id.'"><i class="fa fa-trash text-white text-center"></i></a>
                ';
            if($page === 'create_exam'){
                $res .= '<a href="'.url('principal/getExams?section_id=').$section->id.'" class="edit btn btn-warning btn-sm m-1" >Exam</i></a>
                </td>
            </tr>';
            }else if($page === 'assign_teacher'){
                $res .= '<a href="'.url('principal/getAssignTeacher?section_id=').$section->id.'" class="edit btn btn-warning btn-sm m-1" >Assign Teacher</i></a>
                </td>
            </tr>';
            }else if($page === 'add_students'){
                $res .= '<a href="'.url('principal/getStudents?section_id=').$section->id.'" class="edit btn btn-warning btn-sm m-1" >Students</i></a>
                </td>
            </tr>';
            }else{
                $res .= '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm m-1  assignBtn"  data-class_id="'.$section->class_id.'" data-id="'.$section->id.'">Assign Teacher</i></a>
                </td>
            </tr>';
            }

            $i = $i+1;
        }
        return response()->json($res);
    }
    //edit data section 
    public function editData(Request $request){

        $db = SDB::db();

        $data = DB::table($db.'.section')->where($db.'.section.id',$request->id)->first();
        return response()->json($data);
    }

        //add new section method 
        public function addSection(Request $request){
            $db = SDB::db();
            // form validation
            $validation = $request->validate([
                'section_name' => 'required',
                'shift_name' => 'required',
            ]);
            $check = DB::table($db.'.section')
                    ->where($db.'.section.class_id',$request->class_id)
                    ->where($db.'.section.section_name',$request->section_name)
                    ->first();

            if($request->action === "edit"){
                DB::table($db.'.section')->where($db.'.section.id',$request->section_id)->update([
                    'section_name' => $request->section_name,
                    'shift_name' => $request->shift_name,
                    'class_id' =>  $request->class_id,
                ]);
            }else{
                if(empty($check)){
                    DB::table($db.'.section')->insert([
                        'section_name' => $request->section_name,
                        'shift_name' => $request->shift_name,
                        'class_id' =>  $request->class_id,
                    ]);
                }else{
                    return response()->json(['error' => ['section_name' => 'Section Exists!!'],'class_id'=>$request->class_id]);
                }

            }

    
            return response()->json(['success' => 'Section Added Successfully!!','class_id'=>$request->class_id]);
        }


        //assignTeacher section 
        public function assignTeacher(Request $request){

            $db = SDB::db();
            // form validation
            $validation = $request->validate([
                'class_teacher_id' => 'required',
            ]);
    
            DB::table($db.'.section')->where($db.'.section.id',$request->section_id)->update([
                'class_teacher_id' => $request->class_teacher_id,
            ]);
    
            return response()->json(['success' => 'Teacher Assign Successfully!!','class_id'=>$request->class_id]);
        }

        //delete section 
        public function deleteSection(Request $request){
            $db = SDB::db();
            DB::table($db.'.section')->where('id',$request->id)->delete();
            return response()->json(['success' => 'Section Added Successfully!!','class_id'=>$request->class_id]);
        }
}
