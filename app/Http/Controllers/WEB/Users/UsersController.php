<?php

namespace App\Http\Controllers\WEB\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function indexUsers()
    {
        return view('users.users');
    }
    public function UserDatatable()
    {
        $data = User::where('approve_1','<>',null)->where('user_status','Verification passed')->with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->with(array('superadmin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_super_admin_name"));
        }))->get();
        // return $data;
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('name',function($data){
            return $data['first_name'].$data['last_name'];
        })
        ->addColumn('type',function($data){
            $result = $data['type_user'] == 1 ? 'Personal' : 'Company';
            if($result == 'Personal')
                return '<p>'.$result.'</p>';
            return '<p>'.$result.'</p>';
        })
        ->addColumn('admin',function($data){
            return $data['admin_relation']->approve_admin_name;
        })
        ->addColumn('action',function($data){
            $edit = '<a class="btn btn-primary" href="'.url('users/'.$data['id'].'/approve').'"> <i class="fa fa-edit"> </i> </a>';
            return $edit;
        })
        ->rawColumns(['type','action'])
        ->make(true);
    }
    public function ApproveUsers($id)
    {
        $data = User::with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->with(array('superadmin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_super_admin_name"));
        }))->with('country_relation','province_relation','city_relation')->find($id);
        // return $data;
        return view('users.approve',compact('data'));
    }
    public function approve(Request $request,$id)
    {
        $approve = $request->input('approve');
        if(Auth::user()->type_user == 4)
        {
            User::where('id',$id)->update([
                'approve_1' => $approve,
                'admin_approve_1' => Auth::user()->id,
                'approvedate_1' => Carbon::now('Asia/Jakarta'),
            ]);
            return redirect()->route('index-users');
        }else{
            User::where('id',$id)->update([
                'approve_2' => $approve,
                'admin_approve_2' => Auth::user()->id,
                'approvedate_2' => Carbon::now('Asia/Jakarta'),
                'user_status' => 'Verification passed',
            ]);
            return redirect()->route('index-users');
        }
    }
    public function pendingUsers()
    {
        return view('users.pending');
    }
    public function pendingDatatableAdmin()
    {
        $data = User::where('approve_1',null)->where('approve_2',null)->where('user_status','Waiting for Verification')->get();
        // return $data;
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('name',function($data){
            return $data['first_name'].$data['last_name'];
        })
        ->addColumn('type',function($data){
            $result = $data['type_user'] == 1 ? 'Personal' : 'Company';
            if($result == 'Personal')
                return '<p>'.$result.'</p>';
            return '<p>'.$result.'</p>';
        })
        ->addColumn('action',function($data){
            $edit = '<a class="btn btn-primary" href="'.url('users/'.$data['id'].'/approve').'"> <i class="fa fa-edit"> </i> </a>';
            return $edit;
        })
        ->rawColumns(['type','action'])
        ->make(true);
    }
    public function pendingDatatableSuperAdmin()
    {
        $data = User::where('approve_2',null)->where('user_status','Waiting for Verification')->with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->get();
        // return $data;
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('name',function($data){
            return $data['first_name'].$data['last_name'];
        })
        ->addColumn('type',function($data){
            $result = $data['type_user'] == 1 ? 'Personal' : 'Company';
            if($result == 'Personal')
                return '<p>'.$result.'</p>';
            return '<p>'.$result.'</p>';
        })
        ->addColumn('admin',function($data){
            return $data['admin_relation']->approve_admin_name;
        })
        ->addColumn('action',function($data){
            $edit = '<a class="btn btn-primary" href="'.url('users/'.$data['id'].'/approve').'"> <i class="fa fa-edit"> </i> </a>';
            return $edit;
        })
        ->rawColumns(['type','action'])
        ->make(true);
    }
}
