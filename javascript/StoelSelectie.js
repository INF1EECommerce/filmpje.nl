var geselecteerdeStoelen = new Array();
var totaalPrijs = 0;
    
$(document).ready(function()
{
    RenderStoelSelectie();
});
    
    
function VolgendeKnopAanUitBepalen()
{
    if (geselecteerdeStoelen.length > 0) {
        document.GeselecteerdeStoelenForm.submitB.disabled=false;
    }
    else
    {
        document.GeselecteerdeStoelenForm.submitB.disabled=true;
    }
}
                           
function WerkStoelenInFormBij()
{
    $('#gs').val(geselecteerdeStoelen.toString());
}
                            
function RenderStoelSelectie()
{
                                                   
    //haal de zaalinfo op
    // Voorstelling komt uit PGP (db);
    $.getJSON('backend/JSON/Zaalinfo.php', {
        voorstelling : Voorstelling
    }, function(data)
{
        var ZaalInfoData = data;
//        Rijen = data[0].Rijen;
//        Stoelen = data[0].MaxStoelenPerRij;

        //na callback haal de beschikbare stoelen op
        $.getJSON('backend/JSON/BeschikbareStoelen.php', {
            voorstelling : Voorstelling
        }, function(data)
{     
            var StoelInfoData = data;  
            //teken de stoelen
            MaakStoelenDivLeeg();
            TekenStoelen(ZaalInfoData, StoelInfoData);
            
        });
    });
                                
}
                            
function MaakStoelenDivLeeg()
{
    $("#Stoelen").empty();
}
                            
function TekenStoelen(ZaalInfoData, StoelInfoData) {
    
    //het aantal rijen in de zaal en het max aantal stoelen
    var Rijen = ZaalInfoData[0]['Rijen'];
    var MaxStoelen = ZaalInfoData[0]['MaxStoelenPerRij'];
    var LooppadBijRijen = ZaalInfoData[0]['LooppadBijRijen'].split(",");
    var LooppadBijStoelen = ZaalInfoData[0]['LooppadBijStoelen'].split(",");
    
    //maak de tabel aan
    var StoelenDiv = $("#Stoelen")
    var tbl = $("<table></table>")
    .appendTo(StoelenDiv);
    $("<caption></caption>")
    .text("SCHERM")
    .attr("id","scherm")
    .appendTo(tbl);
    var tblh = $("<thead></thead>").appendTo(tbl);   
       
    //Maak stoelnummer rij aan +
    //R\S cel links boven
    $("<th></th>")
    .text("R\\S")
    .appendTo(tblh); 
                                
    //Stoelnummers toevoegen aan de stoelnummer rij
    for (i = 1; i <= MaxStoelen; i++) {
       $("<th></th>")
       .text(i)
       .appendTo(tblh);
        //looppad wanneer nodig
        if ($.inArray(i.toString(), LooppadBijStoelen) != -1) {
            $("<th></th>")
            .attr("style", "width:3px;")
            .appendTo(tblh);
        }

    }
                            
    //Lus door de rijen heen en voeg deze toe aan de tabel + rijnummer
    var tblb = $("<tbody></tbody>").appendTo(tbl);
   
    for (var j = 1; j <= Rijen; j++) {
        
        var tblr = $("<tr></tr>").appendTo(tblb);
        var tbltd = $("<td></td>").appendTo(tblr);
        tbltd.addClass("RijNummerCell")
        tbltd.text(j);
        
        if ($.inArray(j.toString(), LooppadBijRijen) != -1) {
           var trlp = $("<tr></tr>")
            .appendTo(tblb)
            trlp.attr("style", "height:5px;");
            var tdlp = $("<td></td>")
            .addClass("RijNummerCell")
            .appendTo(trlp);
            //tdlp.attr("colspan", (parseInt(MaxStoelen) + 1 + LooppadBijStoelen.length).toString())
        }
        
        var rijInfo = RijInfo(j, ZaalInfoData);
        
        //lus door de stoelen heen en voeg deze toe aan de rij.
        for (var i = 1; i <= MaxStoelen; i++) {
            var td = $("<td></td>").appendTo(tblr);
            
            //haal alleen de stoelinfo op voor stoelen die daadwerkelijk bestaan binnen de rij.
            if(i < rijInfo[0]['MinStoelNummer'] || i > rijInfo[0]['MaxStoelNummer'])
            continue;
            //check of de stoel beschikbaar is op basis van de beschikbare stoelen array.  
            var stoelInfo = StoelInfo(i, j, StoelInfoData);
                                        
            if (stoelInfo.length > 0) 
            {                              
                td.attr("id", stoelInfo[0]['StoelID']);
                                            
                switch (stoelInfo[0]['StoelType']) {
                    case 'Normaal':
                        td.attr("class", "NormaalStoel");
                        break;       
                    case 'Primium':
                        td.attr("class", "PrimiumStoel");
                        break
                    case 'VIP':
                        td.attr("class", "VIPStoel");
                        break;
                }
                $(td).click(
                {
                    stoelId: stoelInfo[0]['StoelID'], 
                    stoelType: stoelInfo[0]['StoelType'], 
                    stoelPrijs: stoelInfo[0]['StoelPrijs'], 
                    stoelRij: stoelInfo[0]['RijNummer'],
                    stoelNummer: stoelInfo[0]['StoelNummer']
                }, StoelGeselecteerd);
            }
            else
            {
                td.attr("id", "NA");
                td.attr("class", "onbeschikbaar");
                                             
            }
            //looppad wanneer nodig
            if ($.inArray(i.toString(), LooppadBijStoelen) != -1) {
                $("<td></td>")
                .attr("style", "width:3px;")
                .appendTo(tblr);
            }
           
    }
}
}
                        
function StoelGeselecteerd(event)
{
    var stoel = $('#'+ event.data.stoelId);
    if ($.inArray(event.data.stoelId, geselecteerdeStoelen) != -1) {
        
                                         
        geselecteerdeStoelen.splice($.inArray(event.data.stoelId, geselecteerdeStoelen), 1);
        VerwijderenOverzichtTabelRij(event.data.stoelId);
        WerkTotaalPrijsBij(parseFloat(event.data.stoelPrijs) * -1);
        WerkStoelenInFormBij();
        VolgendeKnopAanUitBepalen();
        stoel.removeAttr("style");
    }
    else
    {
        geselecteerdeStoelen.push(event.data.stoelId);
        ToevoegenOverzichtTabelRij(event.data.stoelRij, event.data.stoelNummer, event.data.stoelType, event.data.stoelPrijs, event.data.stoelId);
        WerkTotaalPrijsBij(parseFloat(event.data.stoelPrijs));
        WerkStoelenInFormBij();
        VolgendeKnopAanUitBepalen();    
        stoel.attr("style", "background-color: #FFF;");
    }
                                
                                    
}
                        
function ToevoegenOverzichtTabelRij(Rij, Nummer, Type, Prijs, Id)
{
    var Tb = $("#Stap1GeselecteerdeStoelenTB");
    var Row = $('<tr></tr>');
    $('<td>' + Rij + '</td>').appendTo(Row);  
    $('<td>' + Nummer + '</td>').appendTo(Row);
    $('<td>' + Type + '</td>').appendTo(Row);
    $('<td>&euro; ' + Prijs.replace(".", ",") + '</td>')
    .attr('id', 'dataRow-' + Id)
    .appendTo(Row);
    Row.appendTo(Tb);                          
}

  
  
function WerkTotaalPrijsBij(Prijs)
{
    totaalPrijs = totaalPrijs + Prijs;
    $('#totaalPrijs').html("&euro; " + totaalPrijs.toFixed(2).replace(".", ","));
    var ht = $('#HelpText1');
    
    if (geselecteerdeStoelen.length > 0) {
                                
        ht.attr("style", "display:none;")
    }
    else
    {
        ht.removeAttr("style");
    }

}
                        
function VerwijderenOverzichtTabelRij(Id)
{
    $('#dataRow-' + Id).parent().remove(); 
 
}

function RijInfo(RijNummer, ZaalInfo)
{
    var result = $.grep(ZaalInfo, function(value)
    {
        if (value['RijNummer'] == RijNummer) {
                return true
            }
        else
        {
            return false;
        }
    }); 
    
    return result;
}

                        
function StoelInfo(Stoel,Rij, StoelInfo)
{
    var StoelenInRij = $.grep(StoelInfo, function(value, i) {
        if(value['RijNummer'] != Rij){
            return false   
        }
        else
        {
            return true;
        }
    });                              
                             
    var Result = $.grep(StoelenInRij, function(value, i) {
        if(value['StoelNummer'] != Stoel){
            return false   
        }
        else
        {
            return true;
        }
    });
    
    return Result;
}