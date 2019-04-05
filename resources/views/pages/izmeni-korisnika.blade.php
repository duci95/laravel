@extends('layouts.form')
@section('title', 'Spisak korisnika')
@section('content')
<div id="wrapper">
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste se izmenili korisnika!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste izmenili korisnika!<br/></p>
        <p class="feedback er" id="f500">Trenutno ne možete izmeniti korisnika!</p>
        <div id="header">
            <h3>Izmena</h3>
        </div>
        @foreach($podaci as $podatak)
        <form id="forma2" action="" method="">
            <div id="content1" class="admin">
                <input type="hidden" value="{{$podatak->ID_korisnik}}" id="ID">
                <p class="left">Ime</p>
                <input type="text"  class="right" id="first" autofocus="autofocus" value="{{$podatak->ime}}"/>
                <p class="left">Prezime</p>
                <input type="text" class="right" id="last" value="{{$podatak->prezime}}"/>
                <p class="left">Email</p>
                <input type="text" class="right" id="email" value="{{$podatak->email}}"/>
                <p class="left">Pol</p>
                <div id="pol" class="left">
                    <label for="m">Muški</label>
                    <input type="radio" name="pol" class="radio" @if($podatak->pol=="m") checked="checked" @endif id="m" value="m"/>
                    <label for="f">Ženski</label>
                    <input type="radio"  name="pol" class="radio" @if($podatak->pol=="z") checked="checked" @endif id="f" value="z"/>
                </div>
                <p class="left">Grad</p>
                <select class="right select" name="city" id="city">
                    <option value="0">Izaberite...</option>
                    <option selected="selected" value="{{$podatak->ID_grad}}">{{$podatak->grad_ime}}</option>
                    @foreach ($gradovi as $grad)
                        <option value="{{$grad->ID_grad}}">{{$grad->grad_ime}}</option>
                    @endforeach
                </select>
                <p class="left">Korisničko ime</p>
                <input type="text" class="right" id="username" value="{{$podatak->username}}"/>
                <p class="left">Uloga</p>
                <select class="right select" name="roll" id="roll">
                    <option value="0">Izaberite...</option>
                    <option selected="selected" value="{{$podatak->ID_uloga}}">{{$podatak->uloga_ime}}</option>
                    @foreach ($uloge as $uloga)
                    <option value="{{$uloga->ID_uloga}}">{{$uloga->uloga_ime}}</option>
                    @endforeach
                </select>
                <p class="left">Aktivnost</p>
                <select name="active" class="right select" id="active">
                    <option value="null">Izaberite...</option>
                    @if($podatak->aktivan === 0)
                    <option selected="selected" value="0">Neaktivan</option>
                    <option  value="1">Aktivan</option>
                    @else
                    <option  value="0">Neaktivan</option>
                    <option selected="selected" value="1">Aktivan</option>
                    @endif
                </select>
                <p class="left">Status</p>
                <select name="status" class="right select" id="a">
                    <option value="null">Izaberite...</option>
                    @if($podatak->obrisan == 0)
                    <option selected="selected" value="0">Nije obrisan</option>
                    <option  value="1">Obrisan</option>
                    @else
                    <option  value="0">Nije obrisan</option>
                    <option selected="selected" value="1">Obrisan</option>
                    @endif
                </select>
                <input type="button" value="Izmeni" class="btn" id="btn"/>
                @endforeach
            </div>
        </form>
        <footer>
            <h5>
                <a href="{{route('user-show')}}">Nazad na spisak korisnika</a>
            </h5>
        </footer>
    </div>
    <script src="{{asset('/')}}../js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="{{asset('/')}}../js/adminUpdateUser.js" type="text/javascript"></script>
@endsection
