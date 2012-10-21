<?php 

include_once 'Views/FilmPoosterEnInfoView.php'; 
include_once 'Views/BestellingOverzichtView.php';
include_once 'Views/BestellingOverzichtHeaderView.php';
include_once 'Helpers/ReferenceGenerator.php';
include_once 'backend/DBFunctions.php';
$dbfunctions = new DBFunctions();
$specials = $dbfunctions->HaalSpecialsOp();
$voorstelling = intval($_POST['voorstellingid']);
$geselecteerdeStoelen = $_POST['GeselecteerdeStoelen'];
if ($voorstelling == 0 || strlen($geselecteerdeStoelen) == 0 || !isset($_POST['modus'])) {
    header('Location: index.php');
}
$modus = $_POST['modus'];
ob_start();
$bestellingOverzichtView = new BestellingOverzichtView();
$bestellingOverzichtView->Render($geselecteerdeStoelen);
$stoelenTabel = ob_get_contents();
ob_end_clean();
?>
<!DOCTYPE html>
<html>
<head>
<title>Filmje - <?php echo $modus; ?> - Stap 2</title>
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
        <?php $filmPoosterEnInfoView = new FilmPoosterEnInfoView(); $filmPoosterEnInfoView ->Render($voorstelling); ?>
         </div>
        <div id="mainContent">
       <div id="ss">
           <p class="blockheader"><?php echo strtoupper($modus); ?> STAP2 - Uw gegevens</p>
        <div id="ReserverenHeader">
        <?php $bestellingOverzichtHeader = new BestellingOverzichtHeaderView(); $bestellingOverzichtHeader ->Render($voorstelling); ?>    
        </div>
        <div id="formulier">
        
        <form method="POST" id="ReserverenForm" action="ReserverenStap3.php">
            <table>
                <caption>Uw contactinformatie</caption>
                <tr>
                    <td><label>Voornaam:</label></td>
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
                <span class="textfieldRequiredMsg">Postcode is verplicht.</span><span class="textfieldMinCharsMsg">Postcode moet minimaal 7 karakters lang zijn.</span><span class="textfieldMaxCharsMsg">Postcode mag maximaal 7 karakters lang zijn.</span></span></td>
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
                  <span class="textfieldRequiredMsg">Email is verplicht.</span><span class="textfieldInvalidFormatMsg">Dit is geen email adres.</span></td>
            </tr>
            <tr>
                <td><label>Telefoonnummer:</label></td>
                <td><span id="telefoonnummerText">
                <input type="text" value="" name="telefoon">
                <span class="textfieldRequiredMsg">Telefoonnummer is verplicht.</span><span class="textfieldMinCharsMsg">Telefoonnummer moet 10 cijfers lang zijn.</span><span class="textfieldMaxCharsMsg">Telefoonnummer mag maximaal 10 cijfers lang zijn.</span></span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <?php if($modus=="bestellen")
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
            <tr><td>
                    <input type="hidden" name="amount" value="<?php echo $bestellingOverzichtView -> totaalPrijs; ?>">
                    <input type="hidden" name="reference" value ="<?php echo ReferenceGenerator::Genereer(); ?>">
                    <input type="hidden" name="stoelen" value="<?php echo $geselecteerdeStoelen; ?>">
                    <input type="hidden" name="voorstelling" value="<?php echo $voorstelling; ?>">
                    <input type="hidden" name="description" value="Uw bestelling bij Filmpje.">
                    <input type="hidden" name="modus" value="<?php echo $modus; ?>">
                    <?php if($modus=="bestellen")
                    { ?>
                    <input type="submit" class="buttonLight" value="Bestelling plaatsen">
                    <?php } else {  ?>
                    <input type="submit" class="buttonLight" value="Reserveren">
                    <?php } ?>
                </td>
        </table>
        </form>
        </div>
          <div id="StoelPrijzen">
         <?php echo $stoelenTabel; ?> 
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
<script type="text/javascript">
var voornaamText = new Spry.Widget.ValidationTextField("voornaamText", "none", {validateOn:["change"], hint:"Uw voornaam"});
var achternaamText = new Spry.Widget.ValidationTextField("achternaamText", "none", {validateOn:["change"], hint:"Uw achternaam"});
var adresText = new Spry.Widget.ValidationTextField("adresText", "none", {hint:"b.v. Dorpsweg 18", validateOn:["change"]});
var postcodeText = new Spry.Widget.ValidationTextField("postcodeText", "none", {minChars:7, maxChars:7, hint:"b.v. 1234 AA", validateOn:["change"]});
var emailText = new Spry.Widget.ValidationTextField("emailText", "email", {validateOn:["change"], hint:"b.v. info@filmpje.nl"});
var telefoonnummerText = new Spry.Widget.ValidationTextField("telefoonnummerText", "none", {minChars:10, maxChars:10, hint:"b.v. 0612345678", validateOn:["change"]});
var plaatsText = new Spry.Widget.ValidationTextField("plaatsText", "none", {hint:"b.v. 0612345678", validateOn:["change"]});
<?php if($modus=="bestellen")
{ ?>
var bankSelect = new Spry.Widget.ValidationSelect("bankSelect", { invalidValue:"-1", validateOn:["change"] });
<?php } ?>
</script>
</body>
</html>
