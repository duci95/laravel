function sendToken() {
    $.ajaxSetup({
        headers : {
            "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
        }
        // accepts: "application/json"
    });
}
$(document).ready(function() {
//vracanje na prijavu
    $(document).on("click",".redirect",function () {
        window.location.href = '/prijava';
    });
//vracanje na serije
    $(document).on('click','.refresh',function (){
       location.reload();
    });
//     //slanje komenatara
   $(document).on("click","#btn-comment",function () {
   var user = $(this).data("user");
   var series = $(this).data("idseries");
   var commentValue = $('.comment-field').val();
   var errors = [];
   var er = $(".warning");
   var ok = $(".success");
   var regex = /^[a-zšđčćž0-9A-ZŠĐČĆŽ?!\.\s]{5,200}$/;
   if(!regex.test(commentValue)){
            errors.push("Greska");
   }
   if(errors.length > 0) {
       ok.css("display","none");
       er.css("display","block");
   }
   else{
       sendToken();
       $.ajax({
            url:"/komentari",
            method:"POST",
            data:{
                iduser : user,
                idseries : series,
                comment : commentValue
            },
            success:function (data) {
                er.css("display","none");
                ok.css("display","block");
            },
           error:function (xhr,status,error) {
               switch (xhr.status) {
                   case 422:
                       er.css("display","block");
                       ok.css("display","none");
                       break;
                   case 500:
                       alert("Izvinjavamo se zbog tehničkih problema");
                       break;
               }
           }
       });
   }
});
    //prikaz komentara
    $(document).on('click',".right",function () {
    var idseries = $(this).data("idseries");
    var series = $(this).data("series");
    var user = $(this).data("user");
    console.log(idseries);
    console.log(series);
    console.log(user);
    $.ajax({
        url:"/komentari/"+idseries,
        method:"GET",
        success:function(data){
            var root = $("#articles");
            var com = "";
            if(data.sesija) {
                com = "<div id='comments'>";
                com += "<h3 class=' center'>"+series+"</h3>";
                com += "<form action='' method=''>";
                com += "<textarea id='comment' class='comment-field' ></textarea>";
                com += "<input type='button' data-idseries='" + idseries + "' data-user='" + user + "' class='comments-btn' id='btn-comment' value='Pošalji'>";
                com += "</form>";
                com += "<h5 class='warning'>Komentar mora imati izmedju 5 i 200 karaktera! <br/> " +
                    " Dozvoljena su samo slova, znakovi interpunkcije i brojevi!</h5>";
                com += "<h5 class='success'>Komentar uspešno poslat.</h5>";
                com += "</form>";
                for(let i=0;i<data.podaci.length;i++) {
                    com += "<div class='comment'>";
                    com += "<h3 class='comment-user'>" + data.podaci[i].username +" " +data.podaci[i].datum+ "</h3>";
                    com += "<h5 class='comment-content'>" + data.podaci[i].komentar_tekst + "</h5>";
                    if(data.podaci[i].komentar_tekst != null)
                    com += "<span class='anketa'>";
                    if(data.podaci[i].komentator == user) {
                        console.log(data.podaci[i].komentator)
                        com += "<i class='green fa'> " + data.podaci[i].komentar_like + " </i><i class='red fa'> " + data.podaci[i].komentar_dislike + "</i> <i data-user='" + data.podaci[i].ID_korisnik + "' data-com='" + data.podaci[i].ID_komentar + "' class='fas fa-trash-alt'></i></span>";
                    }
                    else {
                        com += "<i class='fa fa-thumbs-up' data-com='" + data.podaci[i].ID_komentar + "' data-user='" + user + "' data-series='" + data.podaci[i].ID_vest + "'> " + data.podaci[i].komentar_like + " </i>  <i class='fa fa-thumbs-down' data-user='" + user + "' data-idseries='" + data.podaci[i].ID_serija + "' data-com='" + data.podaci[i].ID_komentar + "'> ";
                        com += data.podaci[i].komentar_dislike + "</i></span>";
                    }
                    com += "</div>";
                }
                com += "<h6 class='refresh'>Povratak na serije</h6>";
                root.html(com);
            }
            else{
                com = "<div id='comments'>";
                for(let i=0;i<data.podaci.length;i++) {
                    com += "<div class='comment'>";
                    com += "<h3 class='comment-user'>" + data.podaci[i].username +" " +data.podaci[i].datum+ "</h3>";
                    com += "<h5 class='comment-content'>" + data.podaci[i].komentar_tekst + "</h5>";
                    com += "<span class='anketa'>";
                    com += "<i class='green fa'> " + data.podaci[i].komentar_like + " </i><i class='red fa'> " + data.podaci[i].komentar_dislike + "</i>";
                    com += "</div>";
                }
                com += "</div><h5 class='forbidden'><a class='redirect' >Morate se ulogovati da biste komentarisali</a></h5>";
                com += "<h6 class='refresh'>Povratak na serije</h6>";
                root.html(com);
            }
        },
        error:function (xhr, status, error) {
                    alert("Izvinjavamo se zbog tehničkih problema");

        }
    });
});
// pretraga serije
    $(document).on('keydown','#search',function (){
    var char = $('#search').val();
    console.log(char);
    $.ajax({
        url: "/pretraga/"+char,
        method: "GET",
        success: function (data) {
            var root = $("#articles");
            var series = "";
            var tekst = "";
            if(data.korisnik) {
                for (let i = 0; i < data.podaci.length; i++) {
                    series += "<div class='item'>";
                    tekst = data.podaci[i].serija_tekst;
                    series += "<div class='img'>" +
                        "<img src='" + data.podaci[i].slika + "' alt='" + data.podaci[i].serija_naziv + "' title='" + data.podaci[i].serija_naziv + "' width='200' height='150'>" +
                        "</div>";
                    series += "<div class='right-container'>";
                    series += "<div class='date-com'>";
                    series += "<i class='left vote-series-plus fa fa-plus' data-idseries='" + data.podaci[i].ID_serija + "' data-user='" + data.korisnik.ID_korisnik + "' data-series='" + data.podaci[i].serija_naziv + "' > " + data.podaci[i].serija_like+ " </i>";
                    series += "<i class='left vote-series-plus fa fa-minus' data-idseries='" + data.podaci[i].ID_serija + "' data-user='" + data.korisnik.ID_korisnik + "' data-series='" + data.podaci[i].serija_naziv + "' > " + data.podaci[i].serija_dislike+ " </i>";
                    series += "<h6 class='right' data-idseries='" + data.podaci[i].ID_serija + "' data-user='" + data.korisnik.ID_korisnik + "' data-series='" + data.podaci[i].serija_naziv + "'>Komentari</h6>";
                    series += "</div>";
                    series += "<div class='details' data-idseries='" + data.podaci[i].ID_serija + "'><h3 class='heading'>" + data.podaci[i].serija_naziv + "</h3><p class='text'>" + tekst.substring(0, 150) + "...</p></div>";
                    series += "</div>";
                    series += "</div>";
                }
                root.html(series);
            }
            else{

                for (let i = 0; i < data.podaci.length; i++) {
                    series += "<div class='item'>";

                    tekst = data.podaci[i].serija_tekst;
                    series += "<div class='img'>" +
                        "<img src='" + data.podaci[i].slika + "' alt='" + data.podaci[i].serija_naziv + "' title='" + data.podaci[i].serija_naziv + "' width='200' height='150'>" +
                        "</div>";
                    series += "<div class='right-container'>";
                    series += "<div class='date-com'>";
                    series +="<a class='redirect' ><i class='left fa fa-plus'></i><i  class='left fa fa-minus'></i></a>";
                    series += "<h6 class='right' data-idseries='" + data.podaci[i].ID_serija + "' data-series='" + data.podaci[i].serija_naziv + "' >Komentari</h6>";
                    series += "</div>";
                    series += "<div class='details' data-idseries='" + data.podaci[i].ID_serija + "'><h3 class='heading'>" + data.podaci[i].serija_naziv + "</h3><p class='text'>" + tekst.substring(0, 150) + "...</p></div>";
                    series += "</div>";
                    series += "</div>";
                }
                root.html(series);
            }
        },
        error: function (xhr, status, error) {

        }
    });
});
    //prikaz jedne serije
        $(document).on('click','.details',function () {
        var user = $(this).data("user");
        var series = $(this).data("series");
        var id = $(this).data("idseries");
        console.log(id);
        //ovo radimo
        sendToken();
        $.ajax({
            url: "/serija/"+id,
            method: "GET",
            dataType:"JSON",
            success: function (data) {
                var root = $("#articles");
                var series = "<div class='news'>";
                console.log(data.podaci);
                console.log(data.podaci.uloge);
                if(data.korisnik) {
                    for (let i = 0; i < data.podaci.length; i++) {
                        series += "<div>" +
                            "<img src='" + data.podaci[i].slika + "' alt='" + data.podaci[i].serija_naziv + "' title='" + data.podaci[i].serija_naziv + "' width='100%' height='300px'>" +
                            "</div>";
                        series += "<div class='right-container'>";
                        series += "<div class='date-com'>";
                        series += "<h6 class='right' data-idseries='" + data.podaci[i].ID_serija + "' data-user='" + data.korisnik.ID_korisnik + "' data-series='" + data.podaci[i].serija_naziv + "'>Komentari</h6>";
                        series += "</div>";
                        series += "<div class='details no-underline' data-id='" + data.podaci[i].ID_serija + "'>";
                        series += "<h3 class='heading'>" + data.podaci[i].serija_naziv + "</h3>";
                        series += "<h4 class='left'>Godina:" + data.podaci[i].godina + "</h4>";
                        series += "<div class='text'><p>" + data.podaci[i].serija_tekst + "</p></div>";
                        series += "<p class='heading left'>Uloge: </p>";
                        for(let j=0;j<data.glumci.length;j++){
                            series+= "<h4 class='roles'> " + data.glumci[j].glumci_ime + " " + data.glumci[j].glumci_prezime + " </h4><br/>";
                        }

                        series += "</div>";
                    }
                    series += "</div>";
                    root.html(series);
                }
                else{
                    for (let i = 0; i < data.podaci.length; i++) {
                        series += "<div>" +
                            "<img class='big' src='" + data.podaci[i].slika + "' alt='" + data.podaci[i].serija_naziv + "' title='" + data.podaci[i].serija_naziv + "' width='100%' height='300px'>" +
                            "</div>";
                        series += "<div class='right-container'>";
                        series += "<div class='date-com'>";
                        series += "<h6 class='right' data-idseries='" + data.podaci[i].ID_serija + "' data-series='" + data.podaci[i].serija_naziv + "'>Komentari</h6>";
                        series += "</div>";
                        series += "<div class='details no-underline' data-id='" + data.podaci[i].ID_serija + "'>";
                        series += "<h3 class='heading'>" + data.podaci[i].serija_naziv + "</h3>";
                        series += "<h4 class='left'>Godina:" + data.podaci[i].godina + "</h4>";
                        series += "<div class='text'><p>" + data.podaci[i].serija_tekst + "</p></div>";
                        series += "<p class='heading left'>Uloge: </p>";
                        for(let j=0;j<data.glumci.length;j++){
                            series+= "<h4 class='roles'> " + data.glumci[j].glumci_ime + " " + data.glumci[j].glumci_prezime + " </h4><br/>";
                        }

                    }
                    series += "</div>";
                    series += "</div>";
                    root.html(series);
                }
            },
            error: function (xhr, status, error) {
                switch (xhr.status) {
                    // case 404:
                    //     window.location.href = "../greska.php";
                    //     break;
                    case 500:
                        alert("Izvinjavamo se zbog tehničkih problema");
                        break;
                }
            }
        });
    });
//     //lajk komentara
        $(document).on("click",".fa-thumbs-up",function(){
        var series = $(this).data('series');
        var user = $(this).data('user');
        var com = $(this).data('com');
        var object = $(this);
        sendToken();
        $.ajax({
            url:"/commentsLike",
            method:"POST",
            data:{
                // series :series,
                user : user,
                com : com
            },
            success:function(data){
                object.html(" Vaš glas je zabeležen ");
            },
            error:function(x,s,e){
                switch (x.status) {
                    case 409:
                        object.html(" Već ste glasali! ");
                        break;
                    case 500:
                        alert("Izvinjavamo se zbog tehničkih problema");
                        break;
                }
            }
        });
    });
//dislike komentara
        $(document).on("click",".fa-thumbs-down",function(){
        var series = $(this).data('series');
        var user = $(this).data('user');
        var com = $(this).data('com');
        var object = $(this);
        sendToken();
        $.ajax({
            url:"/commentsDislike",
            method:"POST",
            data:{
                user : user,
                com : com
            },
            success:function(data){
                object.html(" Vaš glas je zabeležen ");
            },
            error:function(x,s,e){
                switch (x.status) {
                    case 409:
                        object.html(" Već ste glasali ");
                        break;
                    case 500:
                        alert("Izvinjavamo se zbog tehničkih problema");
                        break;
                }
            }
        })
    });
//prikaz komentara za korisnika
//     $(document).on("click",".info",function () {
//         var iduser = $(".info").data("iduser");
//         console.log(iduser);
//         var root = $("#articles");
//         console.log(root);
//         sendToken();
        // $.ajax({
        //     url:"/komentari/"+iduser,
        //     method:"GET",
        //     dataType:"JSON",
            // success:function (data) {
            //     console.log(data);
            //
            //     if(data.length == ''){
            //         com ="<h4 class='comment-heading'>Nemate nijedan komentar</h4>"
                // }
                // else {
                //     var com = "<h4 class='comment-heading'>Vaši komentari:</h4>";
                //     for (var i = 0; i < data.kom.length; i++) {
                //         com += "<div class='comment'>";
                //         com += "<h3 class='comment-user one'>" + data.kom[i].username + " " + data.kom[i].serija_naziv + " " + data.kom[i].datum + "</h3>";
                //         com += "<h5 class='comment-content'>" + data.kom[i].komentar_tekst + "</h5>";
                //         com += "<span class='anketa'><i class='green fa'> " + data.kom[i].komentar_like + " </i><i class='red fa'> " + data.kom[i].komentar_dislike + "</i> <i data-user='" + data.kom[i].ID_korisnik + "' data-com='" + data.kom[i].ID_komentar + "' class='fas fa-trash-alt'></i></span>";
                //         com += "</div>";
                //     }
                // }
                // root.html(com);
            // },
            // error:function (x,s,e) {
            //             alert("Izvinjavamo se zbog tehničkih problema");
            //     }
        // });
    // });
//     //brisanje komentara
    $(document).on('click','.fa-trash-alt',function () {
        // e.stopPropagation();
        var com = $(this).data('com');
        var user = $(this).data('user');
        sendToken();
        $.ajax({
            url:"commentsDelete",
            method:"DELETE",
            data:{
                com:com,
                user:user
            },
            success:function (data) {
                alert("Uspešno ste obrisali komentar!");
                location.reload();
            },
            error:function (x,s,e) {
                alert("Izvinjavamo se zbog tehničkih problema");
                }
        });
    });
//dislajk serije
    $(document).on("click",".vote-series-minus",function(){
        var series = $(this).data('series');
        var user = $(this).data('user');
        var object = $(this);
        console.log(series);
        console.log(user);
        sendToken();
        $.ajax({
            url:"/seriesDislike",
            method:"POST",
            data:{
                series:series,
                user:user
            },
            success:function(data){
                console.log("da");
                console.log(data);
                object.html("Vaš glas je zabeležen");
            },
            error:function(x,s,e){
                console.log("ne");
                switch (x.status) {
                    case 409:
                        object.html(" Već ste glasali ");
                        break;
                    case 500:
                        alert("Izvinjavamo se zbog tehničkih problema");
                        break;
                }
            }
        });
    });
    //lajk serije
    $(document).on("click",".vote-series-plus",function(){
        var series = $(this).data('series');
        var user = $(this).data('user');
        var object = $(this);
        console.log(series);
        console.log(user);
        sendToken();
        $.ajax({
            url:"/seriesLike",
            method:"POST",
            data:{
                series:series,
                user:user
            },
            success:function(data){
                console.log(data);
                object.html("Vaš glas je zabeležen");
            },
            error:function(x,s,e){
                console.log("ne");
                switch (x.status) {
                    case 409:
                        object.html(" Već ste glasali ");
                        break;
                    case 500:
                        alert("Izvinjavamo se zbog tehničkih problema");
                        break;
                }
            }
        });
    });
});