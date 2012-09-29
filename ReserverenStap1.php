<html>
<head>
<title></title>
<link rel="stylesheet" href="css/stylesheet.css">
<link rel="stylesheet" href="css/stoelselectie.css">
<script src="javascript/jquery.js" type="text/javascript"></script>
<script>
                           var geselecteerdeStoelen = new Array();
                            var Voorstelling = 1;
                            
                            
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
                                
                                                $.getJSON('backend/beschikbarestoelen.php', { voorstelling : 1 }, function(data)
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
                                var StoelNummerRow = document.createElement("tr");
                                
                                //Lege cel links boven
                                StoelNummerRow.appendChild(document.createElement("td"));
                                
                                //Stoelnummers toevoegen aan de stoelnummer rij
                                for (i = 1; i <= Stoelen; i++) {
                                    var StoelNummerCell = document.createElement("td");
                                    var StoelNummerTxt = document.createTextNode(i);
                                    
                                    StoelNummerCell.appendChild(StoelNummerTxt);
                                    StoelNummerRow.appendChild(StoelNummerCell);
                                }
                                
                                 tblB.appendChild(StoelNummerRow);
                                
                                //Lus door de rijen heen en voeg deze toe aan de tabel + rijnummer
                                for (var j = 1; j <= Rijen; j++) {
                                    var row = document.createElement("tr");
                                     var RijNummerCell = document.createElement("td");
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
                                            $(cell).click({stoelId: stoelInfo[0]['StoelID'], stoelType: stoelInfo[0]['StoelType'] }, StoelGeselecteerd);
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
                                if (stoel.getAttribute("class") == "geselecteerd") {
                                            
                                    geselecteerdeStoelen.splice(geselecteerdeStoelen.indexOf(event.data.stoelId), 1);
                                            WerkStoelenInFormBij();
                                            switch (event.data.stoelType) {
                                                case 'Normaal':
                                                    stoel.setAttribute("class", "NormaalStoel");
                                                    break;       
                                                case 'Primium':
                                                     stoel.setAttribute("class", "PrimiumStoel");
                                                    break
                                                case 'VIP':
                                                     stoel.setAttribute("class", "VIPStoel");
                                                    break;
                                }
                                }
                                else
                                    {
                                        geselecteerdeStoelen.push(event.data.stoelId);
                                        WerkStoelenInFormBij();
                                        stoel.setAttribute("class", "geselecteerd");
                                    }
                                
                                    
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
</script>
</head>
<body onload="HaalBeschikbareStoelenOp()">
	<div id="header">
		<div id="banner">
			<ul>
				<li><a href="#">Home</a></li>
				<li><a href="#">Films</a></li>
				<li><a href="#">Agenda</a></li>
				<li><a href="#">Contact</a></li>
				<li><a href="#">Specials</a></li>
			</ul>
		
		</div>
	</div>
	
	<div id="outerDiv">
        <div id="sideContent">
            <div id="filmPoosterEnInfo">
                <img src="image/apooster.jpg">
                <div id="filmInfo">
                    <h2>The Avengers</h2>
                    <div id="tijdEnZaal">15:00 uur <br>
                    Zaal 1<br></div>
                </div>
            </div>

                
                        
         </div>
        <div id="mainContent">
            <div id="ss">
            <div id="StoelSelectieHeader">
                <h1>Stoelselectie</h1>
                Selecteer a.u.b. de gewenste plaatsen.
            </div>
            <div id="Stoelen">
                
            </div>
                      <div id="GeselecteerdeStoelen">
                        <form method="post" action="ReserverenStap2.php" name="GeselecteerdeStoelenForm">
                            <input type="hidden" id="gs" name="GeselecteerdeStoelen" value="">
                            <input type="submit" value="Volgene Stap">
                        </form>
                    </div>
        </div>
        </div>
		
<footer>
<p>Contact</p>
<ul>
	<li>Klantenservice</li>
	<li>Contact opnemen</li>
	<li>Adverteren bij FIlmpje</li>
	<li>Route</li>
	<li>Terms of Service</li>
</ul>
</footer>

	




	
	

	
	</div>
	
</body>
</html>
