<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;
use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->session()->has('user')){
            Log::alert("Neautorizovani korisnik sa ip adresom: ".$request->ip(). "je pokusao da pristupi admin panelu");
            return redirect()->route("pocetna");
        }
        $user = $request->session()->get('user');
        $username = $request->session()->get('user')->username;
        if($user->ID_uloga!==1) {
            Log::critical("Korisnik sa korisnickim imenom" . $username . "pokusao je da pristupi admin panelu");
            return redirect()->route("pocetna");
        }
        return $next($request);
    }
}
