@extends('layouts.form')
@section('title','Dodaj glumca')
<div id="wrapper">
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste dodali glumca!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste dodali glumca!<br/></p>
        <div id="header">
            <h3>Dodaj glumca</h3>
        </div>
        <form id="forma2" action="" method="">
            <div id="content1" class="admin">
                <p class="left">Ime</p>
                <input type="text"  class="right" id="ime" autofocus="autofocus" placeholder="Petar"/>
                <p class="left">Prezime</p>
                <input type="text"  class="right" id="prezime"  placeholder="Petrovic"/>
                <input type="button" value="DODAJ" class="btn" id="btn"/>
            </div>
        </form>
        <footer>
            <h5>
                <a href="{{route('role-show')}}">Nazad na spisak glumaca</a>
            </h5>
        </footer>
    </div>
    <script src="{{asset("/")}}../js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="{{asset("/")}}../js/adminInsertRole.js" type="text/javascript"></script>
