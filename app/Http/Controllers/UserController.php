<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBuyerRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\crendetailMails;
use App\Mail\ResetPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=User::orderBy('created_at','desc')->get();


        return response()->json(['error'=>true,'message'=>'User Listing','data'=>$user],200);
    }
    public function companyUser(){
        $companyId= Auth::user()->company[0]->id;
        $user=DB::table('company_users')->join('users','users.id','=','company_users.user_id')->where('users.type','owner')->where('company_users.company_id',$companyId)->get();
        return response()->json(['error'=>false,'message'=>'User list','data'=>$user],200);
    }

    public function getAllForFilters(){
        $user = DB::table('users')->select('id', 'first_name', 'last_name')->where('type', '=', 'owner')->get();
        return response()->json(['error'=>false,'message'=>'Ownres list','data'=>$user],200);
    }

    /**
     * Get all owner users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser()
    {
        $users = User::where('type', 'owner')->get();

        return response()->json($users, 200);
    }


    public function singleUser(Request $request,$id){
        $user=User::with('company')->where('id',$id)->first();
        return response()->json(['error'=>false,'message'=>'User Detail','data'=>$user],200);
    }
    public function updateUser(UpdateUserRequest $request,$id){
         $user=User::where('id',$id)->first();
         $user->first_name=$request['first_name'];
        $user->last_name=$request['last_name'];
        $user->cell_phone=$request['cell_phone'];
        $user->email=$request['email'];
        $user->type=$request['user_type'];
        $user->status='activated';
        if($request['password']){
        $user->password=bcrypt($request['password']);
    }
        $user->save();
        if($request['password']){
        Mail::to($user->email)->send(new ResetPassword($request));
    }
        return response()->json(['error'=>false,'message'=>'User Created Successfully','data'=>$user],201);


    }
    public function updateStatus(Request $request){
        $user=User::where('id',$request->id)->first();
        $user->status=$request->status;
        $user->save();
        return response()->json(['error'=>false,'message'=>'Status updated.'],201);
    }

    public function storeBuyerInfo(StoreBuyerRequest $buyerRequest){
        //dd($buyerRequest);
        return response()->json(['error'=>false,'message'=>'user status updated'],201);
    }
}
