<?php
/**
 * Created by PhpStorm.
 * User: Dušan
 * Date: 7.3.2019.
 * Time: 13.47
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Uloga
{
    private $ID_uloga;
    private $uloga_naziv;

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

    /**
     * @return mixed
     */
    public function getUlogaNaziv()
    {
        return $this->uloga_naziv;
    }

    /**
     * @param mixed $uloga_naziv
     */
    public function setUlogaNaziv($uloga_naziv): void
    {
        $this->uloga_naziv = $uloga_naziv;
    }

    public function getRoles(){
        return DB::table('uloga')->get();
    }
}
