
var ZoekResultaten;
$(document).mouseup(function (e)
{
    var container = $("#ZoekPopup");

    if (container.has(e.target).length === 0)
    {
        VerbergZoekDiv();
    }
});


$(document).ready(function() {
    
    $("#qtext").bind('input', function(event)
    {
        var ZoekString = event.target.value;

        if (ZoekString.length >= 3) {

            $.getJSON('backend/zoeken.php', {
                q : ZoekString
            }, function(data)
            {                                 
                if (data.length > 0) {
                            
                     
                
                    ZoekResultaten = data
                             
                    //teken de stoelen
                    VulZoekDiv();
                }
                else
                {
                    VerbergZoekDiv();
                }

            });

        }
        else
        {
            VerbergZoekDiv();
        }
   
    });
});

function VulZoekDiv()
{
    var html ="";
    var zoekDiv = $('#ZoekPopup');
    $.each(ZoekResultaten, function(){
        
        html += "<table><thead><th colspan='2'>" + this.Naam  + " ("+this.MatchType+")</th></tr></thead>";
        html += "<tr><td><a href='films.php?filmid=+" + this.FilmID + "'><img src='image/Covers/" + this.Cover  + "'></a></td><td><a href='films.php?filmid="+this.FilmID+"'>Genre: " + this.Genre + "<br>Duur: "+ this.Duur + " minuten<br>IMDB: "+ this.Beoordeling+"</a></td></tr>"  ;  
        html += "</table>"  ;  
    });
    
    $(zoekDiv).html(html);
    $(zoekDiv).show("slide", {
        direction: "up"
    }, 200);
}

function VerbergZoekDiv()
{
    var zoekDiv = $('#ZoekPopup');
    $(zoekDiv).hide("slide", {
        direction: "up"
    }, 200);
        
}
