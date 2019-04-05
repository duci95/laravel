var ID = $("#ID");
var first = $("#first");
var last = $("#last");
var email = $("#email");
var btn = $("#btn");
var city = $("#city");
var roll = $("#roll");
var active = $("#active");
var status = $("#a");
var username = $("#username");
var feeedbackOk = $("#f200");
var feedbackError1 = $("#f500");
var div = $("#errors");
var er = $(".er");
var falsee = $(".false");
btn.click(() =>{
    var reFirst= /^([A-ZŠĐČĆŽ][a-zšđčćž\-']{2,15})(\s[A-ZŠĐČĆŽ][a-zšđčćž\-']{2,15})*$/;
    var reLast=  /^([A-ZŠĐČĆŽ][a-zšđčćž\-']{2,25})(\s[A-ZŠĐČĆŽ][a-zšđčćž\-']{2,25})*$/;
    var reEmail = /^[^@\s]{3,25}@[^@\s]{2,10}\.[^@\s]{2,7}$/;
    var cityValue = city.val();
    var rollValue = roll.val();
    var activeValue = active.val();
    var gender = $("input[type='radio']:checked");
    var reUsername = /^[a-zšđčćž0-9]{6,15}$/;
    var errors = [];
    if(!reFirst.test(first.val())){
        first.css("border","1px solid red");
        errors.push("Ime mora početi velikim slovom! <br/> Ime ne sme biti kraće od 3 i duže od 16 karaktera!");
        console.log(first.val());
    }
    else{
        first.css("border","");
    }
    if(!reLast.test(last.val())){
        last.css("border","1px solid red");
        errors.push("Prezime mora početi velikim slovom!<br/>Prezime ne sme biti kraće od 3 i duže od 26 karaktera!");
    }
    else{
        last.css("border","");
    }
    if(!reEmail.test(email.val())){
        email.css("border","1px solid red");
        errors.push("Email nije u dobrom formatu!");
    }
    else{
        email.css("border","");
    }
    if(cityValue==="0"){
        city.css("border","1px solid red");
        errors.push("Morate izabrati grad!");
    }
    else{
        city.css("border","");
    }
    if(!reUsername.test(username.val())){
        username.css("border","1px solid red");
        errors.push("Korisničko ime ne sme biti kraće od 6 i duže od 15 karaktera!<br/>Nisu dozvoljeni specijalni karakteri i velika slova!");
    }
    else{
        username.css("border","");
    }
    if(rollValue==="0"){
        roll.css("border","1px solid red");
        errors.push("Morate izabrati ulogu!");
    }
    else{
        roll.css("border","");
    }

    if(activeValue==="null"){
        active.css("border","1px solid red");
        errors.push("Morate izabrati aktivnost!");
    }
    else{
        active.css("border","");
    }
    if($('#a').val()==="null"){
        $('#a').css("border","1px solid red");
        errors.push("Morate izabrati aktivnost!");
    }
    else{
        $('#a').css("border","");
    }
    if(errors.length > 0){
        feedbackError1.css("display", "none");
        var error ="";
        for(var x in errors){
            error += "<p class='false er'>"+errors[x]+"</p>";
        }
        div.html(error);
    }
    else{
        $.ajaxSetup({
            headers : {
                "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
            }
        });
        $.ajax({
            url:"/admin/korisnici/izmena/"+ID.val(),
            method:"POST",
            data:{
                ID:ID.val(),
                firstname:first.val(),
                lastname:last.val(),
                email:email.val(),
                gender:gender.val(),
                city:cityValue,
                username:username.val(),
                roll:rollValue,
                active:activeValue,
                status:$("#a").val(),
            },
            success:function (data,xhr) {
                feeedbackOk.css("display","block");
            },
            error:function (xhr,status,error) {
                switch (xhr.status) {
                    case 404:
                        window.location.href="../greska.php";
                        break;
                    case 422:
                        alert("Izvinjavamo se zbog tehničkih problema");
                        break;
                    case 409:
                        div.html("<p class='false er'>Korisničko ime je zauzeto!</p>");
                        feeedbackOk.css("display","none");
                        feedbackError1.css("display","none");
                        break;

                }
            }
        });
    }
});
