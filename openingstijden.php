<html>
<head>
<title></title>
<link rel="stylesheet" href="css/stylesheet.css">
</head>
<body>
	<header>
		<img src="image/logo.png">
	</header>
	<nav>
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">Films</a></li>
			<li><a href="#">Info</a></li>
			<li><a href="#">Contact</a></li>
			<li id="lastLi"><a href="#">Specials</a></li>
		</ul>
	</nav>
	<div id="outerDiv">
		<div id="mainContent">
		<div id="moviebanner">
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