<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SDB;
use DataTables,DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index(){
        return view('principal.class')->with(['page' => 'kk_students']);
    }

    public function getStudents(Request $request){
        $section_id = $_GET['section_id'];
        $db = SDB::db();
        if ($request->ajax()) {
            $table = 'student';
            DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (id varchar(10) NOT NULL,PRIMARY KEY (id),password varchar(256) NOT NULL,student_name varchar(256) NOT NULL,email varchar(150) NOT NULL,phone_number varchar(20) NOT NULL,class_id varchar(100) NOT NULL,section_id varchar(100) NOT NULL,image_path TEXT NULL,gender varchar(256) NULL,birth_date varchar(256) NULL,religion varchar(256) NULL,blood_group varchar(256) NULL,class_roll INT,father_name varchar(256) NULL,mother_name varchar(256) NULL,father_contact varchar(256) NULL,mother_contact varchar(256) NULL,father_occupation varchar(256) NULL,mother_occupation varchar(256) NULL,alt_email varchar(256) NULL,emergency_contact varchar(256) NULL,present_address varchar(256) NULL,permanent_address varchar(256) NULL,device_id TEXT NULL)");

            $data = DB::table($db.'.'.$table)
                        ->where($db.'.'.$table.'.section_id',$section_id)
                        ->orderBy($db.'.'.$table.'.id','DESC')
                        ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                          $btn ='<a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  editBtn"   data-id="'.$row->id.'"><i class="fa fa-edit text-white text-center"></i></a>';
                          $btn .='<a href="'.url('/principal/sendMessage/student/').'/'.$row->id.'" class="edit btn btn-primary btn-sm m-1  messageBtn"  data-id="'.$row->id.'"><i class="fa fa-comment text-white text-center"></i></a>';
                          $btn .='<a href="'.url('/principal/profile/student/').'/'.$row->id.'" class="edit btn btn-warning btn-sm m-1  viewBtn"  data-id="'.$row->id.'"><i class="fa fa-eye text-white text-center"></i></a>';
                          $btn .='<a href="javascript:void(0)" class="edit btn btn-danger btn-sm m-1  deleteBtn"  data-id="'.$row->id.'"><i class="fa fa-trash text-white text-center"></i></a>';

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
        return view('principal.students')->with(['section_id' => $section_id]);
    }

    public function addStudent(Request $request)
    {

          $db = SDB::db();
          $section = DB::table($db.'.section')->where($db.'.section.id',$request->section_id)->first();
          $password = Hash::make('11223344'); //generate password

          if($request->type === "csv"){
            // form validation
            $validator = $request->validate([
                "files" => "required|max:4097152",
            ]);


                $file = $request->file('files');
                // File Details 
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $tempPath = $file->getRealPath();
                $fileSize = $file->getSize();
                $mimeType = $file->getMimeType();

                        // Valid File Extensions
                    $valid_extension = array("csv");
                    // File upload location
                    $location = 'uploads/students/csv';
                // Check file extension
                if(in_array(strtolower($extension),$valid_extension)){
                    // Upload file
                    $file->move($location,$filename);
          
                    // Import CSV to Database
                    $filepath = public_path($location."/".$filename);
          
                    // Reading file
                    $file = fopen($filepath,"r");
          
                    $importData_arr = array();
                    $i = 0;
          
                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                       $num = count($filedata );
                       
                       // Skip first row (Remove below comment if you want to skip the first row)
                       if($i == 0){
                          $i++;
                          continue; 
                       }
                       for ($c=0; $c < $num; $c++) {
                          $importData_arr[$i][] = $filedata [$c];
                       }
                       $i++;
                    }
                    fclose($file);
                    // Insert to MySQL database
                    foreach($importData_arr as $data)
                    {
                        $check = DB::table($db.'.student')->where($db.'.student.id',$data[0])->first();
                        if(!empty($check)){
                            DB::table($db.'.student')->where($db.'.student.id',$data[0])->update([
                                'id' => $data[0],
                                'password' => $password,
                                'student_name' => $data[1],
                                'email' => $data[2],
                                'phone_number' => $data[3],
                                'section_id' =>  $request->section_id,
                                'class_id' =>  $section->class_id,
                            ]);
                        }else{
                            DB::table($db.'.student')->insert([
                                'id' => $data[0],
                                'password' => $password,
                                'student_name' => $data[1],
                                'email' => $data[2],
                                'phone_number' => $data[3],
                                'section_id' =>  $request->section_id,
                                'class_id' =>  $section->class_id,
                            ]);
                        }


          
                    }
            }else{
                return response()->json(['error' => ['files' => 'File must be CSV extention!!']]);
             }
        }else{
            
            
            if($request->action === "create"){
                $validator = $request->validate([
                    "id" => "required",
                    "email" => "required|email",
                    "student_name" => "required",
                    "phone_number" => "required",
                ]);
                $check = DB::table($db.'.student')->where($db.'.student.id',$request->id)->first();
                if(!empty($check)){
                    DB::table($db.'.student')->where($db.'.student.id',$request->id)->update([
                        'id' => $request->id,
                        'password' => $password,
                        'student_name' => $request->student_name,
                        'email' => $request->email,
                        'phone_number' => $request->phone_number,
                        'section_id' =>  $request->section_id,
                        'class_id' =>  $section->class_id,
                    ]);
                }else{
                    DB::table($db.'.student')->insert([
                        'id' => $request->id,
                        'password' => $password,
                        'student_name' => $request->student_name,
                        'email' => $request->email,
                        'phone_number' => $request->phone_number,
                        'section_id' =>  $request->section_id,
                        'class_id' =>  $section->class_id,
                    ]);
                }

                return response()->json(['success' => 'Student Added Successfully!!']);

            }else if($request->action === "edit"){
        
                    DB::table($db.'.student')->where($db.'.student.id',$request->old_id)->update([
                        // 'id' => $request->id,
                        'password' => $password,
                        'student_name' => $request->student_name,
                        'email' => $request->email,
                        'phone_number' => $request->phone_number,
                        'section_id' =>  $request->section_id,
                        'class_id' =>  $section->class_id,
                    ]);

            return response()->json(['success' => 'Student Updated Successfully!!']);

        }
    }
         return response()->json(['success' => 'Student Added Successfully!!']);

    }

    //get edit dara
    public function getEditData(Request $request){
        $db = SDB::db();
        $data = DB::table($db.'.student')->where($db.'.student.id',$request->id)->first();
        return response()->json($data);
    }

    //delete  
    public function deletStudent(Request $request){
        $db = SDB::db();
        DB::table($db.'.student')->where($db.'.student.id',$request->id)->delete();
        return response()->json(['success' => 'Student delete Successfully!!']);
    }

    //export data 
    public function exportStudent($section_id){

      return Excel::download(new StudentExport($section_id), 'sec_'.$section_id.'_students.csv');
    }

    
}
