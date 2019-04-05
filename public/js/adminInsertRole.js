var btn = $("#btn");
var first = $("#ime");
var last = $("#prezime");
var feeedbackOk = $("#f200");
var feedbackError1 = $("#f500");
var div = $("#errors");
var er = $(".er");
var falsee = $(".false");
var errors = [];
btn.click(() => {
    var reFirst= /^([A-ZŠĐČĆŽ][a-zšđčćž\s]{2,15})(\s[A-ZŠĐČĆŽ][a-zšđčćž\s]{2,15})*$/;
    var reLast=  /^([A-ZŠĐČĆŽ][a-zšđčćž\s]{2,25})(\s[A-ZŠĐČĆŽ][a-zšđčćž\s]{2,25})*$/;
    if(!reFirst.test(first.val().trim())){
        first.css("border","1px solid red");
        errors.push("Ime mora početi velikim slovom! <br/> Ime ne sme biti kraće od 3 i duže od 16 karaktera!");
        console.log(first.val());
    }
    else{
        first.css("border","");
    }
    if(!reLast.test(last.val().trim())){
        last.css("border","1px solid red");
        errors.push("Prezime mora početi velikim slovom!<br/>Prezime ne sme biti kraće od 3 i duže od 26 karaktera!");
    }
    else{
        last.css("border","");
    }
    if (errors.length > 0) {
        feedbackError1.css("display", "none");
        var error = "";
        for (var x in errors) {
            error += "<p class='false er'>" + errors[x] + "</p>";
        }
        div.html(error);
    }
    else {
        div.html("");
        $.ajaxSetup({
            headers:{
                "X-CSRF-TOKEN" : $('meta[name="_token"]').attr("content")
            }
        });
        $.ajax({
            url: "/admin/uloge/unos",
            method: "POST",
            data: {
                first: first.val(),
                last: last.val()
            },
            success: function (data, xhr) {
                feedbackError1.css("display", "none");
                feeedbackOk.css("display", "block");
            },
            error: function (xhr, status, error) {
                switch(xhr.status){
                    case 500:
                        feeedbackOk.css("display","none");
                        feedbackError1.css("display","block");
                        break;
                    case 422:
                        div.html("<p class='false er'>Vec postoji glumac sa ovim podacima!</p>");
                        feeedbackOk.css("display","none");
                        feedbackError1.css("display","none");
                        break;
                }
            }
        });
    }
});
