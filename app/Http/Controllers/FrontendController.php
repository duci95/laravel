<?php
namespace App\Http\Controllers;
use App\Models\Grad;
use App\Models\Link;
use App\Models\Serija;
use App\Models\Sponzor;
class FrontendController extends Controller
{
    protected $data;
    protected $model;
    public function __construct(){
        $link = new Link();
        $this->data['kategorije'] = $link->getCategories();
        $this->data['meni'] = $link->getMenu();
        $sponzori = new Sponzor();
        $this->data['sponzori'] = $sponzori->getSponsors();
        $this->data['linkovi'] = $link->getMenu();
    }
    public function login(){
        return view('pages.prijava');
    }
    public function register(){
        $city = new Grad();
        $data = $city->getAll();
        return view('pages.registracija')->with("cities", $data);
    }

    public function kontakt(){
        return view("pages.kontakt",$this->data);
    }
    public function autor(){
        return view('pages.autor',$this->data);
    }
}
