<?php
include_once 'Helpers/ExceptionHelper.php';
set_exception_handler('ExceptionHelper::exception_handler');
include_once 'Views/FilmPoosterEnInfoView.php';
include_once 'Views/SpecialsMenuItemsView.php';
include_once 'backend/Bestellingen.php';
include_once 'backend/Reserveringen.php';
include_once 'icepay/icepay.php';
include_once 'backend/validatie/ReserverenPostValidatie.php';

$validatie =  new ReserverenPostValidatie();
$postWaardes = $validatie->ValideerStap3($_POST);

switch ($postWaardes['Modus'])
{
    case "bestellen":
        $filmpjeIdeal = new FilmpjeIdeal();
        $iframeUrl = $filmpjeIdeal->GenereerOrderEnGeefUrl($postWaardes['Bestelling']);
        $bestellingen = new Bestellingen();
        $bestellingen->MaakBestellingAan($postWaardes['Bestelling']);
        $stapnaam = "Ideal";
        break;
    case "reserveren":
        $reserveringen = new Reserveringen();
        $reserveringen->MaakReserveringAan($postWaardes['Reservering']);
        $iframeUrl = "bedankt.php?voorstelling=".$postWaardes['Voorstelling']."&referentie=".$postWaardes['Referentie']."&modus=".$postWaardes['Modus'];
        $stapnaam = "Reservering afgerond";
        break;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Filmje - <?php echo $postWaardes['Modus']; ?> - Stap 3</title>
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
                        <?php
                        $specialsMenuitems =  new SpecialsMenuItemsView();  $specialsMenuitems->Render(); ?>
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
            <?php $filmPoosterEnInfoView = new FilmPoosterEnInfoView();
            $filmPoosterEnInfoView->Render($postWaardes['Voorstelling']); ?>
            </div>
            </td><td>
            <div id="mainContent">
                <div id="ss">
                    <p class="blockheader"><?php echo strtoupper($postWaardes['Modus']) ?> STAP3 - <?php echo $stapnaam ?></p>
                        <iframe class="icepayframe" src="<?php echo $iframeUrl; ?>">
                        </iframe>
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
    </body>
</html>