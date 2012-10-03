<?php 
require_once('/var/www/filmpje.nl/Views/VandaagMorgenOvermorgenFilmsViewControler.php'); 
//require_once('/Views/VandaagMorgenOvermorgenFilmsViewControler.php'); 
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="css/stylesheet.css">
<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/FilmTabs.js" type="text/javascript"></script>
</head>
<body>
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


<div id="schedule">
<p>Nu bij Filmpje</p>
<table class="timeHeaderTable">
<tr class="dateRow">
	<th id="dateTh">
		<button id="vandaagButton" class="currentDate" onClick="DagButtonClick('Vandaag')">Vandaag</button>
		<button id="morgenButton" onClick="DagButtonClick('Morgen')">Morgen</button>
		<button id="overmorgenButton" onClick="DagButtonClick('Overmorgen')">Overmorgen</button>
	</th>
        <tr>
	<td id="fillerTd"></td>
        </tr>
</tr>
</table>

<?php $vandaagMorgenOvermorgenFilmsViewControler = new VandaagMorgenOvermorgenFilmsViewControler();
      $vandaagMorgenOvermorgenFilmsViewControler ->Render();
?>

<form method="post" id="voorstellingForm" action="ReserverenStap1.php">
    <input type="hidden" id="voorstelling" name="voorstelling" value="">
</form>
</div>	
<div id="specialsDiv">
<div id="mainSpecialsDiv">
<h2>Ladies Night</h2>
<h3>Alle vrouwen verzamelen</h3>
<p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
</div>
<div id="specialSideContent">
<img src="image/ladiesnight.jpg">
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