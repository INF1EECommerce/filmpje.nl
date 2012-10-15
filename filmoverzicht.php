<?php 
include_once 'Views/NuBinnenkortView.php'; 
include_once 'backend/DBFunctions.php';
$dbfunctions = new DBFunctions();
$specials = $dbfunctions->HaalSpecialsOp();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Filmpje - Filmovezicht</title>
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="css/stylesheet.css">
        <script src="javascript/jquery.js" type="text/javascript"></script>
        <script src="javascript/jquery-ui.js" type="text/javascript"></script>
        <script src="javascript/NBTabs.js" type="text/javascript"></script> 
        <script src="javascript/Zoeken.js" type="text/javascript"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Pulled from http://code.google.com/p/html5shiv/ -->
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <style>#Zoekbox { margin-left: -300px; }</style>
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
                        <input type="hidden" name="voorstelling" value="1">
                        <!--<input type="submit" id="reserveer">Reserveer</button>-->
                        <input type="submit" id="koop" value="Koop">
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
                        <li><button onclick="SwitchView()">8</button>The Watch</li>
                        <li><button>9</button>Intouchables</li>
                        <li><button>10</button>Detachment</li>
                        <button id="reviews">Top 10 Filmreviews</button>
                    </ul>

                </div>

            </div>
            <div id="mainContent">
                <div id="nubinnenkort">
                    <p class="blockheader">Films Nu\Binnenkort</p>
                    <table class="timeHeaderTable">
                        <tr class="dateRow">
                            <th id="dateTh">
                                <button id="nuButton" class="currentDate" onClick="NBClick('Nu')">Nu</button>
                                <button id="binnenkortButton" onClick="NBClick('Binnenkort')">Binnenkort</button>
                                <button style="float:right; width: 150px; margin-right: 10px;" id="SwitchViewButton" onClick="SwitchView();">Verander weergave</button>
                            </th>
                        </tr>
                    </table>
                  <?php $nubinnenkortview = new NuBinnenkortView(); $nubinnenkortview->Render(); ?>
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
    </body>
</html>