<?php
/**
 * Created by PhpStorm.
 * User: Dušan
 * Date: 4.3.2019.
 * Time: 22.46
 */

namespace App\Models;


use function foo\func;
use Illuminate\Support\Facades\DB;

class Komentar
{
    private $ID_komentar;
    private $komentar_tekst;
    private $ID_korisnik;
    private $ID_serija;
    private $datum;
    private $komentar_like;
    private $komentar_dislike;
    private $table = "komentar";

    /**
     * @return mixed
     */
    public function getIDKomentar()
    {
        return $this->ID_komentar;
    }

    /**
     * @param mixed $ID_komentar
     */
    public function setIDKomentar($ID_komentar): void
    {
        $this->ID_komentar = $ID_komentar;
    }

    /**
     * @return mixed
     */
    public function getKomentarTekst()
    {
        return $this->komentar_tekst;
    }

    /**
     * @param mixed $komentar_tekst
     */
    public function setKomentarTekst($komentar_tekst): void
    {
        $this->komentar_tekst = $komentar_tekst;
    }

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
    public function getIDSerija()
    {
        return $this->ID_serija;
    }

    /**
     * @param mixed $ID_serija
     */
    public function setIDSerija($ID_serija): void
    {
        $this->ID_serija = $ID_serija;
    }

    /**
     * @return mixed
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * @param mixed $datum
     */
    public function setDatum($datum): void
    {
        $this->datum = $datum;
    }

    /**
     * @return mixed
     */
    public function getKomentarLike()
    {
        return $this->komentar_like;
    }

    /**
     * @param mixed $komentar_like
     */
    public function setKomentarLike($komentar_like): void
    {
        $this->komentar_like = $komentar_like;
    }

    /**
     * @return mixed
     */
    public function getKomentarDislike()
    {
        return $this->komentar_dislike;
    }

    /**
     * @param mixed $komentar_dislike
     */
    public function setKomentarDislike($komentar_dislike): void
    {
        $this->komentar_dislike = $komentar_dislike;
    }

    public function getSeriesComments(){
        $query = DB::table('komentar as km')
            ->join('korisnik as k',"km.ID_korisnik","=","k.ID_korisnik")
            ->join('serija as s',"km.ID_serija","=","s.ID_serija")
            ->where('km.ID_serija',$this->ID_serija)
            ->select('*', 'km.ID_korisnik as komentator')
            ->get();
        return $query;
    }


    public function insert(){
        DB::table($this->table)->insert([
           "komentar_tekst" => $this->komentar_tekst,
           "ID_korisnik" => $this->ID_korisnik,
           "ID_serija" => $this->ID_serija,
           "datum" => $this->datum
        ]);
    }

    public function delete(){
        DB::transaction(function () {
            DB::table("glasanje")->where([
                'ID_komentar' => $this->ID_komentar,
                'ID_korisnik' => $this->ID_korisnik
            ])->delete();
            DB::table($this->table)->where('ID_komentar', $this->ID_komentar)->delete();
        });
    }
    public function like(){
        DB::transaction(function(){

           DB::table($this->table)
               ->where('ID_komentar', $this->ID_komentar)
               ->increment("komentar_like", 1);

           DB::table('glasanje')->insert([
               'ID_komentar' => $this->ID_komentar,
               'ID_korisnik' => $this->ID_korisnik
           ]);

        });

    }
    public function dislike(){
        DB::transaction(function(){

            DB::table($this->table)
                ->where('ID_komentar', $this->ID_komentar)
                ->increment("komentar_dislike", 1);

            DB::table('glasanje')->insert([
                'ID_komentar' => $this->ID_komentar,
                'ID_korisnik' => $this->ID_korisnik
            ]);

        });

    }

}
