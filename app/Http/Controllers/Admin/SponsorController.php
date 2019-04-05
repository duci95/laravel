<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PictureRequest;
use App\Http\Requests\SponsorRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Models\Sponzor;
use Illuminate\Support\Facades\Log;

class SponsorController extends Controller
{
    private $model;
    private $date;
    public function __construct()
    {
        $this->model = new Sponzor();
        $this->date = date("d.m.Y H:i:s");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $result = $this->model->getSponsors();
            return view("pages.sponzori")->with("sponzori", $result);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri ucitavanju sponzora");
            return redirect()->back();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dodaj-sponzora');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SponsorRequest $request, PictureRequest $pictureRequest)
    {
        $link = $request->input('link');
        $slika = $pictureRequest->file("img");
        $ime = "images/".time()."_".$slika->getClientOriginalName();
        $this->model->setLink($link);
        $this->model->setSlika($ime);
        try {
            if($slika->isValid()) {
                $slika->move(public_path("images/"),  $ime);
                $this->model->insertSponsor();
                return redirect()->back()->with("uspeh", "Uspešno ste dodali sponzora");
            }
            else{
                    return redirect()->back();
                }
            }
        catch(QueryException $sql){
                Log::critical("Greska pri ubacivanju sponzora u bazu!".$this->date);
                return redirect()->back()->with("error", "Doslo je do greske, kontaktirajte admina!");
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
        $this->model->setIDSponsor($id);

        try {
            $result['podaci'] = $this->model->getOneSponsor();
            return view("pages.izmena-sponzora",$result);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri dohvatanju jednog sponzora za izmenu". $this->date);
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
    public function updateLink(SponsorRequest $request, $id)
    {
        $link = $request->input('link');
        $this->model->setLink($link);
        $this->model->setIDSponsor($id);
        try {
            $this->model->updateLink();
            return redirect(route("sponsor-show"))->with("uspeh",true);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri izmeni linka za sponzora". $this->date);
            return  redirect(route("sponsor-show"))->with("error", true);
        }

    }
    public function updatePicture(PictureRequest $pictureRequest, $id){

        $picture = $pictureRequest->file("img");
        $name = time()."_".$picture->getClientOriginalName();
        $this->model->setSlika($name);
        $this->model->setIDSponsor($id);
        $p =  public_path("\images");

        try{
            if($picture->isValid()){
                dd($p);
                $picture->move(public_path("\images"),$name);
                $this->model->updatePicture();
                return redirect(route("sponsor-show"))->with("uspeh", true);
            }
        }
        catch(QueryException $sql){
            Log::critical("Greska pri izmeni slike za sponzora". $this->date);
            return  redirect(route("sponsor-show"))->with("error",true);
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
        $this->model->setIDSponsor($id);
        try{
            $this->model->deleteSponsor();
            return response("Uspešno ste obrisali sponzora",204);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri brisanju sponzora sa id: ".$id. " " . $this->date);
            return response("Greska pri brisanju sponzora", 409);
        }
    }
}
