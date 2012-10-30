<?php 
include_once 'Views/SpecialsMenuItemsView.php';
include_once 'Views/Top10View.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Filmpje - Openingstijden</title>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="css/stylesheet.css">
<script src="javascript/jquery.js" type="text/javascript"></script>
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
                    <?php $specialsMenuitems = new SpecialsMenuItemsView(); $specialsMenuitems->Render(); ?>
                </li>
                               <li>
                    <form style="width: 250px;" action="zoeken.php" method="GET"><input id="qtext" type="text" name="qtext" autocomplete="off"><input class="ZoekSubmitButton" type="submit" value="Zoek"></form>
                </li>
 
            </ul>
        </nav>
	<div id="outerDiv">
                    <table>  
            <tr>
            <td>
	
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
<?php $top10view = new Top10View(); $top10view->Render(); ?>
</div>
		</div> 	
            </td><td>
                <div id="mainContent">
		<div id="pagebanner">
<img src="image/PageBanners/open.png">
</div>
		<!-- kiezen tussen contactgegevens/openingstijden/bereikbaarheid/tarieven via php -->
		<div id="infoDiv">
		
		<h2>Openingstijden</h2>
		<table id="openingstijden">
		<tr class="tijdenTr">
			<th class="tijdenTh">Maandag t/m vrijdag</th>
			<td class="tijdenTd">12:00 tot 01:00 uur</td>
		</tr>
		<tr class="tijdenTr"> 
			<th class="tijdenTh">Zaterdag en zondag</th>
			<td class="tijdenTd">10:00 tot 02:00 uur</td>
		</tr>
		<tr class="tijdenTr">
			<th class="tijdenTh">Vakanties</th>
			<td class="tijdenTd">Onder voorbehoud</td>
		</tr>
		</table>
		
		<p style="clear: both; padding-bottom: 25px;"></p>
		</div>
		
		
		</div> </td></tr></table>
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