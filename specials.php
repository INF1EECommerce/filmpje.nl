<?php 
include_once 'Helpers/ExceptionHelper.php';
set_exception_handler('ExceptionHelper::exception_handler');
require_once('Views/SpecialFilmTijdenView.php'); 
require_once 'backend/DBFunctions.php';
include_once 'Views/Top10View.php';
include_once 'Views/SpecialGalleryView.php';
include_once 'Views/SpecialsMenuItemsView.php';
include_once 'backend/validatie/SpecialGetValidatie.php';

$validatie =  new SpecialGetValidatie();
$getWaardes = $validatie->Valideer($_GET);

?>
<!DOCTYPE html>
<html>
<head>
<title>Filmpje - Specials - <?php echo $getWaardes['SpecialInfo']['Naam'] ?></title>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="css/stylesheet.css">
<link rel="stylesheet" href="css/mocha.css">
<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/jquery-ui.js" type="text/javascript"></script>
<script src="javascript/Zoeken.js" type="text/javascript"></script>
<script src="javascript/FilmTabs.js" type="text/javascript"></script>
<script src="javascript/mocha.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Pulled from http://code.google.com/p/html5shiv/ -->
<!--[if lt IE 8]>
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

<ul id="top10">
<?php $top10view = new Top10View(); $top10view->Render(); ?>
</ul>

</div>

</div>
            </td><td>
<div id="mainContent">
		<div id="pagebanner">
<img src="image/Specials/PageBanners/<?php echo $getWaardes['SpecialInfo']['HeaderImage']; ?>">
</div>
    <div id="specialBeschrijving">
      <p class="blockheader"><?php echo $getWaardes['SpecialInfo']['Naam'] ?></p>  
     <div class="specialBeschrijvingText">
      <?php echo $getWaardes['SpecialInfo']['Beschrijving']; ?>
     </div>
    </div>
    <div id="schedule">
<p>Voorstellingen</p>


<?php $specialFilmTijdenView = new SpecialFilmTijdenView();
      $specialFilmTijdenView ->Render($getWaardes['SpecialID']);
?>

<form method="post" id="voorstellingForm" action="ReserverenStap1.php">
    <input type="hidden" id="modus" name="modus" value="">
    <input type="hidden" id="voorstelling" name="voorstelling" value="">
</form>
</div>	
 <?php $specialGallery = new SpecialGalleryView(); $specialGallery->Render($getWaardes['SpecialID']); ?>
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
</body>
</html>