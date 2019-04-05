@extends('layouts.form')
@section('title','Izmeni sponzora')
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
            <h3>Izmeni link</h3>
        </div>
        @foreach($podaci as $podatak)
        <form id="forma2" action="{{route("sponsor-update-link", ["id" => $podatak->ID_sponzor] )}}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div id="content1" class="admin">
                <p class="left">Link</p>
                <input type="text" class="right sp" id="link" autofocus="autofocus" value="{{$podatak->link}}" placeholder="http://www.sajt.com" name="link"/>
        @endforeach
                <input type="submit" value="IZMENI" class="btn" id="btn" name="btn"/>
            </div>
            <footer>
                <h5><a href="{{route('pocetna')}}">Nazad na početnu stranu</a></h5>
            </footer>
        </form>
        </div>
            <div id="box">
                <div id="errors">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="feedbackAdmin er">{{$error}}</p>
                        @endforeach
                    @endif
                </div>
                <div id="header">
                    <h3>Izmeni sliku</h3>
                </div>
                @foreach($podaci as $podatak)
                    <form id="forma3" action="{{route("sponsor-update-picture", ["id" => $podatak->ID_sponzor] )}}" method="POST" enctype="multipart/form-data">
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

