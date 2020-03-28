<?php

namespace App\Http\Controllers\stuff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB,DataTables;

class ClassController extends Controller
{
    //indexmethod
    public function index(){
        return view('stuff.class');
    }

    //get class 
    public function getClass(Request $request){
        if ($request->ajax()) {
            $table = 'subject_assigned_table';
            $teacher_id = $_SESSION['user'];
            $db = $_SESSION['db'];
            $data = DB::table($db.'.'.$table)
                        ->where($db.'.'.$table.'.teacher_id',$teacher_id)
                        ->join($db.'.section',$db.'.section.id','=',$db.'.'.$table.'.section_id')
                        ->orderBy($db.'.'.$table.'.start_time','DESC')
                        ->get();
              
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('start_time', function($row){
                        return date('h:i A',strtotime($row->start_time));
                    })
                    ->addColumn('end_time', function($row){
                        return date('h:i A',strtotime($row->end_time));
                    })
                    ->addColumn('duration', function($row){
                        return $row->duration.' Minutes';
                    })
                    ->rawColumns(['start_time','end_time','duration'])
                    ->make(true);
        }
    }
}
