<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Serija;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriesController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Serija();
    }

    public function show($cat)
    {

        $this->model->setPutanja($cat);
        $category = $this->model->getSeriesByCategory();
        return view("pages.serije",$this->data)->with("serije", $category);
    }



}
