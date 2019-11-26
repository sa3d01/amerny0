<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Order;
use App\Service;
use App\Shift;
use App\User;
use Illuminate\Http\Request;

class OrderController extends MasterController
{
    public function __construct(Order $model)
    {
        $this->model = $model;
        $this->route = 'order';
        parent::__construct();
    }
    public function shifts(Request $request)
    {
        $rows = Shift::active()->latest()->get();
        $data=[];
        foreach ($rows as $row){
            $data[]=$row->static_model();
        }
        return response()->json(['status' => 200,'data'=>$data]);
    }

}
