<?php

namespace App\Http\Controllers\stuff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB,DataTables;

class TransactionController extends Controller
{
    //
    public function index(Request $request){
        $db = $_SESSION['db'];
        $user = $_SESSION['user'];
        if ($request->ajax()) {

            $data = DB::table($db.'.transaction')
                        ->where($db.'.transaction.receiver_id',$user)
                        ->orderBy($db.'.transaction.id','DESC')
                        ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                         
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('stuff.trans_history');
    }
}
