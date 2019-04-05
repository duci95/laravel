
    var username = $("#username");
    var password = $("#password");
    var btn = $("#btn");
    var feeedbackOk = $("#f200");
    var feedbackError = $("#f400");
    var feedbackError1 = $("#f500");
    var div = $("#errors");
    var er = $(".er");
    var falsee = $(".false");
    btn.click(function () {
        var reUsername = /^[a-zšđčćž0-9]{6,15}$/;
        var rePassword =  /^[A-ZŠĐČĆŽa-zšđčćž?!&^#|$%@*\/0-9]{8,15}$/;
        var errors = [];
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
        if(errors.length > 0){
            feedbackError.css("display", "none");
            feedbackError1.css("display", "none");
            var error ="";
            for(var x in errors){
                error += `<p class="false er">${errors[x]}</p>`;
            }
            div.html(error);
        }
        else {
            $.ajaxSetup({
                headers : {
                    "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
                },
                accept : "application/json"
            });
            $.ajax({
               url:"/login",
               method:"POST",
               data:{
                   username : username.val(),
                   password : password.val()
               },
                success:function (data) {
                    er.css("display","none");
                    div.css("display", "none");
                    feeedbackOk.css("display", "block");
                    window.location.href = "/";
                },
                error:function (xhr,status,error) {
                    switch (xhr.status) {
                         case 401:
                            feeedbackOk.css("display", "none");
                            feedbackError.css("display", "block");
                            feedbackError1.css("display", "none");
                            div.css("display", "none");
                        break;
                        case 500 :
                            feeedbackOk.css("display", "none");
                            feedbackError1.css("display", "block");
                            feedbackError.css("display", "none");
                            div.css("display", "none");
                        break;
                    }
                }
            });
        }
    });
