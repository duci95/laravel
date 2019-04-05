<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Models\Link;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GenreController extends Controller
{
    private $model;
    private $date;
    public function __construct(){
        $this->model = new Link();
        $this->date = date("d.m.Y H:i:s");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['kategorije'] = $this->model->getCategories();
        return view("pages.kategorije",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.dodaj-kategoriju");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GenreRequest $request)
    {
            $name = $request->input("category");
            $this->model->setNaziv($name);
            $this->model->setPutanja(strtolower($name));
            try {
                $this->model->insert();
                return response(null,201);
            }
            catch(QueryException $sql){
                Log::critical("Greska pri ubacivanju nove kategorije na dan ".$this->date);
                return response(null, 500);
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
        $this->model->setIDLink($id);
        $result = $this->model->getOne();
        try{
            return view("pages.izmena-kategorije")->with("podaci",$result);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri izmeni dohvatanju podatka za  kategoriju na dan $this->date sa id: $id");
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GenreRequest $request, $id)
    {
        $name = $request->input("category");
        $this->model->setIDLink($id);
        $this->model->setNaziv($name);
        $this->model->setPutanja(strtolower($name));

        try{
            $this->model->update();
            return response(null, 204);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri izmeni kategorije na dan $this->date za kategoriju sa id: $id");
            return response(null,500);
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
        $this->model->setIDLink($id);
        try{
            $this->model->delete();
            return response(null,204);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri brisanju kategorije na dan $this->date za kategoiju sa id: $id");
            return response(null,500);
        }
    }
}
