<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminInsertUserRequest;
use App\Http\Requests\LogRequest;
use App\Http\Requests\PictureRequest;
use App\Models\Grad;
use App\Models\Korisnik;
use App\Models\Uloga;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $model;
    private $date;
    private $result;
    public function __construct()
    {
        $this->model = new Korisnik();
        $this->date = date("d.m.Y H:i:s");
        $city = new Grad();
        $roles = new Uloga();
        $this->result['uloge'] = $roles->getRoles();
        $this->result['gradovi'] = $city->getAll();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            try{
                $result = $this->model->getUsers();
                return view("pages.korisnici")->with("korisnici", $result);
            }
            catch(QueryException $sql){
                Log::critical("Greska pri ucitavanju sponzora ".$this->date);
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
        return view("pages.dodaj-korisnika",$this->result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminInsertUserRequest $request)
    {
        $username = $request->input("username");
        $password = $request->input("password");
        $firstname = $request->input("firstname");
        $lastname = $request->input("lastname");
        $email = $request->input("email");
        $city = $request->input("city");
        $gender = $request->input("gender");
        $roll = $request->input("roll");
        $active = $request->input("active");
        $token = md5($username.time());
        $this->model->setUsername($username);
        $this->model->setPassword($password);
        $this->model->setIme($firstname);
        $this->model->setPrezime($lastname);
        $this->model->setEmail($email);
        $this->model->setIDGrad($city);
        $this->model->setPol($gender);
        $this->model->setIDUloga($roll);
        $this->model->setAktivan($active);
        $this->model->setDatumRegistracije($this->date);
        $this->model->setToken($token);
        try{
            $this->model->insert();
            return response(null,201);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri upisivanju korisnika od strane admina! ".$this->date);
            return response(null, 409);
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
        $this->model->setIDKorisnik($id);
        try{
            $podaci = $this->model->getOneUser();
            return view("pages.izmeni-korisnika",$this->result)->with("podaci", $podaci);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri dohvatnju jednog korisnika ".$this->date);
            return redirect(route('user-show'))->with("error",true);
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
        $username = $request->input("username");
        $password = $request->input("password");
        $firstname = $request->input("firstname");
        $lastname = $request->input("lastname");
        $email = $request->input("email");
        $city = $request->input("city");
        $gender = $request->input("gender");
        $roll = $request->input("roll");
        $active = $request->input("active");
        $status = $request->input("status");
        $this->model->setIDKorisnik($id);
        $this->model->setUsername($username);
        $this->model->setPassword($password);
        $this->model->setIme($firstname);
        $this->model->setPrezime($lastname);
        $this->model->setEmail($email);
        $this->model->setIDGrad($city);
        $this->model->setPol($gender);
        $this->model->setIDUloga($roll);
        $this->model->setAktivan($active);
        $this->model->setObrisan($status);
        $this->model->setDatumIzmene($this->date);

        try{
            $this->model->update();
            return response(null,204);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri izmeni korisnika na dan $this->date sa id: ".$id);
            return response(null,409);
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
        $this->model->setIDKorisnik($id);
        try{
            $this->model->delete();
            return response(null,204);
        }
        catch(QueryException $sql){
            Log::critical("Greska pri brisanju korisnika na dan $this->date sa id: $id");
            return response(null,500);
        }
    }
}
