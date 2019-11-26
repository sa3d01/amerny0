<?php

namespace App\Http\Controllers\Api;

use App\SavedPlaces;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends MasterController
{
    public function __construct(User $model)
    {
        $this->model = $model;
        $this->route = 'user';
        parent::__construct();
    }
    public function validation_rules($method,$id=null)
    {
        if($method==2){
            $rules['mobile'] ='unique:users,mobile,'.$id;
            $rules['email'] ='email|max:255|unique:users,email,'.$id;
        }else{
            $rules = [
                'mobile' => 'required|unique:users',
                'device_token'=>'required',
            ];
        }
        return $rules;
    }
    public function validation_messages($lang='ar')
    {
        $messsages = array(
            'email.unique'=>'هذا البريد مسجل بالفعل',
            'mobile.unique'=>'هذا الهاتف مسجل بالفعل',
            'mobile.required'=>'يجب ادخال رقم الهاتف',
        );
        return $messsages;
    }
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), ['mobile' => 'required']);
        if ($validate->fails()) {
            return response()->json(['status' => 400, 'msg' => 'رقم الجوال مطلوب']);
        }
        $all=$request->all();
        $user = User::where('mobile', $request['mobile'])->first();
        if($user && $user->status==1){
            $this->update_apiToken($user);
            $user->refresh();
            return response()->json(['status' => 200,'data' => $user->static_model()]);
        }else{
            $activation_code = rand(1111,9999);
            if(!$user){
                $validator = Validator::make($request->all(),$this->validation_rules(1),$this->validation_messages($request->header('lang')));
                if ($validator->fails()){
                    return response()->json(['status' => 400, 'msg' =>$validator->errors()->first()]);
                }
                $all['activation_code']=$activation_code;
                $user=$this->model->create($all);
            }else{
                $user->update(['activation_code'=>$activation_code]);
            }
            $user->refresh();
            $this->update_apiToken($user);
            $msg= ' كود التفعيل الخاص بآمرنى'.$activation_code;
            //   $user->sendMessage($msg,$user->mobile);
            $user->refresh();
            return response()->json(['status' => 200,'data' => $user->static_model()]);
        }
    }
    public function resend_code(Request $request)
    {
        $validate = Validator::make($request->all(), ['mobile' => 'required']);
        if ($validate->fails()) {
            return response()->json(['status' => 400, 'msg' => 'رقم الجوال مطلوب']);
        }
        $user = User::where('mobile', $request['mobile'])->first();
        if ($user) {
            $activation_code = rand(1111,9999);
            $user->activation_code=$activation_code;
            $this->update_apiToken($user);
            $user->update();
            $msg= ' كود التفعيل الخاص بآمرنى'.$activation_code;
            //   $user->sendMessage($msg,$user->mobile);
           return response()->json(['status' => 200,'data'=>$user->static_model()]);
        } else {
            return response()->json(['status' => 400, 'msg' => 'هذا الهاتف غير مسجل من قبل']);
        }
    }
    public function activate(Request $request)
    {
        //auth
        $check_token=$this->check_apiToken($request->header('apiToken'));
        if($check_token){
            return $check_token;
        }
        $split = explode("sa3d01",$request->header('apiToken'));
        $user=User::where('apiToken',$split['1'])->first();
        if(!$request['activation_code'] || ($user->activation_code!=$request['activation_code'])){
            return response()->json(['status' => 400, 'msg' => 'رقم التفعيل غير صحيح']);
        }
        $user->update(['status'=>1,'activation_code'=>null]);
        $user->refresh();
        return response()->json(['status' => 200, 'data' => $user->static_model()]);
    }
    public function save_place(Request $request)
    {
        //auth
        $check_token=$this->check_apiToken($request->header('apiToken'));
        if($check_token){
            return $check_token;
        }
        $split = explode("sa3d01",$request->header('apiToken'));
        $user=User::where('apiToken',$split['1'])->first();
        $validate = Validator::make($request->all(), ['lat' => 'required','lng' => 'required','address' => 'required','title' => 'required']);
        if ($validate->fails()) {
            return response()->json(['status' => 400, 'msg' => 'حدثت مشكلة ما!']);
        }
        $saved_place=SavedPlaces::where(['title'=>$request['title'],'user_id'=>$user->id])->first();
        if(!$saved_place){
            $saved_place=new SavedPlaces();
            $saved_place->user_id=$user->id;
        }
        $address['lat']=$request['lat'];
        $address['lng']=$request['lng'];
        $address['address']=$request['address'];
        $saved_place->address=$address;
        $saved_place->title=$request['title'];
        $saved_place->save();
        return response()->json(['status' => 200,'data' => $user->static_model()]);
    }
    public function update_profile(Request $request)
    {
        $check_token=$this->check_apiToken($request->header('apiToken'));
        if($check_token){
            return $check_token;
        }
        $split = explode("sa3d01",$request->header('apiToken'));
        $user=User::where('apiToken',$split['1'])->first();
        //auth
        $validator = Validator::make($request->all(),$this->validation_rules(2,$user->id),$this->validation_messages());
        if ($validator->passes()) {
            $all=$request->all();
            $user->update($all);
            $user->refresh();
            return response()->json(['status' => 200,'data' => $user->static_model()]);
        }else{
            return response()->json(['status' => 400, 'msg' =>$validator->errors()->first()]);
        }
    }
}
