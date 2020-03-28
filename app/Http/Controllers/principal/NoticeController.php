<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SDB;
use Illuminate\Http\Request;
use DB,DataTables,Image;

class NoticeController extends Controller
{
    //
     //index 
     public function index(Request $request){
        $db = SDB::db();
        if ($request->ajax()) {
            $table = 'notice';
            DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (id),title TEXT NOT NULL,details TEXT NOT NULL,class_id varchar(20) NOT NULL,authority_id varchar(120) NOT NULL,file_type varchar(20) NULL,file_path TEXT NULL,create_date DATE NOT NULL)");

            $data = DB::table($db.'.notice')
                        ->orderBy($db.'.notice.create_date','DESC')
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

                            $link = '<a  target="_blank" class="btn badge badge-success" href="'.url('principal/notice/downlaod').'/'.$row->id.'">Download</a>';
                        return $link;
                    })
                    ->rawColumns(['action','image','download'])
                    ->make(true);
        }
    
        return view('principal.notice');
    }
    

    //get section by class 
    public function getClass(Request $request){
        $db = SDB::db();
        if($request->medium === "*"){
            $section = DB::table($db.'.class_table')->get();
        } else{
            $section = DB::table($db.'.class_table')->where($db.'.class_table.medium',$request->medium)->get();
        }
        $option = '<option value="*">All</option>';
        foreach($section as $data){
            $option .='<option value="'.$data->class_id.'">'.$data->class_name.'</option>';
        }
         return response()->json($option, 200);
    }


    public function addNotice(Request $request){
        $db = SDB::db();
        $request->validate([
            "title" => "required",
            "details" => "required",
            "class_id" => "required",
            'file' => 'required|mimes:pdf,jpg,jpeg,png,PNG,JPEG,JPG,PDF,|max:4048',
        ]);

        if($request->file->extension() == "pdf" || $request->file->extension() == "PDF"){
            $file_type = "pdf";
        }else{
            $file_type = "image";
        }
        $fileName = time().'.'.$request->file->extension();  
   
        $request->file->move(public_path('uploads/notice/'), $fileName);
        $authority_id = Auth::user();
        $file_path = public_path('uploads/notice/'.$fileName);
        DB::table($db.'.notice')->insert([
            'title' => $request->title,
            'details' => $request->details,
            'class_id' => $request->class_id,
            'file_type' => $file_type,
            'file_path' => $file_path,
            'authority_id' => $authority_id->username,
            'create_date' => date('Y-m-d'),
        ]);

        return response()->json(['success' => 'Notice Added Successfully!']);
    }

    ///download routine 
    public function downlaodNotice($id){
        $db = SDB::db();
        $data = DB::table($db.'.notice')
        ->where($db.'.notice.id',$id)
        ->first();
        $file= $data->file_path;
        $file_name = str_replace(public_path('uploads/notice').'/','',$file);
        // dd($file_name);
        return response()->download($file, $file_name);
    }

    //delete 
    public function delete(Request $request){
        $db = SDB::db();
        
        $data = DB::table($db.'.notice')
        ->where($db.'.notice.id',$request->id)
        ->first();
        unlink($data->file_path);
        
         DB::table($db.'.notice') ->where($db.'.notice.id',$request->id)->delete();
        return response()->json(['success' => 'notice Delete Successfully!']);
    }
}
