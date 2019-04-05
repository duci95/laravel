<?php
/**
 * Created by PhpStorm.
 * User: Dušan
 * Date: 25.2.2019.
 * Time: 00.18
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Grad
{
    private $ID_grad;
    private $grad_ime;

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
    public function getGradIme()
    {
        return $this->grad_ime;
    }

    /**
     * @param mixed $grad_ime
     */
    public function setGradIme($grad_ime): void
    {
        $this->grad_ime = $grad_ime;
    }

    public function getAll(){
        $query = DB::table("grad")->get();
        return $query;
    }
}
