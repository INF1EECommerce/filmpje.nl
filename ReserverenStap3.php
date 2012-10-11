<?php
//include_once '/Views/FilmPoosterEnInfoView.php';
//include_once '/backend/Bestellingen.php';
//include_once '/backend/DTO/BestellingFactory.php';
//include_once '/icepay/icepay.php';

include_once 'Views/FilmPoosterEnInfoView.php';
include_once 'backend/Bestellingen.php';
include_once 'backend/DTO/BestellingFactory.php';
include_once 'backend/Reserveringen.php';
include_once 'backend/DTO/ReserveringFactory.php';
include_once 'icepay/icepay.php';

$voorstelling = intval($_POST['voorstelling']);
if ($voorstelling == 0 || !isset($_POST['modus'])) {
    header('Location: index.php');
}
$stapnaam = "Ideal";
$modus = $_POST['modus'];
if ($modus == "bestellen") {
$stapnaam = "Ideal";    
try {
    $filmpjeIdeal = new FilmpjeIdeal();
    $filmpjeIdeal->ParseReservernPostValues($_POST);
    $iframeurl = $filmpjeIdeal->GenereerOrderEnGeefUrl($voorstelling);
    $bestellingFactory = new BestellingFactory();
    $bestelling = $bestellingFactory->BuildBestellingWithNewStatus($_POST);
    $bellingen = new Bestellingen();
    $bellingen->MaakBestellingAan($bestelling);
    } catch (Exception $ex) {
     $iframeurl = "icepay/betaalerror.php";
//     echo $ex->getMessage();
    }
} else {
     $stapnaam = "Reservering afgerond";
     $reserveringFactory = new ReserveringFactory();
     $reservering = $reserveringFactory->BuildReserveringWithNewStatus($_POST);
     $reserveringen = new Reserveringen();
     $reserveringen->MaakReserveringAan($reservering);
     $iframeurl = "icepay/bedankt.php?vs=".$voorstelling;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="css/stylesheet.css">
    </head>
    <body>
   <header>
		<img src="image/header2.png">
	</header>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="filmoverzicht.php">Films</a></li>
			<li><a href="#">Info</a></li>
			<li><a href="#">Contact</a></li>
			<li id="lastLi"><a href="#">Specials</a></li>
		</ul>
	</nav>

        <div id="outerDiv">
            <div id="sideContent">
            <?php $filmPoosterEnInfoView = new FilmPoosterEnInfoView();
            $filmPoosterEnInfoView->Render($voorstelling); ?>
            </div>
            <div id="mainContent">
                <div id="ss">
                    <p class="blockheader"><?php echo strtoupper($modus) ?> STAP3 - <?php echo $stapnaam ?></p>
                        <iframe class="icepayframe" src="<?php echo $iframeurl; ?>">
                        </iframe>
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
