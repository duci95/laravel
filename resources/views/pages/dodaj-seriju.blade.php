@extends('layouts.form')
@section('title','Dodaj seriju')
@section('content')
    <div id="wrapper">
        <div id="box">
            <div id="errors">
                @if(session()->has('error'))
                    <p class="feedbackAdmin er">{{session()->get('error')}}</p>
                @endif
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <p class="feedbackAdmin er">{{$error}}</p>
                    @endforeach
                @endif
                @if(session()->has("uspeh"))
                    <p class="feedbackAdmin ok">Uspešno ste dodali seriju</p>
                @endif
            </div>
            <div id="header">
                <h3>Dodaj seriju</h3>
            </div>
            <form id="forma2" action="{{route("series-insert")}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="admin-news" class="admin">
                    <p class="left">Izaberi kategoriju</p>
                    <select class="right select" id="category" name="category" >
                        <option value="0">Izaberite...</option>
                        @foreach($kategorije as $kategorija)
                            <option  value="{{$kategorija->ID_link}}">{{$kategorija->naziv}}</option>
                        @endforeach
                    </select>
                    <p class="left">Izaberi glumce</p>
                    @foreach($glumci as $glumac)
                        <label  for="{{$glumac->ID_glumci}}">{{$glumac->glumci_ime}} {{$glumac->glumci_prezime}}</label>
                        <input  type="checkbox" id="{{$glumac->ID_glumci}}"
                                value="{{$glumac->ID_glumci}} " name="glumci[]" > <br/>
                    @endforeach
                    <p class="left">Ime serije</p>
                    <input type="text" class="right" name="name" value="{{old('name')}}" />
                    <p class="left">Godina</p>
                    <input type="text" class="right" name="year" value="{{old('year')}}" />
                    <p class="left">Tekst</p>
                    <textarea name="text" cols="30" rows="10">{{old('text')}}</textarea>
                    <p class="left">Slika</p>
                    <input class="right" type="file" name="img" {{old('img')}}>
                    <input type="submit" value="Dodaj" class="btn btn2" name="btn"/>
                </div>
            </form>
            <footer>
                <h5><a href="{{route('pocetna')}}">Nazad na početnu stranu</a></h5>
            </footer>
        </div>
@endsection
