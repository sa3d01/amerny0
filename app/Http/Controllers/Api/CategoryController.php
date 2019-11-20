<?php

namespace App\Http\Controllers\Api;

use App\Category;

class CategoryController extends MasterController
{
    public function __construct(Category $model)
    {
        $this->model = $model;
        $this->route = 'category';
        parent::__construct();
    }

}
