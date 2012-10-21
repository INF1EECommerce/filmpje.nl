<?php 
include_once 'backend/DBFunctions.php';
$dbFunctions =  new DBFunctions();
$specials = $dbFunctions->HaalSpecialsOp();
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
		<div id="mainContent">
		<div id="pagebanner">
<img src="image/banner_avengers.png">
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
		
		
		</div> <!-- mainContent -->
		



		
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
		</div> <!-- sideContent -->
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