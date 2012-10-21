<?php 
include_once 'Views/ZoekresultatenView.php'; 
include_once 'Views/SpecialAccordionView.php';
include_once 'Views/Top10View.php';
include_once 'backend/DBFunctions.php';
$dbfunctions = new DBFunctions();
$specials = $dbfunctions->HaalSpecialsOp();
if (isset($_GET['qtext'])) {
    $query = urldecode($_GET['qtext']);
}
else
{
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Filmmpje - Zoekresultaten</title>
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="css/stylesheet.css">
        <script src="javascript/jquery.js" type="text/javascript"></script>
        <script src="javascript/jquery-ui.js" type="text/javascript"></script>
        <script src="javascript/Zoeken.js" type="text/javascript"></script>
        <script src="javascript/SpecialAccordion.js" type="text/javascript"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
            <div id="mainContent">
                <div id="ZoekResultaten">
                    <p class="blockheader">Zoekresultaten</p>
                    <?php $zoekresultatenView =  new ZoekresultatenView($query);  $zoekresultatenView->Render(); ?>
                </div>
            <div id="specialsDiv">
                <?php $specialsAccordionView = new SpecialAccordionView(); $specialsAccordionView->Render(); ?>
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