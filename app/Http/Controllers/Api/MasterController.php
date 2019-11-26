<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\User;
use Auth;
use App\Http\Middleware\CheckApiToken;
class MasterController extends Controller
{
    /**
     *basic requirements
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
        $this->middleware(CheckApiToken::class);
    }
    public function update_apiToken($user)
    {
        $user->update(['apiToken'=>Str::random(80)]);
    }
    public function index(Request $request)
    {
        //auth
        $check_token=$this->check_apiToken($request->header('apiToken'));
        if($check_token){
            return $check_token;
        }
        //auth
        $rows = $this->model->active()->latest()->get();
        $data=[];
        foreach ($rows as $row){
            $arr=$row->static_model();
            $data[]=$arr;
        }
        return response()->json(['status' => 200,'data'=>$data]);
    }
    public function show($id, Request $request)
    {
        //auth
        $check_token=$this->check_apiToken($request->header('apiToken'));
        if($check_token && $this->apiToken == true){
            return $check_token;
        }
        //auth
        $row = $this->model->find($id);
        if (!$row) {
            return response()->json(['status' => 400,'msg'=>'something happen']);
        }
        $split = explode("sa3d01",$request->header('apiToken'));
        $user=User::where('apiToken',$split['1'])->first();
        return response()->json(['status' => 200, 'data' => $row->static_model()]);
    }
}
