<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SDB;
use DB;


class ProfileController extends Controller
{
    //index method 
    public function principalIndex(){
        $layout = "principal.layout";
        $user = Auth::user();
        return view('profile')->with(['layout' => $layout,'user'=> $user,'hidden'=>false]);
    }

    public function adminIndex(){
        $layout = "admin.layout";
        $user = Auth::user();
        return view('profile')->with(['layout' => $layout,'user'=> $user,'hidden'=>false]);
    }



    public function teacherIndexPri($id){

        $db = SDB::db();
        $layout = "principal.layout";
        $user_a = DB::table($db.'.teacher')->where($db.'.teacher.id',$id)->first();
        $user = (object)[
            'name' => $user_a->teacher_name,
            'username' => $user_a->id,
            'email' => $user_a->email,
            'phone_number' => $user_a->phone_number,
            'user_type' => 'Teacher',
            'image_path' => $user_a->image_path,
        ];
        return view('profile')->with(['layout' => $layout,'user'=> $user,'hidden'=>true]);
    }
    //student profile
    public function studentIndexPri($id){
        $db = SDB::db();
        $layout = "principal.layout";
        $user = DB::table($db.'.student')->where($db.'.student.id',$id)->first();
        return view('student.profile')->with(['layout' => $layout,'user'=> $user,'hidden'=>true]);
    }


    //get edit data
    public function getEditData(Request $request){
        $table = $request->table;
        $db = SDB::db();
        if($table === 'users'){
            $data = DB::table($table)->where('id',$request->id)->first();
        }
        return response()->json($data);
    }
    //save data
    public function update(Request $request){
        $table = $request->table;
        $db = SDB::db();
        if($table === 'users'){

            $data = DB::table($table)->where('id',$request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ]);
        }
        return response()->json(['success' =>'Profiel Updated Successfully!']);
    }
}
