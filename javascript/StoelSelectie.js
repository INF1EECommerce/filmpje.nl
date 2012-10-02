                           var geselecteerdeStoelen = new Array();
                           var totaalPrijs = 0;
                           
                            function WerkStoelenInFormBij()
                            {
                                document.getElementById('gs').value = geselecteerdeStoelen.toString();
                            }
                            
                            function HaalBeschikbareStoelenOp()
                            {
                                var Rijen = 0;
                                var Stoelen = 0;
                                var BeschikbareStoelen = 0;
                                
                                
                                //haal de zaalinfo op
                                
                                $.getJSON('backend/zaalinfo.php', { voorstelling : Voorstelling }, function(data)
                                {
                                    $.each(data, function()
                                                {
                                                    Rijen = this.Rijen;
                                                    Stoelen = this.MaxStoelenPerRij;
                                                });
                                                
                                                  //na callback haal de beschikbare stoelen op
                                
                                                $.getJSON('backend/beschikbarestoelen.php', { voorstelling : Voorstelling }, function(data)
                                                {
                                                        
                                                    BeschikbareStoelen = data;
                                                    
                                                    
                                                    
                                                    
                                                    //teken de stoelen
                                                    TekenStoelen(Rijen, Stoelen, BeschikbareStoelen);

                                                });

                                                });
                                
                            }
                            
                            
                            
                            function TekenStoelen(Rijen, Stoelen, BeschikareStoelen) {
                                
                                //maak de tabel aan
                                var StoelenDiv = document.getElementById("Stoelen")
                                var tbl     = document.createElement("table");
                                var tblB = document.createElement("tbody");
                                
                                //Maak stoelnummer rij aan
                                var StoelNummerRow = document.createElement("thead");
                                
                                //Rijnummer cel links boven
                                var RijnummerText = document.createTextNode("SN:");
                                var RijnummerTextCell = document.createElement("th");
                                RijnummerTextCell.appendChild(RijnummerText);
                                StoelNummerRow.appendChild(RijnummerTextCell);
                                
                                //Stoelnummers toevoegen aan de stoelnummer rij
                                for (i = 1; i <= Stoelen; i++) {
                                    var StoelNummerCell = document.createElement("th");
                                    var StoelNummerTxt = document.createTextNode(i);
                                    
                                    StoelNummerCell.appendChild(StoelNummerTxt);
                                    StoelNummerRow.appendChild(StoelNummerCell);
                                }
                                
                                 tbl.appendChild(StoelNummerRow);
                                
                                //Lus door de rijen heen en voeg deze toe aan de tabel + rijnummer
                                for (var j = 1; j <= Rijen; j++) {
                                    var row = document.createElement("tr");
                                     var RijNummerCell = document.createElement("td");
                                     RijNummerCell.setAttribute("class", "RijNummerCell");
                                     var RijNummerTxt = document.createTextNode(j);
                                    
                                    RijNummerCell.appendChild(RijNummerTxt);
                                    row.appendChild(RijNummerCell);
                                    
                                    //lus door de stoelen heen en voeg deze toe aan de rij.
                                    for (var i = 1; i <= Stoelen; i++) {
                                       var cell = document.createElement("td");
                                        
                                        //check of de stoel beschikbaar is op basis van de beschikbare stoelen array.  
                                        var stoelInfo = StoelInfo(i, j, BeschikareStoelen);
                                        
                                        if (stoelInfo.length > 0) 
                                        {
                                            
                                            cell.setAttribute("id", stoelInfo[0]['StoelID']);
                                            
                                            switch (stoelInfo[0]['StoelType']) {
                                                case 'Normaal':
                                                    cell.setAttribute("class", "NormaalStoel");
                                                    break;       
                                                case 'Primium':
                                                     cell.setAttribute("class", "PrimiumStoel");
                                                    break
                                                case 'VIP':
                                                     cell.setAttribute("class", "VIPStoel");
                                                    break;
                                            }
                                            $(cell).click(
                                            {stoelId: stoelInfo[0]['StoelID'], 
                                             stoelType: stoelInfo[0]['StoelType'], 
                                             stoelPrijs: stoelInfo[0]['StoelPrijs'], 
                                             stoelRij: stoelInfo[0]['RijNummer'],
                                             stoelNummer: stoelInfo[0]['StoelNummer']
                                            }, StoelGeselecteerd);
                                        }
                                        else
                                        {
                                            cell.setAttribute("id", "NA");
                                            cell.setAttribute("class", "onbeschikbaar")
                                             
                                        }
                                     row.appendChild(cell);
                                 }
                                tblB.appendChild(row);
                                }
                           tbl.appendChild(tblB);
                           StoelenDiv.appendChild(tbl);
                        }
                        
                        function StoelGeselecteerd(event)
                        {
                            //alert(event.data.stoelId);
                                var stoel = document.getElementById(event.data.stoelId);
                                
                                if (stoel.getAttribute("style") == "background-color:green;") {
                                            
                                    geselecteerdeStoelen.splice(geselecteerdeStoelen.indexOf(event.data.stoelId), 1);
                                            VerwijderenOverzichtTabelRij(event.data.stoelId);
                                            WerkTotaalPrijsBij(parseFloat(event.data.stoelPrijs) * -1);
                                            WerkStoelenInFormBij();
                                            
                                            stoel.setAttribute("style", "");
                                }
                                else
                                    {
                                        geselecteerdeStoelen.push(event.data.stoelId);
                                        ToevoegenOverzichtTabelRij(event.data.stoelRij, event.data.stoelNummer, event.data.stoelType, event.data.stoelPrijs, event.data.stoelId);
                                        WerkTotaalPrijsBij(parseFloat(event.data.stoelPrijs));
                                        WerkStoelenInFormBij();
                                        stoel.setAttribute("style", "background-color:green;");
                                    }
                                
                                    
                        }
                        
                        function ToevoegenOverzichtTabelRij(Rij, Nummer, Type, Prijs, Id)
                        {
                            var Tb = document.getElementById('Stap1GeselecteerdeStoelenTB');
                            var dataRow = document.createElement('tr');
                            
                            var RijCell = document.createElement('td');
                            var RijText = document.createTextNode(Rij);
                            RijCell.appendChild(RijText);
                            var NummerCell = document.createElement('td');
                            var NummerText = document.createTextNode(Nummer);
                            NummerCell.appendChild(NummerText);
                            var TypeCell = document.createElement('td');
                            var TypeText = document.createTextNode(Type);
                            TypeCell.appendChild(TypeText);
                            var PrijsCell = document.createElement('td');
                            var PrijsText = document.createTextNode(Prijs.replace('.', ','));
                            PrijsCell.appendChild(PrijsText);
                            
                            
                            dataRow.appendChild(RijCell);
                            dataRow.appendChild(NummerCell);
                            dataRow.appendChild(TypeCell);
                            dataRow.appendChild(PrijsCell);
   
                            dataRow.setAttribute('id', 'dataRow-' + Id);
                            
                            Tb.appendChild(dataRow);
                            
                            
                        }
                        
                        function WerkTotaalPrijsBij(Prijs)
                        {
                            totaalPrijs = totaalPrijs + Prijs;
                            document.getElementById('totaalPrijs').innerHTML = "&euro; " + totaalPrijs.toFixed(2);
                            var ht = document.getElementById('HelpText1');
                            if (geselecteerdeStoelen.length > 0) {
                                
                                ht.setAttribute("style", "display:none;")
                                }
                            else
                                {
                                ht.setAttribute("style", "");
                                }

                        }
                        
                        function VerwijderenOverzichtTabelRij(Id)
                        {
                        	var row = document.getElementById('dataRow-' + Id);
                                row.parentNode.removeChild(row); 
 
                        }
                        
                        function StoelInfo(Stoel,Rij, beschikbarestoelen)
                        {
                              var StoelenInRij = $.grep(beschikbarestoelen, function(value, i) {
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