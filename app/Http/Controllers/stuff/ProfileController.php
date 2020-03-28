<?php

namespace App\Http\Controllers\stuff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ProfileController extends Controller
{
    //
    public function index(){

        $layout = "stuff.layout";
        $id = $_SESSION['user'];
        $db = $_SESSION['db'];
        $user_a = DB::table($db.'.teacher')->where($db.'.teacher.id',$id)->first();
       
        $user = (object)[
            'name' => $user_a->teacher_name,
            'username' => $user_a->id,
            'email' => $user_a->email,
            'phone_number' => $user_a->phone_number,
            'user_type' => 'Teacher',
            'image_path' => $user_a->image_path,
        ];
        return view('stuff.profile')->with(['layout' => $layout,'user'=> $user,'hidden'=>false]);
    }

    //get edit data
    public function getEditData(Request $request){
     
        $db =  $_SESSION["db"];
        $data = DB::table($db.'.teacher')->where($db.'.teacher.id',$request->id)->first();

        return response()->json($data);
    }

    //save data
    public function update(Request $request){
   
        $db =  $_SESSION["db"];

            $data = DB::table($db.'.teacher')->where($db.'.teacher.id',$request->id)->update([
                'teacher_name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ]);

        return response()->json(['success' =>'Profile Updated Successfully!']);
    }

    public function teacherIndexPri($id){

        $db =  $_SESSION["db"];
        $layout = "stuff.layout";
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
        $db =  $_SESSION["db"];
        $layout = "stuff.layout";
        $user = DB::table($db.'.student')->where($db.'.student.id',$id)->first();
        return view('student.profile')->with(['layout' => $layout,'user'=> $user,'hidden'=>true]);
    }

}
