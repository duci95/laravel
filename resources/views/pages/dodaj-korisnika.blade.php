@extends('layouts.form')
@section('title','Dodaj korinsika')
@section('content')
<div id="wrapper" >
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste se registrovali korisnika!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste registrovali korisnika!<br/></p>
        <p class="feedback er" id="f500">Trenutno ne možete registrovati korisnika!</p>
        <div id="header">
            <h3>Registracija</h3>
        </div>
        <form id="forma2" action="" method="">
            <div id="content1" class="admin" >
                <p class="left">Ime</p>
                <input type="text"  class="right" id="first" autofocus="autofocus" placeholder="Petar"/>
                <p class="left">Prezime</p>
                <input type="text" class="right" id="last" placeholder="Petrović"/>
                <p class="left">Email</p>
                <input type="text" class="right" id="email" placeholder="petar@domen.com"/>
                <p class="left">Pol</p>
                <div id="pol" class="left">
                    <label for="m">Muški</label>
                    <input type="radio"  name="pol" class="radio" checked="checked" id="m" value="m"/>
                    <label for="f">Ženski</label>
                    <input type="radio"  name="pol" class="radio"  id="f" value="z"/>
                </div>
                <p class="left">Grad</p>
                <select class="right select" name="city" id="city">
                    <option value="0">Izaberite...</option>
                    @foreach ($gradovi as $grad)
                    <option value="{{$grad->ID_grad}}">{{$grad->grad_ime}}</option>
                    @endforeach
                </select>
                <p class="left">Korisničko ime</p>
                <input type="text" class="right" id="username" placeholder="korisnik1"/>
                <p class="left">Lozinka</p>
                <input type="password" class="right" id="password" placeholder="Lozinka1#$%"/>
                <p class="left">Potvrdi lozinku</p>
                <input type="password" class="right" id="password1" placeholder="Lozinka1#$%"/>
                <p class="left">Uloga</p>
                <select class="right select" name="roll" id="roll">
                    <option value="0">Izaberite...</option>
                    @foreach ($uloge as $uloga)
                        <option value="{{$uloga->ID_uloga}}">{{$uloga->uloga_ime}}</option>
                    @endforeach
                </select>
                <p class="left">Aktivnost</p>
                <select name="active" class="right select" id="active">
                    <option value="null">Izaberite...</option>
                    <option value="0">Neaktivan</option>
                    <option value="1">Aktivan</option>
                </select>
                <input type="button" value="REGISTRUJ" class="btn" id="btn"/>
            </div>
        </form>
        <footer>
            <h5>
                <a href="{{route('pocetna')}}">Nazad na početnu stranu</a>
            </h5>
        </footer>
        <script src="{{asset('/')}}js/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}js/adminInsertUser.js" type="text/javascript"></script>
@endsection
