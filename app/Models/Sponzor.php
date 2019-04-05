<?php
/**
 * Created by PhpStorm.
 * User: Dušan
 * Date: 2.3.2019.
 * Time: 14.07
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Sponzor
{
    private $ID_sponsor;
    private $slika;
    private $link;

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }
    private $table = "sponzor";

    /**
     * @return mixed
     */
    public function getIDSponsor()
    {
        return $this->ID_sponsor;
    }

    /**
     * @param mixed $ID_sponsor
     */
    public function setIDSponsor($ID_sponsor): void
    {
        $this->ID_sponsor = $ID_sponsor;
    }

    /**
     * @return string
     */

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
    public function getSponsors(){
        $query = DB::table($this->table)->get();
        return $query;
    }
    public function insertSponsor(){
        DB::table($this->table)->insert([
            "slika" => $this->slika,
            "link" => $this->link
        ]);
    }
    public function deleteSponsor(){
        DB::table($this->table)->where("ID_sponzor",$this->ID_sponsor)->delete();
    }
    public function getOneSponsor(){
        $query =  DB::table($this->table)->where('ID_sponzor',$this->ID_sponsor)->get();
        return $query;
    }
    public function updateLink(){
         DB::table("sponzor")->where("ID_sponzor",$this->ID_sponsor)->update(["link" => $this->link]);
    }
    public function updatePicture(){
        DB::table("sponzor")->where("ID_sponzor",$this->ID_sponsor)->update(["slika" => $this->slika]);
    }
}
