@extends('layouts.form')
@section('title','Dodaj sponzora')
@section('content')
    <div id="wrapper">
<div id="box">
    <div id="errors">
        @if(session()->has('error'))
            <p class="feedbackAdmin er">{{session()->get('error')}}</p>
        @endif
        @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="feedbackAdmin er">{{$error}}</p>
                    @endforeach
        @endif
        @if(session()->has("uspeh"))
            <p class="feedbackAdmin ok">Uspešno ste dodali sponzora</p>
        @endif
    </div>
    <div id="header">
        <h3>Dodaj sponzora</h3>
    </div>
    <form id="forma2" action="{{route("sponsor-insert")}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="content1" class="admin">
            <p class="left">Link</p>
            <input type="text" class="right sp" id="link" autofocus="autofocus" placeholder="http://www.sajt.com" name="link"/>
            <p class="left">Slika</p>
            <input type="file" class="right sp" id="img" name="img" />
            <input type="submit" value="DODAJ" class="btn" id="btn" name="btn"/>
        </div>
    </form>
    <footer>
        <h5><a href="{{route('pocetna')}}">Nazad na početnu stranu</a></h5>
    </footer>
</div>
@endsection
