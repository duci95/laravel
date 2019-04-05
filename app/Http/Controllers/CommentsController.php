<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendCommentRequest;
use App\Models\Izvestaj;
use App\Models\Komentar;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentsController extends Controller
{
    private $model;
    private $activity;

    public function __construct()
    {
        $this->activity = new Izvestaj();
        $this->model = new Komentar();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SendCommentRequest $request)
    {
        $comment = $request->input('comment');
        $user = $request->input('iduser');
        $series = $request->input('idseries');

        $this->model->setIDSerija($series);
        $this->model->setIDKorisnik($user);
        $this->model->setKomentarTekst($comment);

        $this->model->setDatum(date('d.m.Y H:i'));

        try{
            $this->model->insert();
            $this->activity->setIDKorisnik($user);
            $this->activity->setDatum(date('d.m.Y H:i'));
            $this->activity->insert("Komentarisao seriju");
            return response(null, 201);
        }

        catch(QueryException $sql){
            Log::critical("Greska pri ubacivanju komentara za seriju sa id: $series od strane korisnika $user ");
            return response(null, 409);
        }

    }

    public function showSeriesComments($idseries)
    {
        $this->model->setIDSerija($idseries);
        try{
            $podaci = $this->model->getSeriesComments();
            if(session()->has('user')){
                $sesija = session()->get('user');
                return response(["podaci" => $podaci, "sesija" => $sesija],200);
            }
            else{
                return response(["podaci" => $podaci],200);
            }
        }

        catch(QueryException $sql){
            Log::critical("Greska kod prikaza serije sa id: $idseries");
            return response(null, 409);
        }

    }

    public function delete(Request $request)
    {
        $user = $request->input('user');
        $com = $request->input('com');
        $this->model->setIDKorisnik($user);
        $this->model->setIDKomentar($com);
        try{
            $this->model->delete();
            $this->activity->setIDKorisnik($user);
            $this->activity->setDatum(date('d.m.Y H:i:s'));
            $this->activity->insert('Obrisao komentar');
            response(null, 204);
        }

        catch(QueryException $sql){
            Log::critical('Greška pri brisanju komnetar sa id '.$com.'za korisnika sa id:'.$user);
            response(null, 409);
        }

    }
    public function like(Request $request){
        $user = $request->input('user');
        $com = $request->input('com');
        $this->model->setIDKorisnik($user);
        $this->model->setIDKomentar($com);

        try{
            $this->model->like();
            $this->activity->setDatum(date(('d.m.Y H:i')));
            $this->activity->setIDKorisnik($user);
            $this->activity->insert("Ocenio komentar sa pozitivnom ocenom");
            return response(null, 201);
        }

        catch(QueryException $sql){
            Log::critical("Greska pri lajkovanju komentara sa id: $com");
            return response(null, 409);
        }

    }

    public function dislike(Request $request){

        $user = $request->input('user');
        $com = $request->input('com');
        $this->model->setIDKorisnik($user);
        $this->model->setIDKomentar($com);

        try{
            $this->model->dislike();
            $this->activity->setDatum(date(('d.m.Y H:i')));
            $this->activity->setIDKorisnik($user);
            $this->activity->insert("Ocenio komentar sa negativnom ocenom");

            return response(null, 201);
        }

        catch(QueryException $sql){
            Log::critical("Greska pri dislajkovanju komentara sa id: $com");
            return response(null, 409);
        }

    }
}
