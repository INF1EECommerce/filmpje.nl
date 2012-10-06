<?php
//include_once '/Views/FilmPoosterEnInfoView.php';
//include_once '/backend/Bestellingen.php';
//include_once '/backend/DTO/BestellingFactory.php';
//include_once '/icepay/icepay.php';

include_once '/var/www/filmpje.nl/Views/FilmPoosterEnInfoView.php';
include_once '/var/www/filmpje.nl/backend/Bestellingen.php';
include_once '/var/www/filmpje.nl/backend/DTO/BestellingFactory.php';
include_once '/var/www/filmpje.nl/icepay/icepay.php';

$voorstelling = intval($_POST['voorstelling']);
if ($voorstelling == 0) {
    header('Location: index.php');
}
try {
    $filmpjeIdeal = new FilmpjeIdeal();
    $filmpjeIdeal->ParseReservernPostValues($_POST);

    $icepayurl = $filmpjeIdeal->GenereerOrderEnGeefUrl();

    $bestellingFactory = new BestellingFactory();
    $bestelling = $bestellingFactory->BuildBestellingWithNewStatus($_POST);
    $bellingen = new Bestellingen();
    $bellingen->MaakBestellingAan($bestelling);
} catch (Exception $ex) {
     $icepayurl = "icepay/betaalerror.php";
     //echo $ex->getMessage();
}
?>
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
			<li><a href="#">Films</a></li>
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
                    <p class="blockheader">STAP3 - Ideal</p>
                    <?php if (!isset($errorMessage)) { ?>

                        <iframe class="icepayframe" src="<?php echo $icepayurl; ?>">
                        </iframe>
                    <?php } else {
                        echo $errorMessage;
                    } ?>
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
