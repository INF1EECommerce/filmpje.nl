<?php
include_once 'Helpers/ExceptionHelper.php';
set_exception_handler('ExceptionHelper::exception_handler');
include_once 'backend/Mail/SendEmail.php';
include_once 'Views/Top10View.php';
include_once 'Views/SpecialsMenuItemsView.php';
include_once 'backend/validatie/ContactPostValidatie.php';

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $validatie =  new ContactPostValidatie();
    $postWaardes = $validatie->Valideer($_POST);
    if ($postWaardes['Captcha']){
    $sendEmail = new SendEmail();
    $sendEmail->ZendEmailContactFormulier($postWaardes['Formulier']);
    header("Location: index.php?m=Uw+bericht+is+succesvol+verzonden.");
    }
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
                <li><a href="#">Info</a>                     <ul>                         <li><a href="bereikbaarheid.php">Bereikbaarheid</a></li>                         <li><a href="openingstijden.php">Openingstijden</a></li>                     </ul>                 </li>
                <li><a href="contact.php">Contact</a></li>
                <li id="lastLi">Specials
                    <?php $specialsMenuitems = new SpecialsMenuItemsView();
                    $specialsMenuitems->Render(); ?>
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
                                <?php $top10view = new Top10View();
                                $top10view->Render(); ?>
                            </div>
                        </div>
                    </td><td>
                        <div id="mainContent">
                            <div id="pagebanner">
                                <img src="image/PageBanners/contact.png">
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
                                                            <input type="text" name="voornaam" value="<?php if(isset($postWaardes)) echo $postWaardes['Formulier']['voornaam'] ?>">
                                                            <span class="textfieldRequiredMsg">Voornaam is verplicht.</span></span>                                              </input>
                                                    </td></tr><tr><td>
                                                        Achternaam:</td><td><span id="achternaamText">
                                                            <input type="text" name="achternaam" value="<?php if(isset($postWaardes)) echo $postWaardes['Formulier']['achternaam'] ?>">
                                                            <span class="textfieldRequiredMsg">Achternaam is verplicht.</span></span>                                              </input></td>
                                                </tr><tr><td>
                                                        E-mail: </td><td><span id="emailText">
                                                            <input type="text" name="email" value="<?php if(isset($postWaardes)) echo $postWaardes['Formulier']['email'] ?>">
                                                            <span class="textfieldRequiredMsg">E-mail is verplicht.</span><span class="textfieldInvalidFormatMsg">v.b. info@filmpje.nl</span></span>                                              </input>
                                                    </td></tr><tr><td>&nbsp;</td></tr><tr><td colspan="2">
                                                        Bericht
                                                        <br><br>
                                                        <span id="berichtText">
                                                            <textarea name="bericht" id="comment"><?php if(isset($postWaardes)) echo $postWaardes['Formulier']['bericht'] ?></textarea>
                                                            <span class="textareaRequiredMsg">Bericht is verplicht<br><br></span><span class="textareaMinCharsMsg">Het minimaal aantal karakters van het bericht is 20.<br><br></span></span></td></tr>
                                                <tr><td colspan="2"><img src="Captcha/captcha.php" />
                                                        <br />Bovenstaand woord:<br>
                                                        <span id="captchaText" <?php if(!$postWaardes['Captcha'] && isset($postWaardes['Captcha'])) { echo "class=\"textfieldRequiredState\""; }?>>
                                                            <input style="width: 195px;" type="text" name="captcha" value="" />
                                                            <span class="textfieldRequiredMsg"><br><br>Geef a.u.b het bovenstaande woord op.</span></span></td></tr>           
                                            </table>
                                            </p>
                                            <input type="submit" class="buttonLight" value="Versturen">
                                        </form>
                                    </article>
                                </section>
                                <p style="clear: both; padding-bottom: 25px;"></p>
                            </div>


                        </div></td></tr></table> <!-- mainContent -->


            <!-- sideContent -->
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
            var captchaText = new Spry.Widget.ValidationTextField("captchaText", "none", {validateOn:["change"]});
        </script>
    </body>
</html>