<?php
include_once 'Views/FilmPoosterEnInfoView.php';
include_once 'backend/Bestellingen.php';
include_once 'backend/DTO/BestellingFactory.php';
include_once 'backend/Reserveringen.php';
include_once 'backend/DTO/ReserveringFactory.php';
include_once 'icepay/icepay.php';
include_once 'backend/DBFunctions.php';
$dbfunctions = new DBFunctions();
$specials = $dbfunctions->HaalSpecialsOp();
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
        <title>Filmje - <?php echo $modus; ?> - Stap 3</title>
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="css/stylesheet.css">
        <script src="javascript/jquery.js" type="text/javascript"></script>
        <script src="javascript/jquery-ui.js" type="text/javascript"></script>
        <script src="javascript/Zoeken.js" type="text/javascript"></script>
        <script src="javascript/popup.js" type="text/javascript"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!-- Pulled from http://code.google.com/p/html5shiv/ -->
        <!--[if lt IE 9]>
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
