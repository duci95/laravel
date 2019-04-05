var del = $(".delSponsor");
del.click(function() {
    var id = $(this).data("id");
    console.log(id);
    $.ajaxSetup({
        headers:{
            "X-CSRF-TOKEN" : $('meta[name=_token]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/zanrovi/brisanje/"+id,
        method:"DELETE",
        success:function(data, xhr){
            alert("Uspesno ste obrisali kategoriju");
            location.reload();
        },
        error:function(xhr, status, error) {
            switch (xhr.status) {
                case 500:
                    alert("Izvinjavamo se zbog tehničkih problema");
                    break;
            }
        }
    });
});
