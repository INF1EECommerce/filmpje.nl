
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
    var html ="<p>Zoekresultaten</p>";
    var zoekDiv = $('#ZoekPopup');
    $.each(ZoekResultaten, function(){
        
        html += "<table><thead><th colspan='2'>" + this.Naam  + "</th></tr></thead>";
        html += "<tr><td><a href='films.php?filmid=+" + this.FilmID + "'><img src='image/Covers/" + this.Cover  + "'></a></td><td><a href='films.php?filmid="+this.FilmID+"'>" + this.Beschrijving + "</a></td></tr>"  ;  
        html += "<tfoot><tr><td colspan='2'>Gevonden op: "+ this.MatchType  +"</td></tr></tfoot></table>"  ;  
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
