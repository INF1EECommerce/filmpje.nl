<?php 
if (!isset($_GET['filmid']))
{
   header("Location: index.php");
}
$filmid = intval($_GET['filmid']);        
include_once 'Views/FilmPoosterEnInfoView.php';
include_once 'backend/DBFunctions.php';
include_once 'Views/FilmTijdenView.php';
$dbfunctions = new DBFunctions();
try { $film = $dbfunctions ->FilmInfo($filmid); } catch(Exception $ex) { if ($ex->getMessage() == "Film niet gevonden.") {
header("HTTP/1.0 404 Not Found");
exit;
}}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Filmpje.nl - <?php echo $film['Naam'] ?></title>

<link rel="stylesheet" href="css/stylesheet.css">
<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/FilmTabs.js" type="text/javascript"></script>
</head>

<body>
<header>
    <img title="filmpje.nl" src="image/header2.png">
	</header>
	<nav>
		<ul>
			<li title="Home"><a href="index.php">Home</a></li>
			<li title="Films"><a href="filmoverzizcht.php">Films</a></li>
			<li title="Info"><a href="#">Info</a></li>
			<li title="Contact"><a href="#">Contact</a></li>
			<li title="Specials"id="lastLi"><a href="#">Specials</a></li>
		</ul>
	</nav>
	<div id="outerDiv">
        <div id="sideContent">
          <?php $filmPoosterEnInfoView = new FilmPoosterEnInfoView(); $filmPoosterEnInfoView->RenderVoorFilm($film); ?>
            
            <div id="top10">

                    <ul>
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
                    </ul>
			</div>
        </div>
        <div id="mainContent">
                 
                <div id="trailer">
               <p class="blockheader">Trailer</p>
                    <video controls  width="620" height="360">
                        <source src="trailers/<?php echo $film['Trailer'] ?>.mp4"type="video/mp4" />
                        <source src="trailers/<?php echo $film['Trailer'] ?>.webmvp8.webm" type="video/webm" />
                        <source src="trailers/<?php echo $film['Trailer'] ?>.ogv"  type="video/ogg" />
                    </video>
			</div>
             
            <div id="filmomschrijvingHeader">
            <p class="blockheader">Filmomschrijving</p>            
            <p class="filmbeschrijving"><?php print $film['Beschrijving']; ?></p><p class="filmbeschrijving"><strong>Hoofdrolspelers: </strong><?php echo $film['Acteurs']; ?></p>
            </div>
                <div id ="filmtijden">
                <p class="blockheader" style="margin-bottom: 0px;">Tijden</p>    
                <?php $filmtijdenview = new FilmTijdenView(); $filmtijdenview->Render($filmid); ?>    
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
    <form method="post" id="voorstellingForm" action="ReserverenStap1.php">
    <input type="hidden" id="modus" name="modus" value="">
    <input type="hidden" id="voorstelling" name="voorstelling" value="">
</form>
</body>
</html>
