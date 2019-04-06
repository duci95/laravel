@extends('layouts.form')
@section('title', 'Spisak korisnika')
@section('content')
    <div id="users">
        @foreach($korisnici as $korisnik)
        <div class="item">
            <p class="key" >Ime</p>
            <p class="value">{{$korisnik->ime}}</p>
            <p class="key">Prezime</p>
            <p class="value">{{$korisnik->prezime}}</p>
            <p class="key">Korisničko ime</p>
            <p class="value">{{$korisnik->username}}</p>
            <p class="key">Email</p>
            <p class="value">{{$korisnik->email}}</p>
            <p class="key">Aktivnost</p>
            <p class="value">{{$korisnik->aktivan}}</p>
            <p class="key">Status</p>
            <p class="value">
                @if($korisnik->obrisan==0) {{"Nije obrisan"}}
                @else  {{"Obrisan"}}</p>
                @endif
            @if($korisnik->datum_izmene=="/")
            <p class="key">Datum registracije</p>
            <p class="value">{{$korisnik->datum_registracije}}</p>
            @else
            <p class="key">Datum izmene</p>
            <p class="value">{{$korisnik->datum_izmene}}</p>
            @endif
            <a href="{{route('user-one-render',["id" => $korisnik->ID_korisnik])}}"><button class="edit">Izmeni</button></a>
            <button @if($korisnik->obrisan==1) disabled="disabled" @endif class="del" data-id="{{$korisnik->ID_korisnik}}">Obriši</button>
        </div>
        @endforeach
    </div>
    {{$korisnici->links()}}
    <footer>
        <h5><a  href="{{route('pocetna')}}">Nazad na početnu stranu</a></h5>
    </footer>
    <script src="{{asset("/")}}js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="{{asset("/")}}js/adminDeleteUser.js" type="text/javascript"></script>
@endsection
