<?php
require_once('Views/VandaagMorgenOvermorgenView.php');
require_once 'backend/DBFunctions.php';
require_once 'Views/CarouselView.php';
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
        <script src="javascript/jquery.js" type="text/javascript"></script>
        <script src="javascript/jquery-ui.js" type="text/javascript"></script>
        <script src="javascript/FilmTabs.js" type="text/javascript"></script>
        <script src="javascript/VandaagMorgenOvermorgen.js" type="text/javascript"></script>
        <script src="javascript/MessiPopup.js" type="text/javascript"></script>
        <script src="javascript/Zoeken.js" type="text/javascript"></script>
        <script src="javascript/jquery.wt-rotator.min.js" type="text/javascript"></script>
        <script src="javascript/Carousel.js" type="text/javascript"></script>
        <!-- Pulled from http://code.google.com/p/html5shiv/ -->
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <header>   
            <div Id="Zoekbox">
                <form action="filmoverzicht.php" method="GET"><input id="qtext" type="text" name="qtext"><input class="submitb" type="submit" value="Zoek"></form>
            </div>
            <div Id="ZoekPopup" style="display: none;">
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="filmoverzicht.php">Films</a></li>
                <li><a href="#">Info</a></li>
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
            </ul>
        </nav>

        <div id="outerDiv">
            <div id="sideContent">
                <form action="ReserverenStap1.php" method="POST">
                    <h2>SNELLE TICKETVERKOOP</h2>
                    <p>
                        <label for="film">film</label>	
                        <select id="film1">
                            <option id="film">The Avengers</option>
                    </p>
                    </select>

                    <p>
                        <label for="dag">dag</label>
                        <select id="dag1">	
                            <option id="dag">vandaag</option>
                    </p>
                    </select>

                    <p>
                        <label for="tijd">tijd</label>	
                        <select id="tijd1">
                            <option id="tijd">15:00</option>
                    </p>
                    </select>
                    <p>
                        <button id="reserveer">Reserveer</button>
                        <button id="koop">Koop</button>
                    </p>
                    <p style="clear: both;"></p>
                </form>

                <div id="top10">

                    <ul id="top10">
                        <li id="top10header"><p>Top 10 films</p></li>
                        <li id="firstLi"><button>1</button>Ted</li>
                        <li><button>2</button>The Possession</li>
                        <li><button>3</button>The Bourne Legacy</li>
                        <li><button>4</button>De Verbouwing</li>
                        <li><button>5</button>Bait</li>
                        <li><button>6</button>The Expendables 2</li>
                        <li><button>7</button>The Dark Knight Rises</li>
                        <li><button>8</button>The Watch</li>
                        <li><button>9</button>Intouchables</li>
                        <li><button>10</button>Detachment</li>
                        <li style="border-bottom: 0px;"><button id="reviews">Top 10 Filmreviews</button></li>
                    </ul>

                </div>

            </div>
            <div id="mainContent">
                <div id="moviebanner">
                <?php $carouselView = new CarouselView(); $carouselView->Render(); ?>    
                </div>
                <div id="schedule">
                    <p>Nu bij Filmpje</p>
                    <table class="timeHeaderTable">
                        <tr class="dateRow">
                            <th id="dateTh">
                                <button id="vandaagButton" class="currentDate" onClick="DagButtonClick('Vandaag')">Vandaag</button>
                                <button id="morgenButton" onClick="DagButtonClick('Morgen')">Morgen</button>
                                <button id="overmorgenButton" onClick="DagButtonClick('Overmorgen')">Overmorgen</button>
                            </th>
                        <tr>
                            <td id="fillerTd"></td>
                        </tr>
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
                    <div id="mainSpecialsDiv">
                        <h2>Ladies Night</h2>
                        <h3>Alle vrouwen verzamelen</h3>
                        <p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
                    </div>
                    <div id="specialSideContent">
                        <img src="image/ladiesnight.jpg">
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
        <div Id="TijdKlikPopup">
            <div class="popupButtonClass">
                <div id="TijdKlikPopUpHeader" style="display: block; width: 100%">

                </div>
                <button id="popupbb">Bestellen</button><button id="popuprb">Reserveren</button>
            </div>
        </div>
    </body>
</html>