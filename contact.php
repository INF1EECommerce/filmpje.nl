<?php
include_once 'backend/DBFunctions.php';
include_once 'backend/Mail/SendEmail.php';
include_once 'Views/Top10View.php';
$dbfunctions = new DBFunctions();
$specials = $dbfunctions->HaalSpecialsOp();
if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
    $sendEmail = new SendEmail();
    $sendEmail->ZendEmailContactFormulier($_POST);
    $bericht= "Uw bericht is succesvol verzonden.";
    header("Location: contact.php?m=".  urlencode($bericht));
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Filmpje.nl - Contact</title>
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="css/stylesheet.css">
        <link rel="stylesheet" href="css/messi.css">        
        <link href="css/SpryValidationTextField.css" rel="stylesheet" type="text/css">
        <link href="css/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
        <script src="javascript/jquery.js" type="text/javascript"></script>
        <script src="javascript/jquery-ui.js" type="text/javascript"></script>
        <script src="javascript/Zoeken.js" type="text/javascript"></script>
        <script src="javascript/SpryValidationTextField.js" type="text/javascript"></script>
        <script src="javascript/SpryValidationTextarea.js" type="text/javascript"></script>
        <script src="javascript/MessiPopup.js" type="text/javascript"></script>
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
                <li><a href="#">Info</a>                     <ul>                         <li><a href="bereikbaarheid.php">Bereikbaarheid</a></li>                     </ul>                 </li>
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
                    <form style="width: 250px;" action="filmoverzicht.php" method="GET"><input id="qtext" type="text" name="qtext"><input class="ZoekSubmitButton" type="submit" value="Zoek"></form>
                </li>
 
            </ul>
        </nav>
        <div id="outerDiv">
            <div id="mainContent">
                <div id="pagebanner">
                    <img src="image/banner_avengers.png">
                </div>
                <!-- kiezen tussen contactgegevens/openingstijden/bereikbaarheid/tarieven via php -->
                <div id="infoDiv">
                    <h2>Contact opnemen</h2>
                    <section id="contactDiv">
                        <article>
                            Filmpje streeft ernaar u van de beste service te voorzien. 
                            Indien u vragen of suggesties heeft raden wij u aan om die 
                            telefonisch of via het contactformulier aan ons door te geven.
                            <br> 
                            <br>
                            Wij zullen uw vraag of suggestie binnen 5 werkdagen beantwoorden.
                            <br>
                            <br>
                            Vult u de gegevens alstublieft via onderstaand formulier in, dan nemen
                            wij zo spoedig mogelijk contact met u op.

                            <form method="POST">
                                <p class="subblockheader">Formulier</p>
                                <p>
                                <table>
                                    <tr>
                                        <td>
                                            Onderwerp:
                                        </td>
                                        <td>
                                            <select name="onderwerp">
                                                <option selected="selected" value="Vraag">
                                                    Vraag
                                                </option>
                                                <option value="Klacht">Klacht</option>
                                                <option value="Suggestie">Suggestie</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr><td width="90px">
                                            Voornaam:</td><td><span id="voornaamText">
                                                <input type="text" name="voornaam">
                                                <span class="textfieldRequiredMsg">Voornaam is verplicht.</span></span>                                              </input>
                                        </td></tr><tr><td>
                                            Achternaam:</td><td><span id="achternaamText">
                                                <input type="text" name="achternaam">
                                                <span class="textfieldRequiredMsg">Achternaam is verplicht.</span></span>                                              </input></td>
                                    </tr><tr><td>
                                            E-mail: </td><td><span id="emailText">
                                                <input type="text" name="email">
                                                <span class="textfieldRequiredMsg">E-mail is verplicht.</span><span class="textfieldInvalidFormatMsg">Dit is geen email adres.</span></span>                                              </input>
                                        </td></tr><tr><td>&nbsp;</td></tr><tr><td colspan="2">
                                            Bericht
                                            <br><br>
                                            <span id="berichtText">
                                                <textarea name="bericht" id="comment"></textarea>
                                                <span class="textareaRequiredMsg">Bericht is verplicht</span><span class="textareaMinCharsMsg">Het minimaal aantal karakters is 20.</span></span></td>
                                </table>
                                </p>
                                <button class="buttonLight">Versturen</button>
                            </form>
                        </article>
                    </section>
                    <p style="clear: both; padding-bottom: 25px;"></p>
                </div>


            </div> <!-- mainContent -->


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
            </div> <!-- sideContent -->
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
        <script type="text/javascript">
            var voornaamText = new Spry.Widget.ValidationTextField("voornaamText", "none", {validateOn:["change"], hint:"Uw voornaam"});
            var achternaamText = new Spry.Widget.ValidationTextField("achternaamText", "none", {validateOn:["change"], hint:"Uw achternaam"});
            var emailText = new Spry.Widget.ValidationTextField("emailText", "email", {validateOn:["change"], hint:"v.b. info@filmpje.nl"});
            var berichtText = new Spry.Widget.ValidationTextarea("berichtText", {validateOn:["change"], hint:"Geeft u hier a.u.b. een korte beschrijving van uw vraag, klacht of suggestie.", minChars:20});
        </script>
    </body>
</html>