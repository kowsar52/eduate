<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
