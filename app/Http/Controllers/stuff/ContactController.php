<?php

namespace App\Http\Controllers\stuff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables,DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SDB;

class ContactController extends Controller
{
    //index
    public function index(){
        return view('stuff.contact');
    }

    public function contactList(Request $request){
        $db = $_SESSION['db'];
        $user = $_SESSION['user'];
        if($request->type === "teacher"){
            if ($request->ajax()) {
                $data = DB::table($db.'.teacher')
                            ->where($db.'.teacher.id','!=',$user)
                            ->orderBy($db.'.teacher.id','DESC')
                            ->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $btn = '<a href="'.url('stuff/profile/teacher/').'/'.$row->id.'" class="edit btn btn-warning btn-sm m-1  viewBtn" data-id="'.$row->id.'"><i class="fa fa-eye text-white text-center"></i></a>';
                            $btn .= '<a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  messageBtn" data-id="'.$row->id.'"><i class="fa fa-comment-dots text-white text-center"></i></a>';
                             return $btn;
                     })
                     ->addColumn('image', function($row){
                         if(!empty($row->image_path)){
                             $image_path = '<img src="'.$row->image_path.'" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                         }else{
                             $image_path = '<img src="'.url('/').'/uploads/teachers/demo.jpg" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                         }
                             return $image_path;
                     })
                     ->addColumn('id', function($row){
                          return '<span class="font-weight-bold text-uppercase">'.$row->id.'</span>';
                     })
                     ->addColumn('name', function($row){
                          return $row->teacher_name;
                     })
                     ->addColumn('assign_class', function($row){
                         if(!empty($row->class_id)){
                             $db = $_SESSION['db'];
                             $data = DB::table($db.'.class_table')->where($db.'.class_table.class_id',$row->class_id)->first();
                             $class = $data->class_name;
                         }else{
                             $class = '<span class="badge badge-danger">Not Assinged</span>';
                         }
                          return $class;
                     })
                     ->addColumn('assign_subject', function($row){
                         if(!empty($row->subject_id)){
                             $db = $_SESSION['db'];
                             $data = DB::table($db.'.subject_table')->where($db.'.subject_table.subject_id',$row->subject_id)->first();
                             $class = $data->subject_name;
                         }else{
                             $class = '<span class="badge badge-danger">Not Assinged</span>';
                         }
                          return $class;
                     })
                     ->addColumn('image', function($row){
                              
                        if(!empty($row->image_path)){
                          $image_path = '<img src="'.$row->image_path.'" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                      }else{
                          $image_path = '<img src="'.url('/').'/uploads/teachers/demo.jpg" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                      }
                          return $image_path;
                  })
                     ->rawColumns(['id','name','action','image','assign_class','assign_subject'])
                    ->make(true);
            }
        }else if($request->type === "moderator"){
            if ($request->ajax()) {
                $data = DB::table($db.'.moderator')
                            ->orderBy($db.'.moderator.id','DESC')
                            ->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $btn = '<a href="'.url('stuff/profile/teacher/').'/'.$row->id.'" class="edit btn btn-warning btn-sm m-1  viewBtn" data-id="'.$row->id.'"><i class="fa fa-eye text-white text-center"></i></a>';
                            $btn .= '<a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  messageBtn" data-id="'.$row->id.'"><i class="fa fa-comment-dots text-white text-center"></i></a>';
                             return $btn;
                     })
                     ->addColumn('id', function($row){
                          return '<span class="font-weight-bold text-uppercase">'.$row->id.'</span>';
                     })
                     ->addColumn('name', function($row){
                          return $row->moderator_name;
                     })
                     ->addColumn('assign_class', function($row){

                          return $row->email;
                     })
                     ->addColumn('assign_subject', function($row){
                        return $row->moderator_type;
                     })
                     ->addColumn('image', function($row){
                              
                        if(!empty($row->image_path)){
                          $image_path = '<img src="'.$row->image_path.'" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                      }else{
                          $image_path = '<img src="'.url('/').'/uploads/teachers/demo.jpg" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                      }
                          return $image_path;
                  })
                     ->rawColumns(['id','name','action','image','assign_class','assign_subject'])
                    ->make(true);
            }
        }else if($request->type === "student"){
            if ($request->ajax()) {
                $data = DB::table($db.'.student')
                            ->orderBy($db.'.student.id','DESC')
                            ->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $btn = '<a href="'.url('stuff/profile/student/').'/'.$row->id.'" class="edit btn btn-warning btn-sm m-1  viewBtn" data-id="'.$row->id.'"><i class="fa fa-eye text-white text-center"></i></a>';
                            $btn .= '<a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  messageBtn" data-id="'.$row->id.'"><i class="fa fa-comment-dots text-white text-center"></i></a>';
                             return $btn;
                     })
                     ->addColumn('id', function($row){
                          return '<span class="font-weight-bold text-uppercase">'.$row->id.'</span>';
                     })
                     ->addColumn('name', function($row){
                          return $row->student_name;
                     })
                     ->addColumn('assign_class', function($row){

                          return $row->email;
                     })
                     ->addColumn('assign_subject', function($row){
                        if(!empty($row->class_roll)){
                            $class = $row->class_roll;
                        }else{
                            $class = '<span class="badge badge-danger">Not Assinged</span>';
                        }
                         return $class;
                     })
                     ->addColumn('image', function($row){
                              
                        if(!empty($row->image_path)){
                          $image_path = '<img src="'.$row->image_path.'" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                      }else{
                          $image_path = '<img src="'.url('/').'/uploads/teachers/demo.jpg" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                      }
                          return $image_path;
                  })
                     ->rawColumns(['id','name','action','image','assign_class','assign_subject'])
                    ->make(true);
            }
        }else if($request->type === "admin"){
            if ($request->ajax()) {
            
                $data = DB::table('users')->where('users.school_id',$_SESSION["school_id"])->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $btn = '<a href="'.url('stuff/profile/teacher/').'/'.$row->id.'" class="edit btn btn-warning btn-sm m-1  viewBtn" data-id="'.$row->id.'"><i class="fa fa-eye text-white text-center"></i></a>';
                            $btn .= '<a href="javascript:void(0)" class="edit btn btn-success btn-sm m-1  messageBtn" data-id="'.$row->id.'"><i class="fa fa-comment-dots text-white text-center"></i></a>';
                             return $btn;
                     })
                     ->addColumn('id', function($row){
                          return '<span class="font-weight-bold text-uppercase">'.$row->id.'</span>';
                     })
                     ->addColumn('name', function($row){
                          return $row->name;
                     })
                     ->addColumn('assign_class', function($row){

                          return $row->email;
                     })
                     ->addColumn('assign_subject', function($row){
                        return $row->user_type;
                     })
                     ->addColumn('image', function($row){
                              
                        if(!empty($row->image_path)){
                          $image_path = '<img src="'.$row->image_path.'" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                      }else{
                          $image_path = '<img src="'.url('/').'/uploads/teachers/demo.jpg" style="width: 30px;height: 30px;border-radius: 50%;"/>';
                      }
                          return $image_path;
                  })
                     ->rawColumns(['id','name','action','image','assign_class','assign_subject'])
                    ->make(true);
            }
        }
        return view('stuff.contact');
    }
}
