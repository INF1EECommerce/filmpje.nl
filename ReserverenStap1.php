<?php 
include_once 'Views/FilmPoosterEnInfoView.php'; 
include_once 'Views/FacebookEventView.php';
//include_once '/Views/FilmPoosterEnInfoView.php'; 
$voorstelling = intval($_POST['voorstelling']);
if ($voorstelling == 0) {
    header('Location: index.php');
}
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="css/stylesheet.css">
<link rel="stylesheet" href="css/stoelselectie.css">
<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/StoelSelectie.js" type="text/javascript"></script>
<script src="javascript/popup.js" type="text/javascript"></script>
<?php
echo ("
<script>    
var Voorstelling = ". $voorstelling. ";
</script>");
?>
</head>
<body onload="HaalBeschikbareStoelenOp()">
<header>
		<img src="image/header2.png">
	</header>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="#">Films</a></li>
			<li><a href="#">Info</a></li>
			<li><a href="#">Contact</a></li>
			<li id="lastLi"><a href="#">Specials</a></li>
		</ul>
	</nav>
	
	<div id="outerDiv">
        <div id="sideContent">
        <?php $filmPoosterEnInfoView = new FilmPoosterEnInfoView(); $filmPoosterEnInfoView ->Render($voorstelling); ?>
        <?php $facebookEventView =  new FacebookEventView(); $facebookEventView->Render($voorstelling); ?>
        </div>
        <div id="mainContent">
            <div id="ss">
                <p class="blockheader">STAP1 - Stoelselectie</p>
            <div id="StoelSelectieHeader">
               Filmpje hanteert prijzen gebaseerd op de stoelen die u voor de voorstelling selecteert. <br> Zou u zo vriendelijk willen zijn hieronder uw zitplaats(en) te kiezen? <br>
               Onder het stoeloverzicht vindt u een legenda en een overzicht van uw selectie.
            </div>
            <div id="Stoelen">
                
            </div>        
                <div id="StoelSelectieFooter">
                    <table id="legenda">           
                        <caption>Legenda</caption>
                        <thead>
                        
                        <th>Kleur</th><th>Type</th><th>Prijs
                        </th>
                        </thead>
                    <tbody>
                        <tr><td><image src="image/seatnormal.png"></td><td>Normaal</td><td>&euro; 10,00</td></tr>
                        <tr><td><image src="image/seatpremium.png"></td><td>Premium</td><td>&euro; 15,00</td></tr>
                        <tr><td><image src="image/seatvip.png"></td><td>VIP</td><td>&euro; 20,00</td></tr>
                        <tr><td><image src="image/seatunavailable.png"></td><td>Gereserveerd</td><td></td></tr>
                    </tbody>
                    </table>
                    
                    <table id="Stap1GeselecteerdeStoelen">
                    <caption>Geselecteerde stoelen</caption>
                        <thead id=""><th>Rij</th><th>Stoel</th><th>Type</th><th>Prijs</th></thead>
                    <tbody id="Stap1GeselecteerdeStoelenTB">
                        <tr><td colspan="4" id="HelpText1">Selecteer a.u.b minimaal 1 stoel.</td></tr>
                    </tbody>
                    <tfoot>
                        <tr><td>Totaal</td><td>&nbsp;</td><td>&nbsp;</td><td id="totaalPrijs">&euro; 0.00</td></tr>
                    </tfoot>
                    </table>
                      <form method="post" action="ReserverenStap2.php" name="GeselecteerdeStoelenForm">
                            <input type="hidden" id="gs" name="GeselecteerdeStoelen" value="">
                            <input type="hidden" id="voortsellingid" name="voorstellingid" value="<?php echo $voorstelling; ?>">
                            <input type="submit" disabled="disabled" name="submitB" id="submitB" value="Volgene Stap">
                        </form>

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
