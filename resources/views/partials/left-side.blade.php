<div id="container">
    <div id="left-side">
        <ul>
            @foreach($kategorije as $kategorija)
                <li><a href="{{route('category', ["cat" => $kategorija->putanja] )}}"><h3>{{$kategorija->naziv}}</h3></a></li>
            @endforeach
        </ul>
    </div>
