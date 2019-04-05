<?php

namespace App\Http\Controllers\Admin;

use App\Models\Glumci;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    private $model;
    private $date;
    public function __construct()
    {
        $this->model = new Glumci();
        $this->date = date("d.m.Y H:i:s");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['glumci'] =  $this->model->getAll();
        return view("pages.glumci" ,$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.dodaj-glumca");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $first = $request->input("first");
        $last = $request->input("last");
        $this->model->setIme($first);
        $this->model->setPrezime($last);
        try{
            $this->model->insert();
            return response(null,201);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri ubacivanje glumca na dan $this->date");
            return response(null,422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->model->setIDGlumci($id);
        try{
           $result['podaci'] = $this->model->getOne();
            return view("pages.izmena-glumca",$result);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri dohvatanju glumca na dan $this->date sa id: $id");
            return  view("pages.izmena-sponzora")->with("error",true);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->model->setIDGlumci($id);
        $first = $request->input("first");
        $last = $request->input("last");
        $this->model->setIme($first);
        $this->model->setPrezime($last);
        try{
            $this->model->update();
            return response(null,204);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri izmni korisnika na dan $this->date sa id: $id");
            return response(null, 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model->setIDGlumci($id);
        try{
            $this->model->delete();
            return response(null,204);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri brisanju glumca na dan $this->date sa id: $id");
            return response(null,409);
        }
    }
}
