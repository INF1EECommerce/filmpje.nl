<?php
require_once('Views/VandaagMorgenOvermorgenView.php');
require_once 'backend/DBFunctions.php';
require_once 'Views/CarouselView.php';
require_once 'Views/SpecialAccordionView.php';
require_once 'Views/Top10View.php';
$dbFunctions = new DBFunctions();
$specials = $dbFunctions->HaalSpecialsOp();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Filmpje - Uw biosccop in Rotterdam</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="css/stylesheet.css">
        <link rel="stylesheet" href="css/messi.css">
        <link rel="stylesheet" href="css/wt-rotator.css">
        <link rel="stylesheet" href="css/jquery.tweet.css">
        <script src="javascript/jquery.js" type="text/javascript"></script>
        <script src="javascript/jquery-ui.js" type="text/javascript"></script>
        <script src="javascript/FilmTabs.js" type="text/javascript"></script>
        <script src="javascript/VandaagMorgenOvermorgen.js" type="text/javascript"></script>
        <script src="javascript/MessiPopup.js" type="text/javascript"></script>
        <script src="javascript/Zoeken.js" type="text/javascript"></script>
        <script src="javascript/jquery.wt-rotator.min.js" type="text/javascript"></script>
        <script src="javascript/Carousel.js" type="text/javascript"></script>
        <script src="javascript/SpecialAccordion.js" type="text/javascript"></script>
        <script src="javascript/jquery.tweet.js" type="text/javascript"></script>
        <script src="javascript/Twitter.js" type="text/javascript"></script>
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
                <li><a href="#">Info</a>
                    <ul>
                        <li><a href="bereikbaarheid.php">Bereikbaarheid</a></li>
                        <li><a href="openingstijden.php">Openingstijden</a></li>
                    </ul>
                </li>
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
                    <?php $top10view = new Top10View(); $top10view->Render(); ?>
                </div>

            </div>
                </td>
                <td>
            <div id="mainContent">
                <div id="pagebanner">
                <?php $carouselView = new CarouselView(); $carouselView->Render(); ?>    
                </div>
                <div id="schedule">
                    <p>Nu bij Filmpje</p>
                    <table class="timeHeaderTable" style="margin-bottom: 0px;">
                        <tr class="dateRow">
                            <th id="dateTh">
                                <button id="vandaagButton" class="currentDate" onClick="DagButtonClick('Vandaag')">Vandaag</button>
                                <button id="morgenButton" onClick="DagButtonClick('Morgen')">Morgen</button>
                                <button id="overmorgenButton" onClick="DagButtonClick('Overmorgen')">Overmorgen</button>
                            </th>
                        <tr>
                            <td id="fillerTd"></td>
                        </tr>
                    </table>

                    <?php
                    $vandaagMorgenOvermorgenFilmsViewControler = new VandaagMorgenOvermorgenView();
                    $vandaagMorgenOvermorgenFilmsViewControler->Render();
                    ?>

                    <form method="post" id="voorstellingForm" action="ReserverenStap1.php">
                        <input type="hidden" id="modus" name="modus" value="">
                        <input type="hidden" id="voorstelling" name="voorstelling" value="">
                    </form>
                </div>	
                <div id="specialsDiv">
                    <?php $specialsAccordionView = new SpecialAccordionView(); $specialsAccordionView->Render(); ?>
                </div>
            </div>
                </td>
        </tr>
        </table>
            <div style="clear:both;">  </div>
            <footer>
                <div style="float: left;">
                <p>Contact</p>
                <ul>
                    <li>Klantenservice</li>
                    <li>Contact opnemen</li>
                    <li>Adverteren bij FIlmpje</li>
                    <li>Route</li>
                    <li>Terms of Service</li>
                </ul>
                </div>
                <div style="float: left;">
                    <p style="width: 325px">Twitter</p>
                <div id="ticker">
                    
                </div>
                </div>
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