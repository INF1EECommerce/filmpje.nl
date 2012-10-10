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

function DagButtonClick (dag)
{
    if ($("#TijdKlikPopup").not(":hidden")) {
    $("#TijdKlikPopup").toggle(false);
    $(SelectedButton).css({background: "",
	color: ""});  
    }
    switch (dag) {
            case 'Vandaag':
                document.getElementById('Vandaagfilms').style.display = 'block';
                document.getElementById('Morgenfilms').style.display = 'none';
                document.getElementById('Overmorgenfilms').style.display = 'none';
                
                document.getElementById('vandaagButton').className = 'currentDate';
                document.getElementById('morgenButton').className = '';
                document.getElementById('overmorgenButton').className = '';
                break;
            case 'Morgen':
                document.getElementById('Vandaagfilms').style.display = 'none';
                document.getElementById('Morgenfilms').style.display = 'block';
                document.getElementById('Overmorgenfilms').style.display = 'none';
                
                document.getElementById('vandaagButton').className = '';
                document.getElementById('morgenButton').className = 'currentDate';
                document.getElementById('overmorgenButton').className = '';
                break;
            case 'Overmorgen':
                document.getElementById('Vandaagfilms').style.display = 'none';
                document.getElementById('Morgenfilms').style.display = 'none';
                document.getElementById('Overmorgenfilms').style.display = 'block';
                
                document.getElementById('vandaagButton').className = '';
                document.getElementById('morgenButton').className = '';
                document.getElementById('overmorgenButton').className = 'currentDate';
            default:
                break;
        }

}

var SelectedButton;

  $(document).ready(function () { 
    $("#TijdKlikPopup").toggle(false); 
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
          .toggle()
          .css({
              position: "absolute",
              top: offset.top - ($('#TijdKlikPopup').height()+15),
              left: offset.left - 90,
              opacity: 1
          });
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
          .toggle();
          
        }
        
    } else {
          
          if (button != SelectedButton) {
          offset = $(button).offset();
           $('#TijdKlikPopup')
          .toggle();
          $('#TijdKlikPopup')
          .toggle()
          .css({
              position: "absolute",
              top: offset.top - ($('#TijdKlikPopup').height()+15),
              left: offset.left - 90,
              opacity: 1
          });
          $(SelectedButton).css({ background: "",
                color: "" });
          $(button).css({ background: "#660000",
	color: "#fff" });
          SelectedButton = button;
          }
          else
          {
             $('#TijdKlikPopup').toggle(); 
          $(button).css({ background: "",
                color: "" });
          }
     
    }

   

}



