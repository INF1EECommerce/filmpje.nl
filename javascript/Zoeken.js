
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

            $.getJSON('backend/JSON/Zoeken.php', {
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
    var dupes = [];
    var gevondenOp = [];
    var singles = [];
    
    $.each(ZoekResultaten, function(){
       
       if (!dupes[this.Naam]) {
        dupes[this.Naam] = true;
        singles.push(this);
        gevondenOp.push(this.Naam); 
        gevondenOp[this.Naam] = [];
        gevondenOp[this.Naam]["Matches"] = [];
        gevondenOp[this.Naam]["Matches"].push(this.MatchType);
        }
        else  
        {
         gevondenOp[this.Naam]["Matches"].push(this.MatchType);  
        }
       
    });
    
    var html ="";
    var zoekDiv = $('#ZoekPopup');
    $.each(singles, function(){
                
                html += "<table>\n\
                        <thead><th colspan='2'>" + this.Naam  + "</th></tr></thead>";
                html += "<tr><td class=\"ZoekPopupCover\"><a href='films.php?filmid=+" + this.FilmID + "'>\n\
                            <img src='image/Covers/" + this.Cover  + "'></a></td>\n\
                            <td class=\"ZoekPopupText\">\n\
                            <a href='films.php?filmid="+this.FilmID+"'>\n\
                            <strong>Regisseur: </strong>"+ this.Regisseur + "<br>\n\
                            <strong>Genre: </strong>" + this.Genre + "<br>\n\
                            <strong>Duur: </strong>"+ this.Duur + " minuten<br>\n\
                            <strong>IMDB: </strong>"+ this.Beoordeling+"<br><br>\n\
                            <strong>Gevonden op: "; 
                html +=  gevondenOp[this.Naam]["Matches"].join(", ");
         
                html += "</strong></a></td>\n\
                        </tr>\n\
                       </table>"  ;  
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
