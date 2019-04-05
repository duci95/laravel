   var btn = $(".delSponsor");
   btn.click(function () {
      var id = $(this).data('id');
      $.ajaxSetup({
          headers: {
              "X-CSRF-TOKEN" : $("meta[name='_token']").attr("content")
          }
      });
      $.ajax({
          url:"/admin/uloge/brisanje/"+id,
          method:"DELETE",
          success:function (data) {
              alert("Uspešno ste obrisali glumca/glumicu");
              location.reload();
          },
          error:function (x,s,e) {
              alert("Greška pri brisanju, kontakirajte admina");
          }
      });
   });


