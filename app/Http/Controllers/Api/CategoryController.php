<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends MasterController
{
    public function __construct(Category $model)
    {
        $this->model = $model;
        $this->route = 'category';
        parent::__construct();
    }
    public function index(Request $request)
    {
        //auth
        $check_token=$this->check_apiToken($request->header('apiToken'));
        if($check_token){
            return $check_token;
        }
        //auth
        $rows = $this->model->where('parent_id',null)->active()->latest()->get();
        $data=[];
        foreach ($rows as $row){
            $arr=$row->static_model();
            $data[]=$arr;
        }
        return response()->json(['status' => 200,'data'=>$data]);
    }
}
