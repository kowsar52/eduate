<?php

namespace App\Http\Controllers\stuff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB,DataTables;

class NoticeController extends Controller
{
    //
    public function index(Request $request){
        if ($request->ajax()) {
            $table = 'notice';
            $teacher_id = $_SESSION['user'];
            $db = $_SESSION['db'];
            $teacher = DB::table($db.'.teacher')
                        ->where($db.'.teacher.id',$teacher_id)
                        ->first();
            $data = DB::table($db.'.'.$table)
                        // ->where($db.'.'.$table.'.class_id', $teacher->class_id)
                        // ->orWhere($db.'.'.$table.'.class_id', '*')
                        ->orderBy($db.'.'.$table.'.create_date','DESC')
                        ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function($row){

                        if($row->file_type === "pdf"){
                            $img = '<img src="'.url('/BackendAssets/img/icon/pdf.png').'" height="50px" width="50px"/>';
                        }else{
                            $img = '<img src="'.url('/BackendAssets/img/icon/image.png').'" height="50px" width="50px"/>';
                        }
                        return $img;
                    })
                    ->addColumn('download', function($row){

                            $link = '<a  target="_blank" class="btn badge badge-success" href="'.url('stuff/notice/downlaod').'/'.$row->id.'">Download</a>';
                        return $link;
                    })
                    ->rawColumns(['image','download'])
                    ->make(true);
        }

        return view('stuff.notice');
    }

    ///download routine 
    public function downlaodNotice($id){
    
       
        $db = $_SESSION['db'];
        $data = DB::table($db.'.notice')
        ->where($db.'.notice.id',$id)
        ->first();
        $file= $data->file_path;
        $file_name = str_replace(public_path('uploads/notice').'/','',$file);
        // dd($file_name);
        return response()->download($file, $file_name);
    }
}
