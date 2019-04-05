@extends('layouts.form')
@section('title','Serije')
@section('content')
    <div id="admin-news">
        <div id="errors">
            @if(session()->has('error'))
                <p class="feedbackAdmin er">{{session()->get('error')}}</p>
            @endif
            @if(session()->has("uspeh"))
                <p class="feedbackAdmin ok">{{session()->get('uspeh')}}</p>
            @endif
        </div>
        @foreach($serije as $serija)
        <div class="series">
            <div class="img">
                <img src="{{ asset('/').$serija->slika }}" alt="{{ $serija->serija_naziv }}" title="{{ $serija->serija_naziv }}" width="200" height="150">
            </div>
            <div class="text padd">
                <span class="heading">
            <h6>Godina: {{ $serija->godina }}</h6>
            <h3>{{ $serija->serija_naziv }}</h3>
                    <h4>Status : @if($serija->obrisan==1) {{"Obrisano"}} @else {{"Nije obrisano"}} @endif</h4>
        </span>
                <div class="details">{{ substr($serija->serija_tekst,0,150).'...' }} <br/>
                    <a href="{{route('series-one-render',["id" => $serija->ID_serija, "cat" => $serija->ID_link])}}"><button class="edit s">Izmeni</button></a>
                    <button class="del s" data-id="{{$serija->ID_serija}}">Obriši</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <footer>
        <h5><a  href="{{route('pocetna')}}">Nazad na početnu stranu</a></h5>
    </footer>
    <script src="{{asset("/")}}js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="{{asset("/")}}js/adminDeleteSeries.js" type="text/javascript"></script>
    @endsection