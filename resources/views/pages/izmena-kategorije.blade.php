@extends('layouts.form')
@section('title','Dodaj kategoriju')
<div id="wrapper" >
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste izmenili kategoriju!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste izmenili kategoriju!<br/></p>
        <p class="feedback er" id="f500">Trenutno ne možete izmeniti kategoriju</p>
        <div id="header">
            <h3>Izmeni kategoriju</h3>
        </div>
        <form id="forma2" action="" method="">
            <div id="content1" class="admin">
                <p class="left">Izmeni kategoriju</p>
                @foreach($podaci as $podatak)
                    <input type="hidden" value="{{$podatak->ID_link}} " id='ID'>
                <input type="text"  class="right" id="category" value="{{$podatak->naziv}}" autofocus="autofocus" placeholder="Kategorija"/>
                <input type="button" value="DODAJ" class="btn" id="btn"/>
                @endforeach
            </div>
        </form>
        <footer>
            <h5>
                <a href="{{route('genre-show')}}">Nazad na spisak kategorija</a>
            </h5>
        </footer>
    </div>
    <script src="{{asset("/")}}../js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="{{asset("/")}}../js/adminUpdateCategory.js" type="text/javascript"></script>
