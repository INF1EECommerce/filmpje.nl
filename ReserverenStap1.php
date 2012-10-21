<?php
include_once 'Views/FilmPoosterEnInfoView.php';
include_once 'Views/FacebookEventView.php';
include_once 'backend/DBFunctions.php';
$dbfunctions = new DBFunctions();
$specials = $dbfunctions->HaalSpecialsOp();
$voorstelling = intval($_POST['voorstelling']);
if ($voorstelling == 0 || !isset($_POST['modus'])) {
    header('Location: index.php');
}
$modus = $_POST['modus'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Filmje - <?php echo $modus; ?> - Stap 1</title>
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="css/stylesheet.css">
        <link rel="stylesheet" href="css/stoelselectie.css">
        <link rel="stylesheet" href="css/loading.css">
        <script src="javascript/jquery.js" type="text/javascript"></script>
        <script src="javascript/jquery-ui.js" type="text/javascript"></script>
        <script src="javascript/StoelSelectie.js" type="text/javascript"></script>
        <script src="javascript/popup.js" type="text/javascript"></script>
        <script src="javascript/Zoeken.js" type="text/javascript"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!-- Pulled from http://code.google.com/p/html5shiv/ -->
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php
        echo ("
<script>    
var Voorstelling = " . $voorstelling . ";
</script>");
        ?>
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
                    <p class="blockheader"><?php echo strtoupper($modus) ?> STAP1 - Stoelselectie</p>
                    <div id="StoelSelectieHeader">
                        Filmpje hanteert prijzen gebaseerd op de stoelen die u voor de voorstelling selecteert. <br> Zou u zo vriendelijk willen zijn hieronder uw zitplaats(en) te kiezen? <br>
                        Onder het stoeloverzicht vindt u een legenda en een overzicht van uw selectie.
                    </div>
                    <div id="Stoelen">
                        <div id="loader">
                        <div id="floatingCirclesG">
                        <div class="f_circleG" id="frotateG_01">
                        </div>
                        <div class="f_circleG" id="frotateG_02">
                        </div>
                        <div class="f_circleG" id="frotateG_03">
                        </div>
                        <div class="f_circleG" id="frotateG_04">
                        </div>
                        <div class="f_circleG" id="frotateG_05">
                        </div>
                        <div class="f_circleG" id="frotateG_06">
                        </div>
                        <div class="f_circleG" id="frotateG_07">
                        </div>
                        <div class="f_circleG" id="frotateG_08">
                        </div>
                        </div>
                            <p>Loading<p>
                        </div>
                        
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
                                <tr><td>Totaal</td><td>&nbsp;</td><td>&nbsp;</td><td id="totaalPrijs">&euro; 0,00</td></tr>
                            </tfoot>
                        </table>
                        <form method="post" action="ReserverenStap2.php" name="GeselecteerdeStoelenForm">
                            <input type="hidden" id="gs" name="GeselecteerdeStoelen" value="">
                            <input type="hidden" id="voortsellingid" name="voorstellingid" value="<?php echo $voorstelling; ?>">
                            <input type="hidden" id="modusip" name="modus" value="<?php echo $modus ?>">
                            <input type="submit" disabled="disabled" class="buttonLight" name="submitB" id="submitB" value="Volgene Stap">
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
