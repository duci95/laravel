var btn = $("#btn");
var first = $("#ime");
var last = $("#prezime");
var ID = $("#ID");
var feeedbackOk = $("#f200");
var feedbackError1 = $("#f500");
var div = $("#errors");
var er = $(".er");
var falsee = $(".false");
var errors = [];
btn.click(() => {
    var reFirst= /^([A-ZŠĐČĆŽ][a-zšđčćž\-']{2,15})(\s[A-ZŠĐČĆŽ][a-zšđčćž\-']{2,15})*$/;
    var reLast=  /^([A-ZŠĐČĆŽ][a-zšđčćž\-']{2,25})(\s[A-ZŠĐČĆŽ][a-zšđčćž\-']{2,25})*$/;
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
            url: "/admin/uloge/izmena/"+ID.val(),
            method: "PUT",
            data: {
                first: first.val(),
                last: last.val()
            },
            success: function (data, xhr) {
                feedbackError1.css("display", "none");
                feeedbackOk.css("display", "block");
            },
            error: function (xhr, status, error) {
                alert("Doslo je do greske!");
            }
        });
    }
});
