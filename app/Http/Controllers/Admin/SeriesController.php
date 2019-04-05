<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminInsertSeriesRequest;
use App\Http\Requests\PictureRequest;
use App\Models\Glumci;
use App\Models\Link;
use App\Models\Serija;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class SeriesController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Serija();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $podaci = $this->model->getAll();
        return view('pages.serije-spisak')->with('serije', $podaci);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $link = new Link();
        $m = new Glumci();
        $cat = $link->getCategories();
        $roles = $m->getAll();
        return view('pages.dodaj-seriju')
            ->with('kategorije' , $cat)
            ->with('glumci', $roles);
    }


    public function store(AdminInsertSeriesRequest $request)
    {
        $name = $request->input('name');
        $year = $request->input('year');
        $cat = $request->input('category');
        $roles = $request->input('glumci');


        $text = $request->input('text');
        $pic = $request->file('img');
        $ime = "images/".time()."_".$pic->getClientOriginalName();

        $this->model->setSerijaNaziv($name);
        $this->model->setSerijaTekst($text);
        $this->model->setGodina($year);
        $this->model->setIDLink($cat);
        $this->model->setSlika($ime);

        try {
            if($pic->isValid()) {
                $pic->move(public_path("images/"),  $ime);
                $id = $this->model->insert();
                foreach($roles as $role) {
                    $this->model->setIDGlumci($role);
                    $this->model->setIDSerija($id);
                    $this->model->insertCredits();
                }
                return redirect()->back()->with("uspeh", "Uspešno ste dodali sponzora");
            }
        }
        catch(QueryException $sql){
            Log::critical("Greska pri ubacivanju serije u bazu!");
            return redirect()->back()->with("error", "Doslo je do greske, kontaktirajte admina!")
                ->withInput();
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
    public function edit($id, $cat)
    {
        $this->model->setIDSerija($id);
        $link = new Link();
        $link->setIDLink($cat);
        try{
            $podaci['serija'] = $this->model->getOne();
            $glumac = new Glumci();
            $podaci['svi_glumci'] = $glumac->getAll();
            $podaci['glumci'] =  $this->model->getRoles();

            $podaci['kategorije'] = $link->getOtherCategoreis();
            return view('pages.izmena-serije', $podaci);
        }
        catch(QueryException $sql){
            Log::critical('Greška pri dohvatanju informacija za seriju sa id: '.$id);
            return redirect()->back()->with("error", "Doslo je do greske, kontaktirajte admina!");
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model->setIDSerija($id);
        try{
            $this->model->delete();
            return response(null, 204);
        }
        catch(QueryException $sql){
            Log::critical('greska pri brisanju serije sa id:'.$id);
            return response(null, 500);
        }

    }

    public function updateInfo($id, Request $request)
    {
        $text = $request->input('text');
        $name = $request->input('name');
        $year = $request->input('year');
        $category = $request->input('category');
        $status = $request->input('status');
        $roles = $request->input('glumci');

        $this->model->setIDSerija($id);
        $this->model->setSerijaTekst($text);
        $this->model->setSerijaNaziv($name);
        $this->model->setGodina($year);
        $this->model->setIDLink($category);
        $this->model->setObrisan($status);

        try{
            $this->model->updateInfo();
            foreach($roles as $role) {
                $this->model->setIDSerija($id);
                $this->model->setIDGlumci($role);
                $this->model->updateCreditsFirstStep();
            }
            foreach($roles as $role) {
                $this->model->setIDSerija($id);
                $this->model->setIDGlumci($role);
                $this->model->updateCreditsFinalStep();
            }
        return redirect(route('series-show'))->with('uspeh', "Uspešno ste izmenili seriju");
        }
        catch(QueryException $sql){
            Log::critical('Greska pri izmeni serije sa id'.$id.$sql->getMessage());
            return redirect(route('series-show'))->with('error', "Došlo je od greške konaktirajte admina");
        }

    }
    public function updatePicture($id, PictureRequest $picture)
    {
            $this->model->setIDSerija($id);
            $image = $picture->file('img');
            $ime = "images/".time().'_'.$image->getClientOriginalName();
            public_path("images/");
            if($image->isValid()){
                $image->move(public_path('images/'),$ime);
                $this->model->setSlika($ime);
                try{
                    $this->model->updatePicture();
                    return redirect(route('series-show'))->with('uspeh', "Uspešno ste izmenili sliku ");
                }
                catch(QueryException $sql){
                    Log::critical('Greska pri izmeni slike za seriju sa id:'.$id);
                    return redirect(route('series-show'))->with('error', "Došlo je od greške konaktirajte admina");
                }
            }
    }
}
