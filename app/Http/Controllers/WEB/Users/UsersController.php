<?php

namespace App\Http\Controllers\WEB\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function indexUsers()
    {
        return view('users.users');
    }
    public function UserDatatable()
    {
        $data = User::with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->with(array('superadmin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_super_admin_name"));
        }))->where('type_user',1)->orWhere('type_user',2)->where('user_status','Verification passed')->get();
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
        $data = User::find($id);
        return view('users.approve',compact('data'));
    }
}
