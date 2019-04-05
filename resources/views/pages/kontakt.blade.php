@extends('layouts.master')
@section('title','Kontakt')
@section('content')
    <div id="articles">
        <div id="kontakt_forma">

            <form id="obrazac1" >
                <input type="text" id="imeKontakt" autofocus="autofocus" placeholder="Ime"/>
                <input type="text" id="prezimeKontakt" placeholder="Prezime"/>
                <input type="text"  id="emailKontakt"  placeholder="Email"/>
                <textarea id="pitanje"   placeholder="Vaše pitanje"></textarea>
                <input type="button" value="Pošalji" class="btn" name="contact" id="userFeedback"/>
                <br/>
                <br/>
                <span id="kontaktOk">Pitanje uspešno poslato!</span>
            </form>
        </div>
    </div>
    <script src="{{asset('/')}}js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var btn = $("#userFeedback");
        btn.click(function () {
            var firstname = $("#imeKontakt");
            var lastname = $("#prezimeKontakt");
            var email = $("#emailKontakt");
            var reFirstnameLastname = /^[A-ZŠĐČĆŽa-zšđžčć\s]{2,25}$/;
            var reEmail = /^[^@\s]{3,25}@[^@\s]{2,8}\.[^@\s]{2,6}$/;
            var errors = [];
            var content = $("#pitanje");
            if(!reFirstnameLastname.test(firstname.val())){
                firstname.css(
                    "border", "1px solid red"
                );

                errors.push("Ime mora početi velikim slovom");
            }
            else{
                firstname.css("border" ,"1px solid #14a1e2");
            }
            if(!reFirstnameLastname.test(lastname.val())){
                lastname.css({
                    border: "1px solid red"
                });
                errors.push("Prezime mora početi velikim slovom");
            }
            else{
                lastname.css("border", "1px solid #14a1e2");
            }
            if(!reEmail.test(email.val())){
                email.css({
                    border: "1px solid red"
                });
                errors.push("Email nije u dobrom formatu");
            }
            else{
                email.css("border", "1px solid #14a1e2");
            }
            if(content.val().length < 10){
                content.css({
                    border: "1px solid red"
                });
                errors.push("Sadrzaj je prekratak");
            }
            else{
                content.css("border","1px solid #14a1e2");
            }
            if(errors.length > 0)
                console.log("Greska");
            else {
                $.ajaxSetup({
                   headers:{
                       'X-CSRF-TOKEN' : $('meta[name="_token"]').attr('content')
                   }
                });
                $.ajax({
                    url: "/feedback",
                    method: "POST",
                    data: {
                        ime: firstname.val(),
                        prezime: lastname.val(),
                        email: email.val(),
                        content: content.val()
                    },
                    success: function(data, xhr) {
                        $("#kontaktOk").css("display", "block");
                    },
                    error: function(xhr, status, error){
                        alert("Izvinjavamo se, trenutno imamo tehničkih problema");
                    }
                });
            }
        });
    </script>
@endsection