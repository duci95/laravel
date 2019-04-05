@extends('layouts.form')
@section('title','Izmeni seriju')
@section('content')
    <div id="wrapper">
        <div id="box">
            <div id="errors">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="feedbackAdmin er">{{$error}}</p>
                    @endforeach
                @endif
            </div>
            <div id="header">
                <h3>Izmeni seriju</h3>
            </div>
            @foreach($serija as $s)
                <form id="forma2" action="{{route("series-update-info", ["id" => $s->ID_serija] )}}" method="POST" >
                    @method('PUT')
                    @csrf
                    <div id="edit-news" class="admin">
                        <p class="left">Naziv serije</p>
                        <input type="text" class="right sp"  autofocus="autofocus" value="{{$s->serija_naziv}}"  name="name"/>
                        <p class="left">Godina</p>
                        <input type="text" class="right sp"  value="{{$s->godina}}"  name="year"/>
                        <p class="left">Tekst</p>
                        <textarea name="text" cols="30" rows="10">{{$s->serija_tekst}}</textarea>
                        <p class="left">Izaberi kategoriju</p>
                        <select class="right select" id="category" name="category">
                            <option  value="{{$s->ID_link}}">{{$s->naziv}}</option>
                            @foreach ($kategorije as $kategorija)
                            <option  value="{{$kategorija->ID_link}}">{{$kategorija->naziv}}</option>
                            @endforeach
                        </select>
                        @foreach($svi_glumci as $glumac)
                            <label for="{{$glumac->ID_glumci}}">{{$glumac->glumci_ime}} {{$glumac->glumci_prezime}}</label>
                            <input type="checkbox" id="{{$glumac->ID_glumci}}" value="{{$glumac->ID_glumci}}" name="glumci[]"
                                   @foreach($glumci as $g)
                                    @if($g->ID_glumci == $glumac->ID_glumci)
                                    checked="checked"
                                    @endif
                                    @endforeach>
                            <br/>

                        @endforeach
                        <p class="left">Status</p>
                        <select name="status" class="right select" id="a">
                            <option value="null">Izaberite...</option>
                            @if($s->obrisan == 0)
                                <option selected="selected" value="0">Nije obrisan</option>
                                <option  value="1">Obrisan</option>
                            @else
                                <option  value="0">Nije obrisan</option>
                                <option selected="selected" value="1">Obrisan</option>
                            @endif
                        </select>
                        <input type="submit" value="IZMENI" class="btn btn2" id="btn2" />
            @endforeach
                    </div>
                    <footer>
                        <h5><a href="{{route('pocetna')}}">Nazad na početnu stranu</a></h5>
                    </footer>
                </form>
        </div>
        <div id="box">
            <div id="errors">
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="feedbackAdmin er">{{$error}}</p>
                    @endforeach
                @endif
                @if(session()->has('uspeh'))
                        <p class="feedbackAdmin ok">Uspesno ste izmenili sliku</p>
                @endif
            </div>
            <div id="header">
                <h3>Izmeni sliku</h3>
            </div>
            @foreach($serija as $s)
                <form id="forma3" action="{{route("series-update-picture", ["id" => $s->ID_serija] )}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="content1" class="admin">
                        <p class="left">Slika</p>
                        <input type="file" class="right sp" id="img" name="img" />
                        @endforeach
                        <input type="submit" value="IZMENI" class="btn" id="btn" name="btn"/>
                    </div>
                </form>
                <footer>
                    <h5><a href="{{route('pocetna')}}">Nazad na početnu stranu</a></h5>
                </footer>
        </div>
    </div>
@endsection

