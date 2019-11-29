<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Service;
use App\User;
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
        $rows = $this->model->where('parent_id',null)->active()->latest()->get();
        $categories=[];
        foreach ($rows as $row){
            $arr=$row->static_model();
            $count_services=0;
            foreach ($row->child as $item){
                $count_services+=count($item->services);
            }
            $arr['services_count']=$count_services;
            $categories[]=$arr;
        }
        $response['categories']=$categories;
        $response['offers']=[];
        return response()->json(['status' => 200,'data'=>$response]);
    }
    public function show($id, Request $request)
    {
        $row = $this->model->find($id);
        if (!$row) {
            return response()->json(['status' => 400,'msg'=>'something happened']);
        }
        $base_category_obj=$row->static_model();
        $sub_categories=[];
        foreach ($row->child as $child){
            $sub_category_obj=$child->static_model();
            $sub_categories[]=$sub_category_obj;
        }
        $base_category_obj['sub_categories']=$sub_categories;
        return response()->json(['status' => 200, 'data' => $base_category_obj]);
    }
    public function services($id)
    {
        $row = $this->model->find($id);
        if (!$row) {
            return response()->json(['status' => 400,'msg'=>'something happened']);
        }
        $services=Service::where('category_id',$id)->active()->latest()->get();
        $data=[];
        foreach ($services as $service){
            $arr=$service->static_model();
            $data[]=$arr;
        }
        return response()->json(['status' => 200, 'data' => $data]);
    }
    public function search($id,Request $request)
    {
        $row = $this->model->find($id);
        if (!$row) {
            return response()->json(['status' => 400,'msg'=>'something happened']);
        }
        $services=Service::where('category_id',$id)->where('name->ar', 'LIKE', '%'.$request['name'].'%')
            ->orWhere('name->en', 'LIKE', '%'.$request['name'].'%')
            ->get();
        $data=[];
        foreach ($services as $service){
            $arr=$service->static_model();
            $data[]=$arr;
        }
        return response()->json(['status' => 200, 'data' => $data]);
    }

}
