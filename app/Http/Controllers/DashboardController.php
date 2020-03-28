<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\SDB;
use DB;

class DashboardController extends Controller
{
//     public function __construct()
//    {
//        $this->middleware(checkRole::class);
//    }

    //adminDashboard mthod 
    public function adminDashboard()
    {
        $authors = User::where('user_type','!=','super_admin')->orderBy('id','desc')->get();
        return view('admin/dashboard')->with('authors',$authors);
    }

    //principalDashboard mthod 
    public function principalDashboard()
    {
        //craete table after login dashbard 
        $db = SDB::db();
        $table1 = "subject_assigned_table";
        DB::statement("CREATE TABLE IF NOT EXISTS $db.$table1 (ass_id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (ass_id),class_name varchar(255) NOT NULL,teacher_name varchar(255) NOT NULL,subject_name varchar(255) NOT NULL,class_id int NOT NULL,section_id int NOT NULL,teacher_id varchar(255) NOT NULL,subject_id int NOT NULL,start_time TIME NULL,end_time TIME NULL,day varchar(50) NULL,duration varchar(50) NULL)");
        $table2 = 'subject_table';
        DB::statement("CREATE TABLE IF NOT EXISTS $db.$table2 (subject_id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (subject_id),subject_name varchar(255) NOT NULL,class_id varchar(10) NULL)");
        $table3 = 'class_table';
        DB::statement("CREATE TABLE IF NOT EXISTS $db.$table3 (class_id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (class_id),class_name varchar(50) NOT NULL,medium varchar(50) NOT NULL)");

       DB::statement("CREATE TABLE IF NOT EXISTS $db.section (id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (id),`section_name` varchar(50) NOT NULL, `shift_name` varchar(50) NOT NULL,`class_id` int(11) NOT NULL,`class_teacher_id` varchar(10) DEFAULT NULL)");
       $table4 = 'exam';
    DB::statement("CREATE TABLE IF NOT EXISTS $db.$table4 (id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (id),exam_type varchar(50) NOT NULL,exam_name TEXT NOT NULL,subject_id varchar(10) NOT NULL,subject_name TEXT NOT NULL,section_id varchar(50) NOT NULL,class_id varchar(50) NOT NULL,create_date DATE NOT NULL,create_time TEXT NOT NULL,result_status BOOLEAN default 0,marks int default 0)");
      $table5 = 'moderator';
       DB::statement("CREATE TABLE IF NOT EXISTS $db.$table5 (id varchar(10) NOT NULL,PRIMARY KEY (id),password varchar(256) NOT  NULL,moderator_name varchar(255) NOT NULL,moderator_type varchar(255) NOT NULL,email varchar(150) NOT NULL,phone_number varchar(20) NOT NULL,image_path TEXT NULL,device_id TEXT NULL)");

            $table6 = 'student';
            DB::statement("CREATE TABLE IF NOT EXISTS $db.$table6 (id varchar(10) NOT NULL,PRIMARY KEY (id),password varchar(256) NOT NULL,student_name varchar(256) NOT NULL,email varchar(150) NOT NULL,phone_number varchar(20) NOT NULL,class_id varchar(100) NOT NULL,section_id varchar(100) NOT NULL,image_path TEXT NULL,gender varchar(256) NULL,birth_date varchar(256) NULL,religion varchar(256) NULL,blood_group varchar(256) NULL,class_roll INT,father_name varchar(256) NULL,mother_name varchar(256) NULL,father_contact varchar(256) NULL,mother_contact varchar(256) NULL,father_occupation varchar(256) NULL,mother_occupation varchar(256) NULL,alt_email varchar(256) NULL,emergency_contact varchar(256) NULL,present_address varchar(256) NULL,permanent_address varchar(256) NULL,device_id TEXT NULL)");




        
        return view('principal/dashboard');
    }

    //stuffDashboard mthod /teacher
    public function stuffDashboard()
    {
        return view('stuff/dashboard');
    }

    //student mthod /parent
    public function studentDashboard()
    {
        return view('student/dashboard');
    }
}
