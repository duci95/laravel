@extends('layouts.form')
@section('title','Dodaj kategoriju')
<div id="wrapper">
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste dodali kategoriju!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste dodali kategoriju!<br/></p>
        <p class="feedback er" id="f500">Trenutno ne možete dodati kategoriju</p>
        <div id="header">
            <h3>Dodaj kategoriju</h3>
        </div>
        <form id="forma2" action="" method="">
            <div id="content1" class="admin">
                <p class="left">Dodaj kategoriju</p>
                <input type="text"  class="right" id="category" autofocus="autofocus" placeholder="Kategorija"/>
                <input type="button" value="DODAJ" class="btn" id="btn"/>
            </div>
        </form>
        <footer>
            <h5>
                <a href="{{route('genre-show')}}">Nazad na spisak kategorija</a>
            </h5>

        </footer>
    </div>
    <script src="{{asset("/")}}../js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="{{asset("/")}}../js/adminInsertCategory.js" type="text/javascript"></script>
