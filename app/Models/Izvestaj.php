<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 12.3.2019
 * Time: 0:59
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Izvestaj
{
    /**
     * @param mixed $ID_korisnik
     */
    public function setIDKorisnik($ID_korisnik): void
    {
        $this->ID_korisnik = $ID_korisnik;
    }
    private $ID_korisnik;
    private $datum;

    private $table = 'izvestaj';
    /**
     * @param mixed $datum
     */
    public function setDatum($datum): void
    {
        $this->datum = $datum;
    }

    public function insert($activity) {
        DB::table($this->table)->insert([
            'ID_korisnik' => $this->ID_korisnik,
            'datum' => $this->datum,
            'aktivnost' => $activity
        ]);
    }

    public function getAll(){
        return DB::table('izvestaj as i')
            ->join('korisnik as k','i.ID_korisnik', '=','k.ID_korisnik')
            ->get();
    }

}