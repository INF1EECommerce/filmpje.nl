<?php 
require_once('Views/VandaagMorgenOvermorgenView.php'); 
include_once 'backend/DBFunctions.php';
$dbfunctions = new DBFunctions();
$specials = $dbfunctions->HaalSpecialsOp();
?>
<!DOCTYPE html>
<html>
<head>
<title>Filmpje - Uw biosccop in Rotterdam</title>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="css/stylesheet.css">
<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/jquery-ui.js" type="text/javascript"></script>
<script src="javascript/Zoeken.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Pulled from http://code.google.com/p/html5shiv/ -->
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
    <header>   
            <div Id="Zoekbox">
                <form action="filmoverzicht.php" method="GET"><input id="qtext" type="text" name="qtext"><input class="submitb" type="submit" value="Zoek"></form>
            </div>
            <div Id="ZoekPopup" style="display: none;">
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="filmoverzicht.php">Films</a></li>
                <li><a href="#">Info</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li id="lastLi">Specials
                    <ul>
                        <?php
                        foreach ($specials as $special) {
                            echo ("<li><a href=\"specials.php?SpecialID=" . $special['SpecialID'] . "\">" . $special['Naam'] . "</a></li>");
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </nav>
	
	<div id="outerDiv">
			<div id="sideContent">
			<form action="ReserverenStap1.php" method="POST">
		<h2>SNELLE TICKETVERKOOP</h2>
<p>
<label for="film">film</label>	
<select id="film1">
<option id="film">The Avengers</option>
</p>
</select>

<p>
<label for="dag">dag</label>
<select id="dag1">	
<option id="dag">vandaag</option>
</p>
</select>

<p>
<label for="tijd">tijd</label>	
<select id="tijd1">
<option id="tijd">15:00</option>
</p>
</select>
<p>
<input type="hidden" name="voorstelling" value="1">
<!--<input type="submit" id="reserveer">Reserveer</button>-->
<input type="submit" id="koop" value="Koop">
</p>
<p style="clear: both;"></p>
</form>

<div id="top10">

<ul id="top10">
	<li id="top10header"><p>Top 10 films</p></li>
	<li id="firstLi"><button>1</button>Ted</li>
	<li><button>2</button>The Possession</li>
	<li><button>3</button>The Bourne Legacy</li>
	<li><button>4</button>De Verbouwing</li>
	<li><button>5</button>Bait</li>
	<li><button>6</button>The Expendables 2</li>
	<li><button>7</button>The Dark Knight Rises</li>
	<li><button>8</button>The Watch</li>
	<li><button>9</button>Intouchables</li>
	<li><button>10</button>Detachment</li>
	<button id="reviews">Top 10 Filmreviews</button>
</ul>

</div>

</div>
		<div id="mainContent">
		<div id="moviebanner">
<img src="image/banner_avengers.png">
</div>
<div id="infoDiv">
		
		<h2>Bereikbaarheid</h2>
		<iframe width="600" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.nl/maps?f=q&amp;source=s_q&amp;hl=nl&amp;geocode=&amp;q=west-kruiskade+26&amp;aq=&amp;sll=51.920714,4.471092&amp;sspn=0.005036,0.013068&amp;ie=UTF8&amp;hq=&amp;hnear=Kruiskade+26,+Centrum,+Rotterdam,+Zuid-Holland&amp;t=m&amp;ll=51.928231,4.476414&amp;spn=0.018525,0.036478&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
		
		<div id="routeDiv">
		<p id="adres">Bioscoop Filmpje<br>
		West-Kruiskade 26<br>
		3014 AS, Rotterdam<br>
		</p>
		<p id="routebeschrijving">
		Voor een routebeschrijving met de fiets, auto, metro/tram/bus of trein klikt u 'routebeschrijving' op de kaart hierboven of op deze link <a href="https://maps.google.nl/maps?f=d&source=s_q&hl=nl&geocode=%3BCfDfrMJrgEV1FfNGGAMdBk5EACkpWWFtpzTERzEePxABrpav-g&q=west-kruiskade+26&aq=&sll=51.920714,4.471092&sspn=0.005036,0.013068&ie=UTF8&hq=&hnear=Kruiskade+26,+Centrum,+Rotterdam,+Zuid-Holland&t=m&z=14&vpsrc=0&iwloc=A&daddr=Kruiskade+26,+3012+Rotterdam">Routebeschrijving</a>
		</p>
		</div>
		
		
		
		
	
		
		
<div id="table1">
<table id="routeTable1">
	<tr>
		<th colspan="3">Openbaar vervoer</th>
	</tr>
	<tr>
		<th></th>
		<th>Lijn</th>
		<th>Halte</th>
	</tr>
	<tr>
		<td class="td1">Bus</td>
		<td class="td2">42</td>
		<td class="td3">Kruiskade</td>
	</tr>
		<tr>
		<td class="td1">Metro</td>
		<td class="td2">21</td>
		<td class="td3">Beurs</td>
	</tr>
		<tr>
		<td class="td1">Nachtbus</td>
		<td class="td2">342</td>
		<td class="td3">Kruiskade</td>
	</tr>
		<tr>
		<td class="td1">Trein</td>
		<td class="td2"></td>
		<td class="td3">Richting Rotterdam Centraal</td>
	</tr>
</table>
<p style="clear: both; padding-bottom: 0px;"></p>
</div>
<br>
<div id ="table2">
<table id="routeTable2">
	<tr>
		<th colspan="3">Auto</th>
	</tr>
	<tr>
		<td class="td1">Parkeren</td>
		<td class="td2" colspan="2">P1 Filmpje</td>
	</tr>
		<tr>
		<td class="td1">Adres</td>
		<td class="td2">West-Kruiskade 22, 3014BL, Rotterdam</td>
	</tr>
		<tr>
		<td class="td1">Tarief</td>
		<td class="td2">Met parkeerkaart van Bioscoop Filmpje (verkrijgbaar aan de ticketverkoop) 6,- euro voor 4 uur.</td>
		
	</tr>
</table>
<p style="clear: both;"></p>
</div>		
<p style="clear: both; padding-bottom: 25px;"></p>

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
    <div Id="TijdKlikPopup">
        <div class="popupButtonClass">
            <div id="TijdKlikPopUpHeader" style="display: block; width: 100%">
                
            </div>
            <button id="popupbb">Bestellen</button><button id="popuprb">Reserveren</button>
        </div>
    </div>
</body>
</html>