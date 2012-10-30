<?php 
include_once 'Views/NuBinnenkortView.php'; 
include_once 'Views/SpecialAccordionView.php';
include_once 'Views/Top10View.php';
include_once 'Views/SpecialsMenuItemsView.php';
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
        <script src="javascript/SpecialAccordion.js" type="text/javascript"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Pulled from http://code.google.com/p/html5shiv/ -->
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <style>#Zoekbox { margin-left: -300px; }</style>
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
                    <?php $specialsMenuitems =  new SpecialsMenuItemsView(); $specialsMenuitems->Render(); ?>
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
            </td><td>
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
                <?php $specialsAccordionView = new SpecialAccordionView(); $specialsAccordionView->Render(); ?>
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