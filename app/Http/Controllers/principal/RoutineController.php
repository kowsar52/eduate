<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SDB;
use Illuminate\Http\Request;
use DB,DataTables,Image;

class RoutineController extends Controller
{
    //index 
    public function index(Request $request){
        $db = SDB::db();
        if ($request->ajax()) {
            $table = 'routine';
            $routine_type = $_GET['routine_type'];
            $this->page = $request->page;
            DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (id),section_id varchar(20) NOT NULL,routine_type varchar(20) NOT NULL,exam_type varchar(20) NULL,medium varchar(20) NOT NULL,class_id varchar(20) NOT NULL,file_type varchar(20) NULL,file_path TEXT NULL,create_date DATE NOT NULL)");

            $data = DB::table($db.'.routine')
                        ->where($db.'.routine.routine_type',$routine_type)
                        ->orderBy($db.'.routine.id','DESC')
                        ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                          $btn ='<a href="javascript:void(0)" class="edit btn btn-danger btn-sm m-1  deleteBtn"  data-id="'.$row->id.'"><i class="fa fa-trash text-white text-center"></i></a>';
                            return $btn;
                    })
                    ->addColumn('image', function($row){

                        if($row->file_type === "pdf"){
                            $img = '<img src="'.url('/BackendAssets/img/icon/pdf.png').'" height="50px" width="50px"/>';
                        }else{
                            $img = '<img src="'.url('/BackendAssets/img/icon/image.png').'" height="50px" width="50px"/>';
                        }
                        return $img;
                    })
                    ->addColumn('download', function($row){

                            $link = '<a  target="_blank" class="btn badge badge-success" href="'.url('principal/routine/downlaod').'/'.$row->id.'">Download</a>';
                        return $link;
                    })
                    ->rawColumns(['action','image','download'])
                    ->make(true);
        }
        $classes = DB::table($db.'.class_table')->get();
        return view('principal.routine')->with(['classes' => $classes]);
    }

    //get section by class 
    public function getSection(Request $request){
        $db = SDB::db();
        $section = DB::table($db.'.section')->where($db.'.section.class_id',$request->class_id)->get();
        $option = '<option value="">Choose Class</option>';
        foreach($section as $data){
            $option .='<option value="'.$data->id.'">'.$data->section_name.'</option>';
        }
         return response()->json($option, 200);
    }


    public function addRoutine(Request $request){
        $db = SDB::db();
        $request->validate([
            "medium" => "required",
            "class_id" => "required",
            "section_id" => "required",
            "routine_type" => "required",
            'file' => 'required|mimes:pdf,jpg,jpeg,png,PNG,JPEG,JPG,PDF,|max:4048',
        ]);

        if($request->file->extension() == "pdf" || $request->file->extension() == "PDF"){
            $file_type = "pdf";
        }else{
            $file_type = "image";
        }
        $fileName = time().'.'.$request->file->extension();  
   
        $request->file->move(public_path('uploads/routine/'), $fileName);

        $file_path = public_path('uploads/routine/'.$fileName);
        DB::table($db.'.routine')->insert([
            'section_id' => $request->section_id,
            'routine_type' => $request->routine_type,
            'exam_type' => $request->exam_type,
            'medium' => $request->medium,
            'class_id' => $request->class_id,
            'file_type' => $file_type,
            'file_path' => $file_path,
            'create_date' => date('Y-m-d'),
        ]);

        return response()->json(['success' => 'Routine Added Successfully!']);
    }

    ///download routine 
    public function downlaodRoutine($id){
        $db = SDB::db();
        $data = DB::table($db.'.routine')
        ->where($db.'.routine.id',$id)
        ->first();
        $file= $data->file_path;
        $file_name = str_replace(public_path('uploads/routine').'/','',$file);
        // dd($file_name);
        return response()->download($file, $file_name);
    }

    //delete 
    public function delete(Request $request){
        $db = SDB::db();
        
        $data = DB::table($db.'.routine')
        ->where($db.'.routine.id',$request->id)
        ->first();
        unlink($data->file_path);
        
         DB::table($db.'.routine') ->where($db.'.routine.id',$request->id)->delete();
        return response()->json(['success' => 'Routine Delete Successfully!']);
    }
}
