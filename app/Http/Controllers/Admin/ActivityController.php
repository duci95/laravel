<?php

namespace App\Http\Controllers\Admin;

use App\Models\Izvestaj;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index(){
        $m = new Izvestaj();
        $a['data'] =  $m->getAll();
        return view('pages.izvestaj', $a);
    }
}
