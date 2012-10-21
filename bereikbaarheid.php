<?php 
require_once('Views/VandaagMorgenOvermorgenView.php'); 
include_once 'backend/DBFunctions.php';
include_once 'Views/Top10View.php';
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
            <div Id="ZoekPopup" style="display: none;">
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="filmoverzicht.php">Films</a></li>
                                <li><a href="#">Info</a>                     <ul>                         <li><a href="bereikbaarheid.php">Bereikbaarheid</a></li>                         <li><a href="openingstijden.php">Openingstijden</a></li>                     </ul>                 </li>
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
                               <li>
                    <form style="width: 250px;" action="zoeken.php" method="GET"><input id="qtext" type="text" name="qtext" autocomplete="off"><input class="ZoekSubmitButton" type="submit" value="Zoek"></form>
                </li>
 
            </ul>
        </nav>
	
	<div id="outerDiv">
			<div id="sideContent">
  <form action="ReserverenStap1.php" method="POST">
                    <h2 class="blockheader">SNELLE TICKETVERKOOP</h2>
                    <p>
                        <label>film</label>	
                        <select id="film1">
                            <option id="film">The Avengers</option>
                    </select>

                    <p>
                        <label>dag</label>
                        <select id="dag1">	
                            <option id="dag">vandaag</option>
                    </select>

                    <p>
                        <label>tijd</label>	
                        <select id="tijd1">
                            <option id="tijd">15:00</option>
                    </select>
                    <p>
                        <button id="reserveer">Reserveer</button>
                        <button id="koop">Koop</button>
                    <p style="clear: both;">
                </form>


<div id="top10">

<ul id="top10">
<?php $top10view = new Top10View(); $top10view->Render(); ?>
</ul>

</div>

</div>
		<div id="mainContent">
		<div id="pagebanner">
<img src="image/banner_avengers.png">
</div>
<div id="infoDiv">
		
		<h2>Bereikbaarheid</h2>
		<iframe width="645" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.nl/maps?f=q&amp;source=s_q&amp;hl=nl&amp;geocode=&amp;q=west-kruiskade+26&amp;aq=&amp;sll=51.920714,4.471092&amp;sspn=0.005036,0.013068&amp;ie=UTF8&amp;hq=&amp;hnear=Kruiskade+26,+Centrum,+Rotterdam,+Zuid-Holland&amp;t=m&amp;ll=51.928231,4.476414&amp;spn=0.018525,0.036478&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
		
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
	<thead>
		<th class="subblockheader" colspan="3">Openbaar vervoer</th>
	</thead>
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
	<thead>
		<th class="subblockheader" colspan="3">Auto</th>
	</thead>
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
</body>
</html>