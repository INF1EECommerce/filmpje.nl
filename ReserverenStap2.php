<?php 
include_once 'Helpers/ExceptionHelper.php';
set_exception_handler('ExceptionHelper::exception_handler');
include_once 'Views/FilmPoosterEnInfoView.php'; 
include_once 'Views/BestellingOverzichtView.php';
include_once 'Views/BestellingOverzichtHeaderView.php';
include_once 'Views/SpecialsMenuItemsView.php';
include_once 'Helpers/ReferenceGenerator.php';
include_once 'backend/validatie/ReserverenPostValidatie.php';
include_once 'backend/TotaalPrijsCalculatie.php';

$validatie = new ReserverenPostValidatie();
$postWaardes = $validatie->ValideerStap2($_POST);
?>
<!DOCTYPE html>
<html>
<head>
<title>Filmje - <?php echo $postWaardes['Modus']; ?> - Stap 2</title>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="css/stylesheet.css">
<link href="css/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="css/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script src="javascript/SpryValidationTextField.js" type="text/javascript"></script>
<script src="javascript/SpryValidationSelect.js" type="text/javascript"></script>
<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/jquery-ui.js" type="text/javascript"></script>
<script src="javascript/popup.js" type="text/javascript"></script>
<script src="javascript/Zoeken.js" type="text/javascript"></script>
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
                        $specialsMenuitems = new SpecialsMenuItemsView();  $specialsMenuitems->Render();
                        ?>
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
        <?php $filmPoosterEnInfoView = new FilmPoosterEnInfoView(); $filmPoosterEnInfoView ->Render($postWaardes['Voorstelling']); ?>
         </div>
            </td><td>
        <div id="mainContent">
       <div id="ss">
           <p class="blockheader"><?php echo strtoupper($postWaardes['Modus']); ?> STAP2 - Uw gegevens</p>
           <div id="ReserverenHeader">
            <?php $bestellingOverzichtHeader = new BestellingOverzichtHeaderView(); $bestellingOverzichtHeader ->Render($postWaardes['Voorstelling']); ?>    
        </div>
        <div id="formulier">
            
        <form method="POST" id="ReserverenForm" action="ReserverenStap3.php">
            <table>
                <caption>Uw contactinformatie</caption>
                <tr>
                    <td style="width: 120px;"><label>Voornaam:</label></td>
                    <td><span id="voornaamText">
                      <input type="text" value="" name="voornaam">
                      <span class="textfieldRequiredMsg">Voornaam is verplicht.</span></span>
                  <td>
            </tr>
            <tr>
                <td><label>Achternaam:</label></td>
                <td><span id="achternaamText">
                  <input type="text" value="" name="achternaam">
                <span class="textfieldRequiredMsg">Achternaam is verplicht.</span></span></td>
            </tr>
            <tr>
                <td><label>Adres:</label></td>
                <td><span id="adresText">
                  <input type="text" value="" name="adres">
                <span class="textfieldRequiredMsg">Adres is verplicht.</span></span></td>
            </tr>
            <tr>
                <td><label>Postcode:</label></td>
                <td><span id="postcodeText">
                <input type="text" value="" name="postcode">
                <span class="textfieldRequiredMsg">Postcode is verplicht.</span><span class="textfieldMinCharsMsg">Postcode moet minimaal 7 karakters lang zijn.</span><span class="textfieldMaxCharsMsg">Postcode mag maximaal 7 karakters lang zijn.</span><span class="textfieldInvalidFormatMsg">v.b. 1234 AA</span></span></td>
            </tr>
            <tr>
                <td><label>Plaats:</label></td>
                <td><span id="plaatsText">
                  <input type="text" value="" name="plaats">
                <span class="textfieldRequiredMsg">Plaats is verplicht.</span></span></td>
            </tr>
            <tr>
                <td><label>Email:</label></td>
                <td><span id="emailText">
                  <input type="text" value="" name="email">
                  <span class="textfieldRequiredMsg">Email is verplicht.</span><span class="textfieldInvalidFormatMsg">v.b. info@filmpje.nl</span></td>
            </tr>
            <tr>
                <td><label>Telefoonnummer:</label></td>
                <td><span id="telefoonnummerText">
                <input type="text" value="" name="telefoon">
                <span class="textfieldRequiredMsg">Telefoonnummer is verplicht.</span><span class="textfieldMinCharsMsg">Telefoonnummer moet 10 cijfers lang zijn.</span><span class="textfieldMaxCharsMsg">Telefoonnummer mag maximaal 10 cijfers lang zijn.</span><span class="textfieldInvalidFormatMsg">v.b. 0101234567</span></span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <?php if($postWaardes['Modus'] =="bestellen")
            { ?>
            <tr>
            
                <td><label>Uw bank:</label></td>
                <td><span id="bankSelect">
                  <select name="issuer">
                    <option value="-1">Selecteer uw bank a.u.b</option>
                    <option value="0">ABN-Amro</option>
                    <option value="1">ASN Bank</option>
                    <option value="2">Friesland Bank</option>
                    <option value="3">ING</option>
                    <option value="4">Rabobank</option>
                    <option value="5">SNS Bank</option>
                    <option value="6">SNS Regiobank</option>
                    <option value="7">Tridios Bank</option>
                    <option value="8">Van Lanschot Bankiers</option>
                  </select>
                <span class="selectRequiredMsg">Selecteer uw bank a.u.b.</span></span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <?php } ?>
            <tr><td colspan="2" style="width: 400px;">
                    <input type="hidden" name="reference" value ="<?php echo ReferenceGenerator::Genereer(); ?>">
                    <input type="hidden" name="geselecteerdestoelen" value="<?php echo $postWaardes['GeslecteerdeStoelen']; ?>">
                    <input type="hidden" name="voorstelling" value="<?php echo $postWaardes['Voorstelling']; ?>">
                    <input type="hidden" name="modus" value="<?php echo $postWaardes['Modus']; ?>">
                    <?php if($postWaardes['Modus'] == "bestellen")
                    { ?>
                    <input type="submit" style="float: left; margin-top: 3px;" class="buttonLight" value="Bestelling plaatsen"><img style="margin-left: 10px; float: left;" src="image/Misc/ideal.png" alt="ideallogo"><span style="float: left; margin-top: 10px; margin-left: 10px;"> Veilig betalen met IDeal.</span>
                    <?php } else {  ?>
                    <input type="submit" style="float: left" class="buttonLight" value="Reserveren">
                    <?php } ?>
                </td>
        </table>
        </form>
        </div>
          <div id="StoelPrijzen">
         <?php $bestellingOverzichtView = new BestellingOverzichtView(); $bestellingOverzichtView->Render($postWaardes['GeslecteerdeStoelen']) ?> 
        </div>
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
<script type="text/javascript">
var voornaamText = new Spry.Widget.ValidationTextField("voornaamText", "none", {validateOn:["change"], hint:"Uw voornaam"});
var achternaamText = new Spry.Widget.ValidationTextField("achternaamText", "none", {validateOn:["change"], hint:"Uw achternaam"});
var adresText = new Spry.Widget.ValidationTextField("adresText", "none", {hint:"b.v. Dorpsweg 18", validateOn:["change"]});
var postcodeText = new Spry.Widget.ValidationTextField("postcodeText", "zip_code", {hint:"b.v. 1234 AA", validateOn:["change"], format:"zip_custom", pattern:"0000 AA"});
var emailText = new Spry.Widget.ValidationTextField("emailText", "email", {validateOn:["change"], hint:"b.v. info@filmpje.nl"});
var telefoonnummerText = new Spry.Widget.ValidationTextField("telefoonnummerText", "phone_number", {hint:"b.v. 0612345678", validateOn:["change"], format:"phone_custom", pattern:"0000000000"});
var plaatsText = new Spry.Widget.ValidationTextField("plaatsText", "none", {hint:"b.v. Amsterdam", validateOn:["change"]});
<?php if($postWaardes['Modus'] == "bestellen")
{ ?>
var bankSelect = new Spry.Widget.ValidationSelect("bankSelect", { invalidValue:"-1", validateOn:["change"] });
<?php } ?>
</script>
</body>
</html>