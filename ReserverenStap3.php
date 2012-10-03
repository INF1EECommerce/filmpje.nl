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
     header('Location: index.php');
}
?>
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
