<?php

namespace App\Http\Controllers\principal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DataTables,DB;

class TransactionController extends Controller
{
    //get transaction history 
    public function getHistory(Request $request){
        $db = SDB::db();
        if ($request->ajax()) {

            $data = DB::table($db.'.transaction')
                        ->orderBy($db.'.transaction.id','DESC')
                        ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                          $btn ='<a href="javascript:void(0)" class="edit btn btn-info btn-sm m-1  editBtn"  data-id="'.$row->id.'"><i class="fa fa-edit text-white text-center"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('principal.trans_history');
    }

    //get edit data
    public function editData(Request $request){
        $db = SDB::db();
        $data = DB::table($db.'.transaction')->where($db.'.transaction.id',$request->id)->first();
        return response()->json($data);
    }

    public function edit(Request $request){
        $db = SDB::db();
        $request->validate([
            "transaction_type" => "required",
            "transaction_name" => "required",
            "receiver_type" => "required",
            "receiver_id" => "required",
            "amount" => "required",
            "debit_credit" => "required",
        ]);
        DB::table($db.'.transaction')->where($db.'.transaction.id',$request->id)->update([
            'transaction_type' => $request->transaction_type,
            'transaction_name' => $request->transaction_name,
            'receiver_type' => $request->receiver_type,
            'receiver_id' => $request->receiver_id,
            'amount' => $request->amount,
            'debit_credit' => $request->debit_credit,
        ]);
        return response()->json(['success' => 'Payment Updated Successfully!']);

    }
    //index 
    public function index(){
        $db = SDB::db();
        $table = "transaction";
        DB::statement("CREATE TABLE IF NOT EXISTS $db.$table (id int NOT NULL AUTO_INCREMENT,PRIMARY KEY (id),sender_id varchar(256) NOT NULL,receiver_id varchar(256) NOT NULL,sender_type varchar(256) NOT NULL,receiver_type varchar(256) NOT NULL,transaction_type varchar(256) NOT NULL,transaction_name varchar(256) NOT NULL,amount FLOAT(2) NOT NULL,debit_credit varchar(100) NOT NULL,payment_method varchar(256) NOT NULL,create_date DATE NOT NULL)");
        $classes = DB::table($db.'.class_table')->get();
        $teachers = DB::table($db.'.teacher')->orderBy($db.'.teacher.id','desc')->get();
        $stuffs = DB::table($db.'.moderator')->orderBy($db.'.moderator.id','desc')->get();
        return view('principal.transaction')->with(['classes' => $classes,'teachers' => $teachers,'stuffs' => $stuffs]);
    }

    public function getStd(Request $request){
        $db = SDB::db();
        $student = DB::table($db.'.student')->where($db.'.student.class_id',$request->class_id)->get();

        $option = '<option value="">Chosse Student</option>';
        foreach($student as $data){
            $option .='<option value="'.$data->id.'">'.$data->id.' - '.$data->student_name.'</option>';
        }
         return response()->json($option, 200);
    }

    public function addTransaction(Request $request){
        // dd($request->all());
        $db = SDB::db();
        if($request->type === "student"){
            $request->validate([
                "amount" => "required",
                "class_id" => "required",
                "sender_id" => "required",
                "transaction_name" => "required",
            ]);
            DB::table($db.'.transaction')->insert([
                'sender_id' => $request->sender_id,
                'receiver_id' => Auth::user()->username,
                'sender_type' => 'Student',
                'receiver_type' => 'Authority',
                'transaction_type' => 'Student Fee',
                'transaction_name' => $request->transaction_name,
                'amount' => $request->amount,
                'debit_credit' => 'credit',
                'payment_method' => 'Cash',
                'create_date' => date('Y-m-d'),
            ]);
            
        }else if($request->type === "teacher"){
            $request->validate([
                "amount" => "required",
                "payment_method" => "required",
                "receiver_id" => "required",
            ]);
            DB::table($db.'.transaction')->insert([
                'sender_id' => Auth::user()->username,
                'receiver_id' => $request->receiver_id,
                'sender_type' => 'Authority',
                'receiver_type' => 'Teacher',
                'transaction_type' => 'Teacher Salary',
                'transaction_name' => 'Teacher Salary',
                'amount' => $request->amount,
                'debit_credit' => 'debit',
                'payment_method' => $request->payment_method,
                'create_date' => date('Y-m-d'),
            ]);
            
        } else if($request->type === "stuff"){
            $request->validate([
                "amount" => "required",
                "payment_method" => "required",
                "receiver_id" => "required",
            ]);
            DB::table($db.'.transaction')->insert([
                'sender_id' => Auth::user()->username,
                'receiver_id' => $request->receiver_id,
                'sender_type' => 'Authority',
                'receiver_type' => 'Stuff',
                'transaction_type' => 'Stuff Salary',
                'transaction_name' => 'Stuff Salary',
                'amount' => $request->amount,
                'debit_credit' => 'debit',
                'payment_method' => $request->payment_method,
                'create_date' => date('Y-m-d'),
            ]);
            
        }else if($request->type === "other"){
            $request->validate([
                "amount" => "required",
                "payment_method" => "required",
                "receiver_id" => "required",
                "transaction_name" => "required",
                "transaction_type" => "required",
            ]);
            DB::table($db.'.transaction')->insert([
                'sender_id' => Auth::user()->username,
                'receiver_id' => $request->receiver_id,
                'sender_type' => 'Authority',
                'receiver_type' => 'Stuff',
                'transaction_type' => 'Unknown',
                'transaction_name' => $request->transaction_name,
                'amount' => $request->amount,
                'debit_credit' => $request->transaction_type,
                'payment_method' => $request->payment_method,
                'create_date' => date('Y-m-d'),
            ]);
            
        }
        return response()->json(['success' => 'Payment Added Successfully!']);
    }

}
