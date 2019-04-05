<footer>
    <a href="{{asset('/')}}dokumentacija.pdf">Dokumentacija</a>
    <h6>Copyright Dušan Krsmanović {{date("Y")}} &copy;</h6>
    @if(session()->has('user') && session()->get('user')->ID_uloga == 1)
        <a href="{{route("sponsor-show")}}">Spisak sponzora</a>
        <a href="{{route('user-show')}}">Spisak korisnika</a>
        <a href="{{route('genre-show')}}">Spisak žanrova</a>
        <a href="{{route("role-show")}}">Spisak glumaca</a>
        <a href="{{route('series-show')}}">Spisak serija</a>
        <a href="{{route('user-form')}}">Dodaj korisnika</a>
        <a href="{{route("genre-form")}}">Dodaj žanr</a>
        <a href="{{route('sponsor-form')}}">Dodaj sponzora</a>
        <a href="{{route('series-form')}}">Dodaj seriju</a>
        <a href="{{route('role-form')}}">Dodaj glumce</a>
        <a href="{{route('activity')}}">Izveštaj</a>
    @endif
</footer>
</div>
<script type="text/javascript" src="{{asset('/')}}js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="{{asset('/')}}js/main.js"></script>
</body>
</html>
