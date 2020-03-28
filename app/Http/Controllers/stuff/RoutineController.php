<?php

namespace App\Http\Controllers\stuff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB,DataTables;

class RoutineController extends Controller
{
    //    //index 
    public function index(Request $request){
        $db = $_SESSION['db'];
        if ($request->ajax()) {
            $table = 'routine';
            $routine_type = $_GET['routine_type'];

            $data = DB::table($db.'.routine')
                        ->where($db.'.routine.routine_type',$routine_type)
                        ->orderBy($db.'.routine.id','DESC')
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

                            $link = '<a  target="_blank" class="btn badge badge-success" href="'.url('stuff/routine/downlaod').'/'.$row->id.'">Download</a>';
                        return $link;
                    })
                    ->addColumn('section', function($row){
                        $db = $_SESSION['db'];
                        $section = DB::table($db.'.section')->where($db.'.section.id',$row->section_id)->first();
                        return $section->section_name;
                    })
                    ->addColumn('class', function($row){
                        $db = $_SESSION['db'];
                        $section = DB::table($db.'.class_table')->where($db.'.class_table.class_id',$row->class_id)->first();
                        return $section->class_name;
                    })
                    ->rawColumns(['section','class','medium','image','download'])
                    ->make(true);
        }

        return view('stuff.routine');
    }


    ///download routine 
    public function downlaodRoutine($id){
        $db = $_SESSION['db'];
        $data = DB::table($db.'.routine')
        ->where($db.'.routine.id',$id)
        ->first();
        $file= $data->file_path;
        $file_name = str_replace(public_path('uploads/routine').'/','',$file);
        // dd($file_name);
        return response()->download($file, $file_name);
    }
}
