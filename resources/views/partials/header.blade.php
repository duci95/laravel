<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/')}}css/main.css" type="text/css">
    <meta name="_token" content="{{csrf_token()}}"/>
    <title>ISDB @yield('title')</title>
</head>
<body>
<div id="wrapper">
    <div id="header">
        <div id="logo">
            <a href=""><img src="{{asset("/")}}images/logo.png" alt="logo" title="logo" height="98" ></a>
        </div>
        <nav>
            <ul>
                @foreach($linkovi as $link)
                <li><a href="{{$link->putanja}}" class="nav">{{$link->naziv}}</a></li>
                @endforeach
                @if(session()->has('user'))
                    <li ><h4  class="info" data-iduser="{{session()->get('user')->ID_korisnik}}"
                    class="nav">{{session()->get('user')->username}}</h4></li>
                <li><a href="{{route('logout')}}" class="nav">Odjavi se</a></li>
                @else
                <li> <a href="{{route('renderLogin')}}" class="nav">Prijava</a></li>
                <li> <a href="{{route('renderRegistration')}}" class="nav ">Registracija</a></li>
                @endif
            </ul>
        </nav>
        <div id="criteria">
            <input type="search" id="search" placeholder="Pretraži serije..." />
            <i class="fa fa-search"></i>
        </div>
    </div>
