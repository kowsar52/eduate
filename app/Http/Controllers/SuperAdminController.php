<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\School;
use App\User;
use DataTables,DB;
use Carbon\Carbon;
class SuperAdminController extends Controller
{
    //school list display method 
    public function getSchool(Request $request){

        if ($request->ajax()) {
            $data = School::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-eye text-white text-center"></i></a>';
                            return $btn;
                    })
                    ->addColumn('image', function($row){
                           $image_path = '<img src="'.$row->image_path.'" width="100px"/>';
                            return $image_path;
                    })
                    ->addColumn('status', function($row){
                        if($row->status === 1){

                            $btn = '<span class="btn badge badge-success">Active</span>';
                        }else{
                            $btn = '<span class="btn badge badge-danger">Deactive</span>';
                        }
                            return $btn;
                    })
                    ->addColumn('author', function($row){
                        $user = User::where('id',$row->author_id)->first();
                         return $user->name;
                    })
                    ->rawColumns(['action','image','status','author'])
                    ->make(true);
        }
      
        return view('admin/schools');
    }

    //author method 
    public function author(){
        return view('admin/author');
    }

    //authority list display method 
    public function getAuthority(Request $request){

        if ($request->ajax()) {
            $data = User::where('user_type','!=','super_admin')->orderBy('id','desc')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('created_at', function($row){
                        $created_at =Carbon::parse($row->created_at)->diffForHumans();
                        return $created_at;
                    })
                    ->rawColumns(['created_at'])
                    ->make(true);
        }
        
        return view('admin/schools');
    }


}
