<?php 
if (!isset($_GET['filmid']))
{
   header("Location: index.php");
   die;
}
$filmid = intval($_GET['filmid']);        
include_once 'Views/FilmPoosterEnInfoView.php';
include_once 'backend/DBFunctions.php';
include_once 'Views/FilmTijdenView.php';
include_once 'Views/Top10View.php';
$dbfunctions = new DBFunctions();
$specials = $dbfunctions->HaalSpecialsOp();
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
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="css/stylesheet.css">
<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/FilmTabs.js" type="text/javascript"></script>
<script src="javascript/jquery-ui.js" type="text/javascript"></script>
<script src="javascript/Zoeken.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Pulled from http://code.google.com/p/html5shiv/ -->
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<style>#Zoekbox { margin-left: -300px; }</style>
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
                    <table>  
            <tr>
            <td>
        <div id="sideContent">
          <?php $filmPoosterEnInfoView = new FilmPoosterEnInfoView(); $filmPoosterEnInfoView->RenderVoorFilm($film); ?>
            
            <div id="top10">

                          <?php $top10view = new Top10View(); $top10view->Render(); ?>
            </div>
        </div>
            </td><td>
        <div id="mainContent">
                 
                <div id="trailer">
               <p class="blockheader">Trailer</p>
                    <video controls  width="620" height="360">
                        <source src="trailers/<?php echo $film['Trailer'] ?>.mp4"type="video/mp4" />
                        <source src="trailers/<?php echo $film['Trailer'] ?>.webmvp8.webm" type="video/webm" />
                        <source src="trailers/<?php echo $film['Trailer'] ?>.theora.ogv"  type="video/ogg" />
                        <object type="application/x-shockwave-flash" data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" height="360" width="620">
                        <param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />
                        <param name="allowFullScreen" value="true" />
                        <param name="wmode" value="transparent" />
                        <param name="flashVars" value="config={'playlist':['http%3A%2F%2Fchivan.com%2Ffilmpje.nl%2Fimage%2FtrailerLogo.png',{'url':'http%3A%2F%2Fchivan.com%2Ffilmpje.nl%2Ftrailers%2F<?php echo $film['Trailer'] ?>.mp4','autoPlay':false}]}" />
                    </object>
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
            </td></tr></table>
		
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
