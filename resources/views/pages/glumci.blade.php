@extends('layouts.form')
@section('title','Glumci')
@section('content')
    <div id="errors">
        @if(session()->has("uspeh"))
            <p class="feedbackAdmin ok">Uspešno ste dodali glumca</p>
        @endif
        @if(session()->has('error'))
            <p class="feedbackAdmin er">Doslo je do greske kontaktirajte admina!</p>
        @endif
    </div>
    <div id="sponsors">
        @foreach($glumci as $glumac)
            <div class="categoryAdmin">
                <h3>Ime: {{$glumac->glumci_ime}}</h3>
                <h3>Prezime: {{$glumac->glumci_prezime}}</h3>
                <button class="delSponsor" data-id='{{$glumac->ID_glumci}}'>Obriši</button>
                <a href="{{route('role-one-render',["id" => $glumac->ID_glumci])}}"><button class="editSponsor">Izmena</button></a>
            </div>
        @endforeach
    </div>
    <footer>
        <h5>
            <a href="{{route('pocetna')}}">Nazad na početnu stranu</a>
        </h5>
    </footer>
    <script type="text/javascript" src="{{asset('/')}}js/jquery-3.3.1.min.js"></script>
    <script src="{{asset("/")}}js/adminDeleteRole.js" type="text/javascript"></script>
@endsection
