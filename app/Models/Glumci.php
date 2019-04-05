<?php
/**
 * Created by PhpStorm.
 * User: Dušan
 * Date: 8.3.2019.
 * Time: 16.42
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Glumci
{
    private $ID_glumci;
    private $ime;
    private $prezime;

    /**
     * @return mixed
     */
    public function getIDGlumci()
    {
        return $this->ID_glumci;
    }

    /**
     * @param mixed $ID_glumci
     */
    public function setIDGlumci($ID_glumci): void
    {
        $this->ID_glumci = $ID_glumci;
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
    private $table = "glumci";

    public function getAll(){
        return DB::table($this->table)->get();
    }
    public function delete(){
        DB::transaction(function (){
            DB::table("serija_glumci")->where("ID_glumci",$this->ID_glumci)->delete();
            DB::table($this->table)->where("ID_glumci", $this->ID_glumci)->delete();
        });
    }
    public function update(){
        DB::table($this->table)->where("ID_glumci", $this->ID_glumci)->update([
            "glumci_ime" => $this->ime,
            "glumci_prezime" => $this->prezime
            ]);
    }
    public function insert(){
        DB::table($this->table)->insert([
            "glumci_ime" => $this->ime,
            "glumci_prezime" => $this->prezime
        ]);
    }
    public function getOne(){
       return DB::table($this->table)->where("ID_glumci", $this->ID_glumci)->get();
    }


}
