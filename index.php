<html>
<head>
<title></title>
<link rel="stylesheet" href="css/stylesheet.css">
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

<table id="timeTable">
<tr id="dateRow">
	<th id="dateTh">
		<button class="currentDate">Vandaag</button>
		<button>Morgen</button>
		<button>Overmorgen</button>
	</th>
	<td id="fillerTd"></td>
</tr>
<tr>
	<th>
		Ted
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr>
<tr>
	<th>
		The Expendables 2
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr>
<tr>
	<th>
		Savages
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr><tr>
<tr>
	<th>
		Hope Springs
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr>
<tr>
	<th>
		The Watch
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr>
<tr>
	<th>
		The Possesion
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr>
<tr>
	<th>
		Brave (NL)
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr>
<tr>
	<th>
		The Bourne Legacy
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr>
<tr>
	<th>
		The Dark Knight Rises
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr>
<tr>
	<th>
		Intouchables
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr>
<tr>
	<th>
		De Verbouwing
	</th>
	<td class="timeClass"><button>18:30</button>
	<button>19:00</button>
	<button>21:30</button></td>

</tr>
</table>
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