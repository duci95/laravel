@extends('layouts.form')
@section('title', 'Izvestaj aktivnosti')
<table>
    <tr class="row root">
        <th class="cell">Username</th>
        <th class="cell">Datum</th>
        <th class="cell">Aktivnost</th>
    </tr>
    @foreach($data as $d)
    <tr class="row">
        <td class="cell">{{$d->username}}</td>
        <td class="cell">{{$d->datum}}</td>
        <td class="cell">{{$d->aktivnost}}</td>
    </tr>
    @endforeach

</table>
<footer>
    <h5><a  href="{{route('pocetna')}}">Nazad na početnu stranu</a></h5>
</footer>