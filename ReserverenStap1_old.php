<!doctype html>

<html lang="nl">

    <head>
        <meta charset="utf-8" />
        <title>Filmpje</title>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/reserveren.css">
        <link rel="stylesheet" href="css/stoelselectie.css">
        <meta name="description" content="Filmpje, Bioscoop">
        <meta name="keywords" content="">
        <script src="javascript/jquery.js" type="text/javascript"></script>
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Modrnizr.com -->

    </head>

    <body onload="HaalBeschikbareStoelenOp()">
        <div id="wrapper">

            <img src="image/Logo.png" />


            <section class="content">
                <nav>
                    <ul id="menu">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#">Films</a>
                            <ul class="submenu">
                                <li><a href="#">Films binnekort</a></li>
                                <li><a href="#">Films vandaag</a></li>
                                <li><a href="#">Alle films</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Informatie</a>
                            <ul class="submenu">
                                <li><a href="#">Routebeschrijving</a></li>
                                <li><a href="#">Events</a></li>
                                <li><a href="#">Hoe kom ik er?</a></li>
                                <li><a href="#">Prijzen</a></li>
                            </ul>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </nav>
            </section>
            <br>
            <br>
            <hr>
            <div id="ReserverenMainContent">
                <div id="CoverAndMovieInfo">
                    <img src="image/cover.jpg" id="coverImage" alt="Cover">
                    <br>
                    <br>
                    <p>
                        <span class="filmtitel">The planet of the apes</span><br>
                        <span style="margin-left: 10px;">☆</span><span>☆</span><span>☆</span><span>☆</span><br>
                        <span class="filmtijd">16-2-2012 - 13:00 UUR</span><br>
                        <span class="filmbeschrijving">Een geweldige film met apen.</span><br>
                    </p>
                </div>
                <div id="StoelSelectie">


                    <h2>Stoelselectie</h2>
                    <p>
                    <div id="Stoelen">
                        <h2>Scherm</h2>
                        <hr>
                    </div>
                    <div id="GeselecteerdeStoelen">
                        <form method="post" action="ReserverenStap2.php" name="GeselecteerdeStoelenForm">
                            <input type="hidden" id="gs" name="GeselecteerdeStoelen" value="">
                            <input type="submit" value="Volgene Stap">
                        </form>
                    </div>
<!--                    <div>
                        <ul id="Legenda">
                            <li class="NormaalStoel">Beschikbaar (Normaal)</li>
                            <li class="PrimiumStoel" >Beschikbaar (Primium)</li>
                            <li class="VIPStoel">Beschikbaar (VIP)</li>
                            <li class="onbeschikbaar">Gereserveerd</li>
                            <li class="geselecteerd">Geselecteerd</li>
                        </ul>
                    </div>-->
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
                </div>
                <footer>
                    <hr />
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="films.html">Films</a></li>
                        <li><a href="informatie.html">Informatie</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </footer>
            </div>
        </div>
    </body>

</html>
