<?php

namespace App\Http\Controllers;

use App\Models\GlasanjeSerija;
use App\Models\Izvestaj;
use App\Models\Serija;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;


class SeriesController extends FrontendController
{
    private $date;
    private $activity;
    public function __construct()
    {
        parent::__construct();
        $this->model = new Serija();
        $this->date = date("d.m.Y H:i:s");
        $this->activity = new Izvestaj();
    }

    public function newest()
    {
        $serija = $this->model->getNewestSeries();
        return view('pages.pocetna', $this->data)->with("serije", $serija);
    }

    public function dislike(Request $request)
    {
        $user = $request->input("user");
        $series = $request->input("series");
        $this->model->setIDSerija($series);
        $this->model->setIDKorisnik($user);
        try {
            $this->model->dislike();
            $this->activity->setIDKorisnik($user);
            $this->activity->setDatum($this->date);
            $this->activity->insert("Ocenio seriju sa negativnom ocenom");
            return response(null, 204);
        } catch (QueryException $sql) {
            Log::critical("Greska pri dislajku serije " . date("d-m-Y H:i:s") . " ID_serije " . $series);
            return response(null, 409);
        }
    }

    public function like(Request $request)
    {
        $user = $request->input("user");
        $series = $request->input("series");
        $this->model->setIDSerija($series);
        $this->model->setIDKorisnik($user);

        try {
            $this->model->like();
            $this->activity->setIDKorisnik($user);
            $this->activity->setDatum($this->date);
            $this->activity->insert("Ocenio seriju sa pozitivnom ocenom");
            return response(null, 204);
        } catch (QueryException $sql) {
            Log::critical("Greska pri lajku serije " . date("d-m-Y H:i:s") . " ID_serije " . $series);
            return response(null, 409);
        }
    }

    public function show($id){
        $this->model->setIDSerija($id);
        try {
            $podaci = $this->model->getOne();
            $glumci = $this->model->getRoles();
            if (session()->has('user')) {
                $user = session()->get("user");
                return response(["podaci" => $podaci, "glumci" => $glumci ,"korisnik" => $user], 200);
            }
            else
                return response(["podaci" => $podaci, "glumci" => $glumci], 200);
        }
        catch (QueryException $sql) {
            Log::critical("Greska pri dohvatnaju infomracija za seriju sa id: $id na dan $this->date");
            return response(null, 409);
        }
    }
    public function search($char){

        $this->model->setSerijaNaziv($char);
        try{
            $podaci = $this->model->search();
            if (session()->has('user')) {
                $user = session()->get("user");
                return response(["podaci" => $podaci, "korisnik" => $user], 200);
            }
            else
                return response(["podaci" => $podaci], 200);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri pretrazi sa kriterijumom $char na dan $this->date");
            return response(null,404);
        }
    }
}
