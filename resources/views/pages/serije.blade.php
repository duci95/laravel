@extends('layouts.master')
@section('content')
<div id="articles">
    @foreach($serije as $serija)
    <div class="item">
        <div class="img">
            <img src="{{asset("/").$serija->slika }}" alt="{{ $serija->serija_naziv }}" title="{{ $serija->serija_naziv }}" width="200" height="150">
        </div>
        <div class="right-container">
            <div class="date-com">
                @if(session()->has('user'))
                    <i data-user="{{session()->get('user')->ID_korisnik}}"
                       data-idseries="{{ $serija->ID_serija }}"
                       class="left vote-series-plus fa fa-plus"> {{ $serija->serija_like }} </i>
                    <i data-user="{{session()->get('user')->ID_korisnik}}"
                       data-idseries="{{ $serija->ID_serija }}"
                        class="left vote-series-minus fa fa-minus"> {{$serija->serija_dislike}} </i>
                @else
                    <a href="{{route('renderLogin')}}"><i class="left fa fa-plus"></i><i  class="left fa fa-minus"></i></a>
                @endif
                @if(session()->has('user'))
                        <h6 class="right" data-idseries="{{ $serija->ID_serija}}"
                            data-user="{{ session()->get('user')->ID_korisnik}}"
                            data-series="{{ $serija->serija_naziv}}">Komentari</h6>
                @else
                        <h6 class="right" data-idseries="{{ $serija->ID_serija}}"
                            data-series="{{ $serija->serija_naziv}}">Komentari</h6>
                @endif

            </div>
            <div class="details" data-idseries="{{$serija->ID_serija}}">
                <h3 class="heading">{{ $serija->serija_naziv }}</h3>
                <p class="text" >{{ substr($serija->serija_tekst,0,150).'...' }}</p>
            </div>
        </div>
        @section('title', $serija->naziv_kategorije)
    </div>
    @endforeach
</div>
@endsection
