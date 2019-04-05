<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 25.2.2019
 * Time: 22:44
 */

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Link
{
    private $ID_link;
    private $naziv;
    private $putanja;
    private $ID_link_parent;
    private $table = 'link';

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
    public function getNaziv()
    {
        return $this->naziv;
    }

    /**
     * @param mixed $naziv
     */
    public function setNaziv($naziv): void
    {
        $this->naziv = $naziv;
    }

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
    public function getIDLinkParent()
    {
        return $this->ID_link_parent;
    }

    /**
     * @param mixed $ID_link_parent
     */
    public function setIDLinkParent($ID_link_parent): void
    {
        $this->ID_link_parent = $ID_link_parent;
    }

    public function getMenu(){
        $query = DB::table($this->table)->where('ID_link_parent',-1)->get();
        return $query;
    }
    public function getCategories(){
        $query = DB::table($this->table)->where('ID_link_parent',0)->orderBy("naziv")->get();
        return $query;
    }
    public function insert(){
        DB::table($this->table)->insert([
                "naziv" => $this->naziv,
                "putanja" => $this->putanja,
                "ID_link_parent" => 0
            ]);
    }
    public function delete(){
        DB::table($this->table)->where("ID_link" , $this->ID_link)->delete();
    }
    public function getOne(){
        return DB::table($this->table)->where("ID_link", $this->ID_link)->get();
    }
    public function update(){
        return DB::table($this->table)->where("ID_link", $this->ID_link)->update([
           "naziv" => $this->naziv,
           "putanja" => $this->putanja
        ]);
    }
    public function getOtherCategoreis(){
        $query = DB::table($this->table)
            ->where('ID_link_parent',0)
            ->where('ID_link',"!=",$this->ID_link)
            ->orderBy("naziv")->get();
        return $query;
    }
}
