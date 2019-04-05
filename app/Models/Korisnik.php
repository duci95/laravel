<?php
/**
 * Created by PhpStorm.
 * User: Dušan
 * Date: 23.2.2019.
 * Time: 15.10
 */

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Korisnik
{
    private $ID_korisnik;
    private $ime;
    private $prezime;
    private $email;
    private $username;
    private $password;
    private $token;
    private $pol;
    private $aktivan;
    private $datum_registracije;
    private $datum_izmene;
    private $obrisan;
    private $ID_grad;
    private $ID_uloga;
    private $table = "korisnik";
    /**
     * @return mixed
     */
    public function getIDKorisnik()
    {
        return $this->ID_korisnik;
    }

    /**
     * @param mixed $ID_korisnik
     */
    public function setIDKorisnik($ID_korisnik): void
    {
        $this->ID_korisnik = $ID_korisnik;
    }

    /**
     * @return mixed
     */
    public function getIme()
    {
        return $this->ime;
    }

    /**
     * @param mixed $ime
     */
    public function setIme($ime): void
    {
        $this->ime = $ime;
    }

    /**
     * @return mixed
     */
    public function getPrezime()
    {
        return $this->prezime;
    }

    /**
     * @param mixed $prezime
     */
    public function setPrezime($prezime): void
    {
        $this->prezime = $prezime;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getPol()
    {
        return $this->pol;
    }

    /**
     * @param mixed $pol
     */
    public function setPol($pol): void
    {
        $this->pol = $pol;
    }

    /**
     * @return mixed
     */
    public function getAktivan()
    {
        return $this->aktivan;
    }

    /**
     * @param mixed $aktivan
     */
    public function setAktivan($aktivan): void
    {
        $this->aktivan = $aktivan;
    }

    /**
     * @return mixed
     */
    public function getDatumRegistracije()
    {
        return $this->datum_registracije;
    }

    /**
     * @param mixed $datum_registracije
     */
    public function setDatumRegistracije($datum_registracije): void
    {
        $this->datum_registracije = $datum_registracije;
    }

    /**
     * @return mixed
     */
    public function getDatumIzmene()
    {
        return $this->datum_izmene;
    }

    /**
     * @param mixed $datum_izmene
     */
    public function setDatumIzmene($datum_izmene): void
    {
        $this->datum_izmene = $datum_izmene;
    }

    /**
     * @return mixed
     */
    public function getObrisan()
    {
        return $this->obrisan;
    }

    /**
     * @param mixed $obrisan
     */
    public function setObrisan($obrisan): void
    {
        $this->obrisan = $obrisan;
    }

    /**
     * @return mixed
     */
    public function getIDGrad()
    {
        return $this->ID_grad;
    }

    /**
     * @param mixed $ID_grad
     */
    public function setIDGrad($ID_grad): void
    {
        $this->ID_grad = $ID_grad;
    }

    /**
     * @return mixed
     */
    public function getIDUloga()
    {
        return $this->ID_uloga;
    }
    /**
     * @param mixed $ID_uloga
     */
    public function setIDUloga($ID_uloga): void
    {
        $this->ID_uloga = $ID_uloga;
    }
    public function login(){
        $query = DB::table($this->table)->where([["username",$this->username],
            ["password",md5($this->password)],
            ["aktivan",1],
            ["obrisan",0]
        ])->first();
        return $query;
    }
    public function register(){
        $query = DB::table($this->table)->insert([
            "ime" => $this->ime,
            "prezime" => $this->prezime,
            "email" =>$this->email,
            "username" => $this->username,
            "password" => md5($this->password),
            "token" => $this->token,
            "pol" => $this->pol,
            "datum_registracije" => $this->datum_registracije,
            "ID_grad" => $this->ID_grad,
            "ID_uloga" => 2
        ]);
        return $query;
    }
    public function getUsers(){
        $query = DB::table($this->table)->get();
        return $query;
    }
    public function insert(){
        $query = DB::table($this->table)->insert([
            "ime" => $this->ime,
            "prezime" => $this->prezime,
            "email" =>$this->email,
            "username" => $this->username,
            "password" => md5($this->password),
            "token" => $this->token,
            "pol" => $this->pol,
            "datum_registracije" => $this->datum_registracije,
            "ID_grad" => $this->ID_grad,
            "ID_uloga" => $this->ID_uloga,
            "aktivan" => $this->aktivan
        ]);
        return $query;
    }
    public function getOneUser(){
        $query = DB::table("korisnik as k")
            ->join("uloga as u","k.ID_uloga","=","u.ID_uloga")
            ->join("grad as g","k.ID_grad","=","g.ID_grad")
            ->where("ID_korisnik",$this->ID_korisnik)->get();
        return $query;
    }
    public function update(){
        $query = DB::table($this->table)->where("ID_korisnik",$this->ID_korisnik)
            ->update([
                "ime" => $this->ime,
                "prezime" => $this->prezime,
                "email" =>$this->email,
                "username" => $this->username,
                "password" => md5($this->password),
                "pol" => $this->pol,
                "datum_izmene" => $this->datum_izmene,
                "ID_grad" => $this->ID_grad,
                "ID_uloga" => $this->ID_uloga,
                "aktivan" => $this->aktivan,
                "obrisan" => $this->obrisan
            ]);
    }
    public function delete(){
        DB::table($this->table)->where("ID_korisnik", $this->ID_korisnik)->update(["obrisan" => 1]);
    }

    public function activate(){
        DB::table($this->table)->where("token", $this->token)->update([
           "aktivan" => 1
        ]);
    }

}
