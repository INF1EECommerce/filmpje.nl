function BestellenKlik(voorstellingId)
{
     var input = document.getElementById('voorstelling');
     input.value = voorstellingId;
     var input2 = document.getElementById('modus');
     input2.value = 'bestellen';
     document.getElementById('voorstellingForm').submit();
}

function ReserverenKlik(voorstellingId)
{
     var input = document.getElementById('voorstelling');
     input.value = voorstellingId;
     var input2 = document.getElementById('modus');
     input2.value = 'reserveren';
     document.getElementById('voorstellingForm').submit();
}


var SelectedButton;

  $(document).ready(function () { 
    $("#TijdKlikPopup").toggle(false); 


  }); 

    $(document).mouseup(function (e)
{
    var container = $("#TijdKlikPopup");

    if (container.has(e.target).length === 0 && e.target.id.substr(0,5) != "timeb")
    {
     $("#TijdKlikPopup").toggle(false);
    $(SelectedButton).css({background: "",
	color: ""});  
    }
});


function TijdKlik(voorstellingID, button, reserveren, beschikbarestoelen)
{  
     if (reserveren) {
        
        $('#TijdKlikPopUpHeader').html("<p style='margin: -10px -10px 5px;' class='blockheader'>Bestellen\\Reserveren</p>Wilt u voor deze voorstelling kaarten bestellen of reserveren?<br><br><strong>Er zijn nog "+beschikbarestoelen+" stoelen beschikbaar.</strong>");
        $('#popuprb').removeAttr('disabled');
        $('#popuprb').off('click');
        $('#popupbb').off('click');
        $('#popuprb').on('click',function() {ReserverenKlik(voorstellingID)});
        $('#popupbb').on('click',function() {BestellenKlik(voorstellingID)});
    }
    else
        {
            $('#TijdKlikPopUpHeader').html("<p style='margin: -10px -10px 5px;' class='blockheader'>Bestellen\\Reserveren</p>Omdat deze voorstelling minder dan 24 uur in de toekomst ligt kunt u op dit moment alleen nog kaarten bestellen.<br><br><strong>Er zijn nog "+beschikbarestoelen+" stoelen beschikbaar.</strong>");
            $('#popuprb').attr('disabled', 'disabled');
            $('#popupbb').off('click');
            $('#popupbb').on('click',function() {BestellenKlik(voorstellingID); });
        }
    
    var offset;
    
    if ($("#TijdKlikPopup").is(":hidden")) {
        if (button != SelectedButton) {
           offset = $(button).offset();
           $('#TijdKlikPopup')
          .css({
              position: "absolute",
              top: offset.top - ($('#TijdKlikPopup').height()+15),
              left: offset.left - 90,
              opacity: 1
          });
           $('#TijdKlikPopup').show("slide", { direction: "down" }, 200);
        $(SelectedButton).css({background: "",
	color: ""});  
        $(button).css({ background: "#660000",
	color: "#fff" })
        SelectedButton = button;
        }
        else
        {
        $(SelectedButton).css({ background: "#660000",
	color: "#fff" });
            $('#TijdKlikPopup')
          .show("slide", { direction: "down" }, 200);
          
        }
        
    } else {
          
          if (button != SelectedButton) {
          offset = $(button).offset();
           $('#TijdKlikPopup')
          .toggle();
          
          $('#TijdKlikPopup').css({
              position: "absolute",
              top: offset.top - ($('#TijdKlikPopup').height()+15),
              left: offset.left - 90,
              opacity: 1
          });
          
          $('#TijdKlikPopup')
          .show("slide", { direction: "down" }, 200)
         
          
          $(SelectedButton).css({ background: "",
                color: "" });
          $(button).css({ background: "#660000",
	color: "#fff" });
          SelectedButton = button;
          }
          else
          {
             $('#TijdKlikPopup').hide("slide", { direction: "down" }, 200); 
          $(button).css({ background: "",
                color: "" });
          }
     
    }

   

}



