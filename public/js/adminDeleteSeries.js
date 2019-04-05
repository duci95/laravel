var del = $(".del");
del.click(function() {
    var id = $(this).data("id");
    console.log(id);
    $.ajaxSetup({
        headers:{
            "X-CSRF-TOKEN" : $('meta[name=_token]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/serije/brisanje/"+id,
        method:"DELETE",
        success:function(data, xhr){
            alert("Uspesno ste obrisali seriju");
            location.reload();
        },
        error:function(xhr, status, error) {
            alert("Izvinjavamo se zbog tehničkih problema");
        }
    });
});
