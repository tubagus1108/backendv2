<?php

namespace App\Http\Controllers\API\AUTH;

use App\Http\Controllers\Controller;
use App\Models\BiCheck;
use App\Models\Refellar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\AdaremitMail;
use App\Mail\RejectedMail;
use App\Models\LogVerification;
use App\Models\Voucher;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registerByadmin(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'type_user' => 'required|integer|in:1,2',
            'user_hp' => 'required',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|min:5',
            'referral_code' => 'min:5',
            'id_card_num' => 'required|unique:users,id_card_num,'
        ]);
        if($validated->fails()){
            return response()->json(['error' =>true, 'message' => $validated->errors()],400);
        }
        $full_name = strtoupper($request->first_name . " " . $request->last_name);
        $check_data = BiCheck::where('nama','like','%'. $full_name . '%')->get();
        if(count($check_data) == 0){
            $bicheck = "Pass Check";
            // return "Data Tidak Ada Masalah";
        }else{
            // return response()->json(['error' => true, 'message' => 'Data Terdeteksi bi check']);
            // return "Data ada Masalah";
            $bicheck = "Fail Check";
        }
        $status_usr = "Waiting for Verification";
        $user = new User();
        $user->email = $request->email;
        $passwordEncrypt = password_hash($request->password, PASSWORD_DEFAULT);
        $user->password = $passwordEncrypt;
        $user->country_residence = $request->country_residence;
        $user->user_hp = $request->user_hp;
        $user->business_name = $request->business_name;
        $request->reg_business_name = $request->reg_business_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        if($request->type_user == 1)
        {
            $user->gender = $request->gender;
        }else if($request->type_user == 2)
        {
            $user->gender = $request->gender;
            $user->company_type = $request->company_type;
            $user->company_role = $request->company_role;
            $user->company_address = $request->company_address;
        }
        $user->company_website = $request->company_website;
        $user->place_birth = $request->place_birth;
        $user->date_birth = $request->date_birth;
        $user->address = $request->address;
        $user->country_id = $request->country_id;
        $user->province_id = $request->province_id;
        $user->city_id = $request->city_id;
        $user->zip = $request->zip;
        $user->citizen = $request->citizen;
        $user->occupation = $request->occupation;
        $user->tlp = $request->tlp;
        $user->id_card_type = $request->id_card_type;
        $user->id_card_num = $request->id_card_num;
        $user->type_user = $request->type_user;
        $user->user_status = $status_usr;
        $user->status_bi_check = $bicheck;
        $genereteCode = $this->genereteCode();
        $user->referral_code = $genereteCode;
        // $check_refellar = User::where('referral_code',$request->referral_code)->get();
        // if(!count($check_refellar)){
        //     return response()->json(['error' => true, 'message' => 'Referral Code not Found']);
        // }
        $user->save();
        if(!$user){
            return response()->json(['error' => true, 'message' => 'Registrasi failed !!', 'data' => $user->id],400);
        }
        $nominal_voucer = $_ENV['VOUCHER_NOMINAL_REGISTER'];
        try{
            for($i=0; $i<$_ENV['NUM_GENERATE_VOUCHER_REGISTER']; $i++){
                Voucher::create([
                    'code_voucher' => $genereteCode,
                    'user_id' => $user->id,
                    'value' => $nominal_voucer,
                    'status' => 0,
                ]);
            }
        }catch(Exception $e)
        {
            return response()->json(['error' => true, 'message' => $e]);
        }
        if($user)
        {
            $details = [
                'title' => 'Welcome to adaremit.com',
                'url' => 'adaremit.co.id',
                'full_name' => $request->first_name . ' ' . $request->last_name,
            ];
            Mail::to($request->email)->send(new AdaremitMail($details));
        }
        if($bicheck == "Fail Check")
        {
            $details = [
                'title' => 'We are sory your accout rejected',
                'url' => 'adaremit.co.id',
                'full_name' => $request->first_name . ' ' . $request->last_name,
            ];
            Mail::to($request->email)->send(new RejectedMail($details));
        }
        $dataarray = [];
        $dataarray = array(
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'mobile_phone' => $user->user_hp,
            'BI_status' => $user->status_bi_check,
        );
        return response()->json(['error' => false, 'message' => 'Registrasi Success full !!', 'data' => $dataarray],200);


    }
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'type_user' => 'required|integer|in:1,2,3,4',
            'user_hp' => 'required|unique:users,user_hp,',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|min:5',
            'referral_code' => 'min:5',
            'id_card_num' => 'required|unique:users,id_card_num,',
        ]);
        if($validated->fails()){
            return response()->json(['error' =>true, 'message' => $validated->errors()],400);
        }
        $full_name = strtoupper($request->first_name . " " . $request->last_name);
        $check_data = BiCheck::where('nama','like','%'. $full_name . '%')->get();
        if(count($check_data) == 0){
            $bicheck = "Pass Check";
            // return "Data Tidak Ada Masalah";
        }else{
            // return response()->json(['error' => true, 'message' => 'Data Terdeteksi bi check']);
            // return "Data ada Masalah";
            $bicheck = "Fail Check";
        }
        if($request->hasFile('foto_id_card')){
            $file = $request->file('foto_id_card');
            $fileName = $file->getClientOriginalName();
            if (!in_array($request->file('foto_id_card')->getClientOriginalExtension(), array('jpg', 'jpeg', 'png'))) return response()->json(['error' => true, 'message' => 'File type is not supported, support only JPG, JPEG and PNG !'], 200);
            $file->move('KTP/'.$file->getClientOriginalName());
            $pathKTP = asset('KTP/'.$file->getClientOriginalName());
        }
        if($request->hasFile('foto_selfie_id_card')){
            $file = $request->file('foto_selfie_id_card');
            $fileName = $file->getClientOriginalName();
            if (!in_array($request->file('foto_selfie_id_card')->getClientOriginalExtension(), array('jpg', 'jpeg', 'png'))) return response()->json(['error' => true, 'message' => 'File type is not supported, support only JPG, JPEG and PNG !'], 200);
            $file->move('KTPSELF/'.$file->getClientOriginalName());
            $pathKTPSelfi = asset('KTPSELF/'.$file->getClientOriginalName());
        }
        if($request->hasFile('foto_izin_company')){
            $file = $request->file('foto_izin_company');
            $fileName = $file->getClientOriginalName();
            if (!in_array($request->file('foto_izin_company')->getClientOriginalExtension(), array('jpg', 'jpeg', 'png'))) return response()->json(['error' => true, 'message' => 'File type is not supported, support only JPG, JPEG and PNG !'], 200);
            $file->move('IZINCOMPANY/'.$file->getClientOriginalName());
            $foto_izin_company = asset('IZINCOMPANY/'.'BIMG-'.$file->getClientOriginalName());
        }
        if($request->hasFile('foto_npwp')){
            $file = $request->file('foto_npwp');
            $fileName = $file->getClientOriginalName();
            if (!in_array($request->file('foto_npwp')->getClientOriginalExtension(), array('jpg', 'jpeg', 'png'))) return response()->json(['error' => true, 'message' => 'File type is not supported, support only JPG, JPEG and PNG !'], 200);
            $file->move('NPWP/'.'BIMG-'.$file->getClientOriginalName());
            $foto_npwp = asset('NPWP/'.'BIMG-'.$file->getClientOriginalName());
        }
        $status_usr = "Waiting for Verification";
        $user = new User();
        $user->email = $request->email;
        $passwordEncrypt = password_hash($request->password, PASSWORD_DEFAULT);
        $user->password = $passwordEncrypt;
        $user->country_residence = $request->country_residence;
        $user->user_hp = $request->user_hp;
        $user->business_name = $request->business_name;
        $request->reg_business_name = $request->reg_business_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        if($request->type_user == 1)
        {
            $user->gender = $request->gender;
        }else if($request->type_user == 2)
        {
            $user->gender = $request->gender;
            $user->company_type = $request->company_type;
            $user->company_role = $request->company_role;
            $user->company_address = $request->company_address;
            $user->foto_npwp = $foto_npwp ?? null;
            $user->foto_izin_company = $foto_izin_company ?? null;
        }
        $user->company_type = $request->company_type;
        $user->company_role = $request->company_role;
        $user->company_address = $request->company_address;
        $user->company_website = $request->company_website;
        $user->place_birth = $request->place_birth;
        $user->date_birth = $request->date_birth;
        $user->address = $request->address;
        $user->country_id = $request->country_id;
        $user->province_id = $request->province_id;
        $user->city_id = $request->city_id;
        $user->zip = $request->zip;
        $user->citizen = $request->citizen;
        $user->occupation = $request->occupation;
        $user->tlp = $request->tlp;
        $user->id_card_type = $request->id_card_type;
        $user->id_card_num = $request->id_card_num;
        $user->foto_id_card = $pathKTP ?? null;
        $user->foto_selfie_id_card = $pathKTPSelfi ?? null;
        $user->type_user = $request->type_user;
        $user->user_status = $status_usr;
        $user->status_bi_check = $bicheck;
        $genereteCode = $this->genereteCode();
        $user->referral_code = $genereteCode;
        // $check_refellar = User::where('referral_code',$request->referral_code)->get();
        // if(!count($check_refellar)){
        //     return response()->json(['error' => true, 'message' => 'Referral Code not Found']);
        // }
        $user->save();
        if(!$user){
            return response()->json(['error' => true, 'message' => 'Registrasi failed !!', 'data' => $user->id],400);
        }
        $nominal_voucer = $_ENV['VOUCHER_NOMINAL_REGISTER'];
        try{
            for($i=0; $i<$_ENV['NUM_GENERATE_VOUCHER_REGISTER']; $i++){
                Voucher::create([
                    'code_voucher' => $genereteCode,
                    'user_id' => $user->id,
                    'value' => $nominal_voucer,
                    'status' => 0,
                ]);
            }
        }catch(Exception $e)
        {
            return response()->json(['error' => true, 'message' => $e]);
        }
        if($user)
        {
            $details = [
                'title' => 'Welcome to adaremit.com',
                'url' => 'adaremit.co.id',
                'full_name' => $request->first_name . ' ' . $request->last_name,
            ];
            Mail::to($request->email)->send(new AdaremitMail($details));
        }
        if($bicheck == "Fail Check")
        {
            $details = [
                'title' => 'We are sory your accout rejected',
                'url' => 'adaremit.co.id',
                'full_name' => $request->first_name . ' ' . $request->last_name,
            ];
            Mail::to($request->email)->send(new RejectedMail($details));
        }
        $dataarray = [];
        $dataarray = array(
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'mobile_phone' => $user->user_hp,
            'BI_status' => $user->status_bi_check,
        );
        return response()->json(['error' => false, 'message' => 'Registrasi Success full !!', 'data' => $dataarray],200);

    }
    public function login(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validated->fails()){
            return response()->json(['error' =>true, 'message' => $validated->errors()],400);
        }
        $user = User::where('email',$request->email)->first();
        if($user)
        {
            if(Hash::check($request->password, $user->password)){
                $data['token'] = $user->createToken('nApp')->accessToken;
                $data['id'] = $user->id;
                $data['name'] = $user->first_name . ' ' . $user->last_name;
                $data['approve_2'] = $user->approve_2;
                $data['type_user'] = $user->type_user;
                return response()->json(['error' =>false, 'message' => 'Login success!', 'data' => $data],200);
            }
            return response()->json(['error' => true, 'message' => 'Password is wrong'], 404);
        }
        return response()->json(['error' => true, 'message' => 'Email not found !'], 404);
    }
    public function getUser($id)
    {
        $data = User::with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->with(array('superadmin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_super_admin_name"));
        }))->with('country_relation','province_relation','city_relation')->find($id);
        if($data)
            return response()->json(['error' => false,'message' => 'success get user by id','data' => $data],200);
        return response()->json(['error' => true,'message' => 'failed get user by id'],400);
        // $dataarray = [];
        // $dataarray = array(
        //     'id' => $user->id ,
        //     'id_role' => $user->type_user,
        //     'password' => $user->password,
        //     'pic_role' => $user->company_role,
        //     'business_name' => $user->business_name,
        //     'first_name' => $user->first_name,
        //     'last_name' => $user->last_name,
        //     'email' => $user->email,
        //     'mobile_phone' => $user->user_hp,
        //     'id_card_num' => $user->id_card_num,
        //     'user_hp' => $user->user_hp,
        //     'user_occupation' => $user->occupation,
        //     'user_address' => $user->address,
        //     'BI_status' => $user->status_bi_check,
        //     'country_res' => $user->country_residence,
        //     'gender' => $user->gender,
        //     'place_birth' => $user->place_birth,
        //     'date_birth' => $user->date_birth,
        //     'address' => $user->address,
        //     'country' => $user->user_country,
        //     'prov' => $user->user_prov,
        //     'city' => $user->user_city,
        //     'zip' => $user->user_zip,
        //     'citizen' => $user->user_citizen,
        //     'occupation' => $user->user_occupation,
        //     'tlp' => $user->user_tlp,
        //     'card_type' => $user->id_card_type,
        //     'card_num' => $user->id_card_num,
        //     'f_id_card' => $user->foto_id_card,
        //     'f_selfie' => $user->foto_selfie_id_card,
        //     'f_npwp' => $user->foto_npwp,
        //     'f_permit' => $user->foto_izin_company,
        //     'zip' => $user->user_zip,
        //     'citizen' => $user->user_citizen,
        //     'status' => $user->user_status,
        //     'last_login' => $user->last_login,
        //     'user_create_at' => $user->user_create_at,
        //     'approve_1' => $user->approve_1,
        //     // 'admin_name' => "$admin->first_name $admin->last_name",
        //     'approvedate_1' => $user->approvedate_1,
        //     'approve_2' => $user->approve_2,
        //     // 'super_admin_name' => "$superAdmin->first_name $superAdmin->last_name",
        //     'approvedate_2' => $user->approvedate_2,
        //     'status_bi_check' => $user->status_bi_check
        // );
        // if(!$user)
        // {
        //     return response()->json(['error' => true, 'message' => 'User not found!!'],400);
        // }else{
        //     return response()->json(['error' => false, 'message' => $dataarray]);
        // }
    }
    public function approveAdmin(Request $request,$user_id)
    {
        $validated = Validator::make($request->all(),[
            'approve_1' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true,'message' => $validated->errors()],400);
        }
        $check_admin = User::where('id',Auth::guard('admin-api')->user()->id)->get();
        // if(!$check_admin)
        //     return response()->json(['error' => true,'messsage' => 'Super admin not have access api'],401);
        $data = User::firstWhere('id',$user_id)->where('type_user',1)->where('type_user',2)->get();
        $carbon_date = Carbon::now('Asia/Jakarta');
        $description = 'User rejected by admin';
        $description2 = 'User approve by admin';
        if($data){
            $data = User::find($user_id);
            $data->approve_1 = $request->approve_1;
            $data->admin_approve_1 = $check_admin[0]->id;
            $data->approvedate_1 = $carbon_date;
            if($request->approve_1 == 'Approve'){
                LogVerification::create([
                    'user_id' => $user_id,
                    'description' => $description2,
                ]);
            }
            $data->save();
            if($request->approve_1 == 'Reject'){
                LogVerification::create([
                    'user_id' => $user_id,
                    'description' => $description,
                ]);
            }
            if($request->approve_1 == 'Reject')
            {
                return response()->json(['error' => false, 'message' => 'succes admin rejected user', 'data' => $data],200);

            }else{
                return response()->json(['error' => false, 'message' => 'succes admin approve user', 'data' => $data],200);
            }
        }
        else{
            return response()->json(['error' => true, 'message' => 'NotFound data'],404);
        }
    }
    public function approveSuperAdmin(Request $request,$user_id)
    {
        $validated = Validator::make($request->all(),[
            'approve_2' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true,'message' => $validated->errors()],400);
        }
        $check_admin = User::where('id',Auth::guard('admin-api')->user()->id)->get();
        $data = User::firstWhere('id',$user_id)->where('type_user',1)->where('type_user',2)->get();
        $carbon_date = Carbon::now('Asia/Jakarta');
        $description = 'User rejected by superadmin';
        $description2 = 'User approve by superadmin';
        $status_usr = "Your ID Verification Rejected please contact customer service";
        $status_usr1 = "Verification passed";
        if($data){
            $data = User::find($user_id);
            $data->approve_2 = $request->approve_2;
            $data->admin_approve_2 = $check_admin[0]->id;
            $data->approvedate_2 = $carbon_date;
            $data->user_status = $status_usr1;
            if($request->approve_2 == 'Approve')
            {
                LogVerification::create([
                    'user_id' => $user_id,
                    'description' => $description2,
                ]);
            }
            $data->save();
            if($request->approve_2 == 'Reject'){
                LogVerification::create([
                    'user_id' => $user_id,
                    'description' => $description,
                ]);
                $details = [
                    'title' => 'We are sory your accout rejected',
                    'url' => 'adaremit.co.id',
                    'full_name' => $data->first_name . ' ' . $data->last_name,
                ];
                Mail::to($data->email)->send(new RejectedMail($details));
                $data = User::find($user_id);
                $data->approve_1 = NULL;
                $data->approve_2 = NULL;
                $data->user_status =$status_usr;
                $data->save();
            }
            if($request->approve_2 == 'Reject')
            {
                return response()->json(['error' => false, 'message' => 'succes superadmin rejected user', 'data' => $data],200);

            }else{
                return response()->json(['error' => false, 'message' => 'succes superadmin approve user', 'data' => $data],200);
            }
        }
        else{
            return response()->json(['error' => true, 'message' => 'NotFound data'],404);
        }
    }
    public function getApproveadmin()
    {
        $data = User::where('admin_approve_1',NULL)->where('admin_approve_2',NULL)->where('type_user',1)->orWhere('type_user',2)->get();
        if($data)
            return response()->json(['error' => false,'message' => 'success get aprrove admin','data' => $data],200);
        return response()->json(['error' => true,'message' => 'failed get aprrove admin','data' => $data],400);
    }
    public function getApprovesuperadmin()
    {
        $data = User::where('admin_approve_1','<>',NULL)->where('admin_approve_2',NULL)->where('type_user',1)->orWhere('type_user',2)->with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->with(array('superadmin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_super_admin_name"));
        }))->get();
        if($data)
            return response()->json(['error'=>false,'message' => 'success get data approve superadmin','data' => $data],200);
        return response()->json(['error' => true, 'message' => 'failed get data approve superadmin','data' => $data],400);
    }
    public function getUserKYC()
    {
        $data = User::where('type_user',1)->orWhere('type_user',2)->with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->get();
        if($data)
            return response()->json(['error'=>false,'message' => 'success get data kyc ','data' => $data],200);
        return response()->json(['error' => true, 'message' => 'failed get data kyc','data' => $data],400);
    }
    public function getUserApprove($start_date,$end_date)
    {
        $data = User::where('deleted_at',null)->where('type_user',1)->orWhere('type_user',2)->where('approve_1','Approve')->where('approve_2','Approve')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->with(array('superadmin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_super_admin_name"));
        }))->get();
        return $data;
    }
    public function getUserData($start_date,$end_date)
    {
        $data = User::where('deleted_at',null)->where('type_user',1)->orWhere('type_user',2)->where('approve_2','<>',null)->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->with(array('superadmin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_super_admin_name"));
        }))->get();
        return $data;

    }
    protected function genereteCode()
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, 8);
    }
}
