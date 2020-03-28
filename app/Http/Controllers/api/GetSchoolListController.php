<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\School;

class GetSchoolListController extends Controller
{
    public function getSchools(Request $request){

        $schools = School::orderBy('id','DESC')->get();
    
        if($schools)
        {
            $response = $schools;
        }
        else{
    
             $response=array('no item');
        }
    
        return response()->json($response);
    }
    
}
