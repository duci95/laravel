@extends('layouts.form')
@section('title','Kategorije')
@section('content')
    <div id="errors">
        @if(session()->has("uspeh"))
            <p class="feedbackAdmin ok">Uspešno ste dodali kategoriju</p>
        @endif
        @if(session()->has('error'))
            <p class="feedbackAdmin er">Doslo je do greske kontaktirajte admina!</p>
        @endif
    </div>
    <div id="sponsors">
        @foreach($kategorije as $kategorija)
            <div class="categoryAdmin">
                <h3>{{$kategorija->naziv}}</h3>
                <button class="delSponsor" data-id='{{$kategorija->ID_link}}'>Obriši</button>
                <a href="{{route('genre-one-render',["id" => $kategorija->ID_link])}}"><button class="editSponsor" >Izmena</button></a>
            </div>
        @endforeach

    </div>
    <footer>
        <h5>
            <a href="{{route('pocetna')}}">Nazad na početnu stranu</a>
        </h5>
    </footer>
    <script type="text/javascript" src="{{asset('/')}}js/jquery-3.3.1.min.js"></script>
    <script src="{{asset("/")}}js/adminDeleteCategory.js" type="text/javascript"></script>
@endsection
