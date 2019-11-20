<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use Auth;
class MasterController extends Controller
{
    /**
     *basic requirements
    all active data like users or categories with its relations
    specific shop or user with relations
    search
    delete item
    add item
    edit item
    register,login,update_profile and forget password
     */

    protected $model;
    protected $route;
    protected $perPage = 10;
    protected $apiToken;

    public function __construct()
    {
        $this->middleware(function($request, $next){
            $this->auth = Auth::guard('api')->user();
            return $next($request);
        });
    }
    public function check_apiToken($apiToken)
    {
        if($apiToken){
            try{
                $split = explode("sa3d01",$apiToken);
                $user=User::where('apiToken',$split['1'])->first();
            }catch (\Exception $e){
                return response()->json(['status' => 401 ,'msg' => 'Invalid authentication token in request']);
            }
            if(!$user){
                return response()->json(['status' => 401 ,'msg' => 'Invalid authentication token in request ']);
            }
        }else{
            return response()->json(['status' => 401 ,'msg' => 'Invalid authentication token in request ']);
        }
    }
    public function index(Request $request)
    {
        //auth
        $check_token=$this->check_apiToken($request->header('apiToken'));
        if($check_token){
            return $check_token;
        }
        //auth
        $rows = $this->model->latest()->get();
        $data=[];
        foreach ($rows as $row){
            $arr=$row->static_model();
            $data[]=$arr;
        }
        return response()->json(['status' => 200,'data'=>$data]);
    }

}
