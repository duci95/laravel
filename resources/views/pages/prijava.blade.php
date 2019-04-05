@extends('layouts.form')
@section('title','Prijava')
@section('content')
    <div id="wrapper">
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste se prijavili!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste se prijavili!</p>
        <p class="feedback er" id="f400">Uneti podaci nisu ispravni!</p>
        <p class="feedback er" id="f500">Trenutno se ne možete prijaviti!</p>
        <div id="header">
            <h3>Prijava</h3>
        </div>
        <form id="forma1" action="" method="">
            <div id="content">
                <p class="left">Korisničko ime</p>
                <input type="text" class="right" id="username" autofocus="autofocus" placeholder="korisnik1"/>
                <p class="left">Lozinka</p>
                <input type="password" class="right" id="password" placeholder="Lozinka1#$%"/>
                <input type="button" value="PRIJAVI SE" class="btn" id="btn" />
            </div>
        </form>
        <footer>
            <h5>
                Niste registrovani? <a href="{{route('renderRegistration')}}">Registrujte se</a> <br/>
                <a href="{{route('pocetna')}}">Nazad na početnu stranu</a>
            </h5>
        </footer>
    </div>
    <script src="{{asset('/')}}js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="{{asset('/')}}js/login.js" type="text/javascript"></script>
    @endsection
