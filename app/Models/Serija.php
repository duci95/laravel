<?php
/**
 * Created by PhpStorm.
 * User: Dušan
 * Date: 2.3.2019.
 * Time: 16.56
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Serija
{
    private $ID_serija;
    private $serija_naziv;
    private $serija_tekst;
    private $ID_serija_glumci;
    private $ID_link;
    private $godina;
    private $slika;
    private $obrisan;
    private $serija_like;
    private $serija_dislike;
    private $ID_korisnik;
    private $ID_glumci;
    private $data = [];

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
    /**
     * @param mixed $ID_glumci
     */
    public function setIDGlumci($ID_glumci): void
    {
        $this->ID_glumci = $ID_glumci;
    }
    private $putanja;

    /**
     * @return mixed
     */
    public function getPutanja()
    {
        return $this->putanja;
    }

    /**
     * @param mixed $putanja
     */
    public function setPutanja($putanja): void
    {
        $this->putanja = $putanja;
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
    private $table = "serija";

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
    public function getSerijaNaziv()
    {
        return $this->serija_naziv;
    }

    /**
     * @param mixed $serija_naziv
     */
    public function setSerijaNaziv($serija_naziv): void
    {
        $this->serija_naziv = $serija_naziv;
    }

    /**
     * @return mixed
     */
    public function getSerijaTekst()
    {
        return $this->serija_tekst;
    }

    /**
     * @param mixed $serija_tekst
     */
    public function setSerijaTekst($serija_tekst): void
    {
        $this->serija_tekst = $serija_tekst;
    }

    /**
     * @return mixed
     */
    public function getIDSerijaGlumci()
    {
        return $this->ID_serija_glumci;
    }

    /**
     * @param mixed $ID_serija_glumci
     */
    public function setIDSerijaGlumci($ID_serija_glumci): void
    {
        $this->ID_serija_glumci = $ID_serija_glumci;
    }

    /**
     * @return mixed
     */
    public function getIDLink()
    {
        return $this->ID_link;
    }

    /**
     * @param mixed $ID_link
     */
    public function setIDLink($ID_link): void
    {
        $this->ID_link = $ID_link;
    }

    /**
     * @return mixed
     */
    public function getGodina()
    {
        return $this->godina;
    }

    /**
     * @param mixed $godina
     */
    public function setGodina($godina): void
    {
        $this->godina = $godina;
    }

    /**
     * @return mixed
     */
    public function getSlika()
    {
        return $this->slika;
    }

    /**
     * @param mixed $slika
     */
    public function setSlika($slika): void
    {
        $this->slika = $slika;
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
    public function getSerijaLike()
    {
        return $this->serija_like;
    }

    /**
     * @param mixed $serija_like
     */
    public function setSerijaLike($serija_like): void
    {
        $this->serija_like = $serija_like;
    }

    /**
     * @return mixed
     */
    public function getSerijaDislike()
    {
        return $this->serija_dislike;
    }

    /**
     * @param mixed $serija_dislike
     */
    public function setSerijaDislike($serija_dislike): void
    {
        $this->serija_dislike = $serija_dislike;
    }

    /**
     * @return string
     */
    public function getAll(){
        return DB::table($this->table)->get();
    }
    public function getSeriesByCategory(){
        $query = DB::table($this->table)
            ->select(
                '*',
                "link.naziv as naziv_kategorije")
            ->join('link',"serija.ID_link","=","link.ID_link")
            ->where([
            ["link.putanja",$this->putanja],
            ['serija.obrisan','=' ,0]
        ])->get();
        return $query;
    }
    public function getNewestSeries(){
        $query = DB::table($this->table)->limit(5)->where('serija.obrisan','=',0)->orderBy("godina", "desc")->get();
        return $query;
    }

    public function dislike()
    {
        DB::transaction(function () {
        DB::table("glasanje_serija")->insert([
            "ID_serija" => $this->ID_serija,
            "ID_korisnik" => $this->ID_korisnik
        ]);
        DB::table($this->table)
            ->where("ID_serija",$this->ID_serija)
            ->increment('serija_dislike' , 1);
        });
    }
    public function like()
    {
        DB::transaction(function () {
            DB::table("glasanje_serija")->insert([
                "ID_serija" => $this->ID_serija,
                "ID_korisnik" => $this->ID_korisnik
            ]);
            DB::table($this->table)
                ->where("ID_serija",$this->ID_serija)
                ->increment('serija_like' , 1);
        });
    }
    public function getOne(){
        return DB::table("serija as s")
            ->join("link as l",'s.ID_link',"=",'l.ID_link')
            ->where("s.ID_serija", $this->ID_serija)
            ->get();
    }
    public function getRoles(){
        return DB::table("glumci as g")
            ->join('serija_glumci as sg','g.ID_glumci',"=","sg.ID_glumci")
            ->join('serija as s',"sg.ID_serija","=","s.ID_serija")
            ->where("s.ID_serija", $this->ID_serija)
            ->get();
    }

    public function search(){
        return DB::table($this->table)
                   ->where("serija_naziv","LIKE", "%$this->serija_naziv%")
                   ->where('obrisan',"=",0)
                   ->get();
    }



    public function delete(){
        DB::table($this->table)
            ->where('ID_serija', $this->ID_serija)
            ->update(['obrisan' => 1]);
    }

    public function insert(){

              $id = DB::table($this->table)->insertGetId([
                   'serija_naziv' => $this->serija_naziv,
                   'serija_tekst' => $this->serija_tekst,
                    'ID_link' => $this->ID_link,
                    'godina' => $this->godina,
                    'slika' => $this->slika
                ]);
              return $id;
    }
    public function insertCredits() {
        DB::table('serija_glumci')->insert([
            'ID_serija' => $this->ID_serija,
            'ID_glumci' => $this->ID_glumci
        ]);
    }

    public function updateInfo(){
        DB::table('serija')->where('ID_serija', $this->ID_serija)->update([
            'serija_naziv' => $this->serija_naziv,
            'serija_tekst' => $this->serija_tekst,
            'ID_link' => $this->ID_link,
            'godina' => $this->godina,
            'obrisan' => $this->obrisan
        ]);
    }
    public function updateCreditsFirstStep(){
            DB::table('serija_glumci')->where('ID_serija', $this->ID_serija)
                ->delete();
    }

    public function updateCreditsFinalStep(){
        DB::table('serija_glumci')->insert([
            "ID_serija" => $this->ID_serija,
            'ID_glumci' => $this->ID_glumci
        ]);
    }


    public function updatePicture(){
        DB::table('serija')->where('ID_serija', $this->ID_serija)->update([
           'slika' => $this->slika
        ]);
    }

}