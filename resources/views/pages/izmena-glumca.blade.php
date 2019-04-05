@extends('layouts.form')
@section('title','Izmena glumca')
<div id="wrapper">
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste izmenili glumca!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste izmenili glumca!<br/></p>
        <div id="header">
            <h3>Izmeni glumca</h3>
        </div>
        <form id="forma2" action="" method="">
            <div id="content1" class="admin">
                @foreach($podaci as $podatak)
                <input type="hidden" id="ID" value="{{$podatak->ID_glumci}}">
                <p class="left">Ime</p>
                <input type="text"  class="right" value="{{$podatak->glumci_ime}}" id="ime" autofocus="autofocus" placeholder="Petar"/>
                <p class="left">Prezime</p>
                <input type="text"  class="right" id="prezime" value="{{$podatak->glumci_prezime}}" autofocus="autofocus" placeholder="Petrovic"/>
                <input type="button" value="IZMENI" class="btn" id="btn"/>
                @endforeach
            </div>
        </form>
        <footer>
            <h5>
                <a href="{{route('role-show')}}">Nazad na spisak glumaca</a>
            </h5>
        </footer>
    </div>
    <script src="{{asset("/")}}../js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="{{asset("/")}}../js/adminUpdateRole.js" type="text/javascript"></script>
