var first = $("#first");
var last = $("#last");
var email = $("#email");
var btn = $("#btn");
var city = $("#city");
var username = $("#username");
var password = $("#password");
var passwordConfirm = $("#password1");
var feeedbackOk = $("#f200");
var feedbackError1 = $("#f500");
var div = $("#errors");
var er = $(".er");
var falsee = $(".false");
btn.click(function() {
    var reFirst= /^([A-ZŠĐČĆŽ][a-zšđčćž\-']{2,15})(\s[A-ZŠĐČĆŽ][a-zšđčćž\-']{2,15})*$/;
    var reLast=  /^([A-ZŠĐČĆŽ][a-zšđčćž\-']{2,25})(\s[A-ZŠĐČĆŽ][a-zšđčćž\-']{2,25})*$/;
    var reEmail = /^[^@\s]{3,25}@[^@\s]{2,10}\.[^@\s]{2,7}$/;
    var cityValue = city.val();
    var gender = $("input[type='radio']:checked");
    var reUsername = /^[a-zšđčćž0-9]{6,15}$/;
    var rePassword =  /^[A-ZŠĐČĆŽa-zšđčćž?!&^#|$%@*\/0-9]{8,15}$/;
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
        errors.push("Korisničko ime ne sme biti kraće od 6 i duže od 15 karaktera! <br/> Nisu dozvoljeni specijalni karakteri i velika slova!");
    }
    else{
        username.css("border","");
    }
    if(!rePassword.test(password.val())){
        password.css("border","1px solid red");
        errors.push("Lozinka ne sme biti kraća od 8 i duža od 15 karaktera!<br/>  Dozvoljeni su specijalni karakteri i velika slova!");
    }
    else{
        password.css("border","");
    }
    if(password.val() !== passwordConfirm.val()){
        passwordConfirm.css("border","1px solid red");
        errors.push("Lozinke se ne podudaraju!");
    }
    else if(passwordConfirm.val()===""){
        passwordConfirm.css("border","1px solid red");
        errors.push("Morate potvrditi lozinku!");
    }
    else{
        passwordConfirm.css("border","");
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
            url:"/register",
            method:"POST",
            // dataType:"JSON",
            data:{
                firstname:first.val(),
                lastname:last.val(),
                email:email.val(),
                gender:gender.val(),
                city:cityValue,
                username:username.val(),
                password:password.val(),
                passwordConfirm:passwordConfirm.val()
            },
            success:function (data) {
                console.log(data.data);
                div.css("display","none");
                feeedbackOk.css("display","block");
                feedbackError1.css("display","none");
            },
            error:function (xhr,status,error) {
                console.log("evo me");
                switch(xhr.status){
                    case 500:
                        div.css("display","none");
                        feeedbackOk.html("display","none");
                        feedbackError1.css("display","block");
                    break;
                    case 422:
                        div.html("<p class='false er'>Korisničko ime je zauzeto!</p>");
                        feeedbackOk.css("display","none");
                        feedbackError1.css("display","none");
                        username.css("border","1px solid red");
                    break;
                }
            }
        });
    }
});
