@extends('layouts.form')
@section('content')
    <div id="errors">
        @if(session()->has("uspeh"))
            <p class="feedbackAdmin ok">Uspešno ste izmenili sponzora</p>
        @endif
        @if(session()->has('error'))
                <p class="feedbackAdmin er">Doslo je do greske kontaktirajte admina!</p>
        @endif
    </div>
    <div id="sponsors">
        @foreach($sponzori as $item)
        <div class="sponsorAdmin">
            <button class="delSponsor" data-id='{{$item->ID_sponzor}}'>Obriši</button>
            <a href="{{route('sponsor-one-render',["id" => $item->ID_sponzor])}}"><button class="editSponsor" >Izmena</button></a>
            <a target="_blank" href="{{ $item->link }}">
                <img src="{{asset("/").$item->slika }}" alt="{{ substr($item->link,7) }}" title="{{ substr($item->link,7) }}" width="300" height="150">
            </a>
        </div>
        @endforeach
    </div>
    <script type="text/javascript" src="{{asset('/')}}js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $('.delSponsor').click(function () {
            var id = $(this).data('id');
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='_token']").attr("content")
                    }
                });
            console.log(id);
            $.ajax({
                url:"/admin/sponzori/brisanje/"+id,
                method:"DELETE",
                success:function (data) {
                     alert("Uspešno ste obrisali sponzora!");
                     location.reload();
                },
                error:function (x,s,e) {
                    switch (x.status) {
                        case 404:
                            window.location.href="greska.php";
                            break;
                        case 409:
                            alert("Izvinjavamo se zbog tehničkih problema");
                            break;
                    }
                }
            })
        });
    </script>
    </body>
    </html>
@endsection
