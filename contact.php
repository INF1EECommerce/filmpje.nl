<?php
include_once 'backend/DBFunctions.php';
$dbfunctions = new DBFunctions();
$specials = $dbfunctions->HaalSpecialsOp();
?>
<!DOCTYPE html>
<html>
<head>
<title>Filmpje.nl - Contact</title>
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
		<div id="mainContent">
		<div id="moviebanner">
<img src="image/banner_avengers.png">
</div>
		<!-- kiezen tussen contactgegevens/openingstijden/bereikbaarheid/tarieven via php -->
		<div id="infoDiv">
		
		<h2>Contact opnemen</h2>
	
		
		<section id="contactDiv">
		<article>
		Filmpje streeft ernaar u van de beste service te voorzien. 
		Indien u vragen of suggesties heeft raden wij u aan om die 
		telefonisch of via het contactformulier aan ons door te geven.
		<br> 
		<br>
		Wij zullen uw vraag of suggestie binnen 5 werkdagen beantwoorden.
		Voor een lijst met veelgestelde vragen verwijzen wij u door naar de 
		<a href="#">FAQ pagina</a>.
		<br>
		<br>
		Vult u de gegevens alstublieft via onderstaand schema in, dan nemen
		wij zo spoedig mogelijk contact met u op.
		
		<form>
		<p>
		VOORNAAM
		<br>
		<input type="text" name="voornaam"></input>
		</p>
		<p>
		ACHTERNAAM
		<br>
		<input type="text" name="achternaam"></input>
		</p>
		<p>
		E-MAIL 
		<br>
		<input type="text" name="email"></input>
		</p>
		<p>
		VRAAG OF SUGGESTIE 
		<br>
		<textarea id="comment"></textarea>
		</p>
		<button>Versturen</button>
		</form>
		</article>
		</section>
		<p style="clear: both; padding-bottom: 25px;"></p>
		</div>
		
		
		</div> <!-- mainContent -->
		



		
		<div id="sideContent">
		<form>
		<h2>SNELLE TICKETVERKOOP</h2>

<p>
<label for="film">film</label>	
<select id="film1">
<option id="film">planet of the apes</option>
<option id="film">planet of the apes</option>
<option id="film">planet of the apes</option>
</p>
</select>

<p>
<label for="dag">dag</label>
<select id="dag1">	
<option id="dag">vandaag</option>
<option id="dag">morgen</option>
<option id="dag">overmorgen</option>
</p>
</select>

<p>
<label for="tijd">tijd</label>	
<select id="tijd1">
<option id="tijd">19:00</option>
<option id="tijd">19:30</option>
<option id="tijd">20:00</option>
</p>
</select>
<p>

<button id="reserveer">Reserveer</button>
<button id="koop">Koop</button>
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