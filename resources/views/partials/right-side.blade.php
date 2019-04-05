<div id="right-side">
    @foreach($sponzori as $sponzor)
    <div class="sponsor">
        <a target="_blank" href="{{$sponzor->link}}">
            <img src="{{asset("/").$sponzor->slika}}" alt="{{substr($sponzor->link,7)}} " title="{{substr($sponzor->link,7)}}" width="300" height="150">
        </a>
    </div>
    @endforeach
</div>
</div>
