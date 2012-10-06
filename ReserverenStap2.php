<?php 

include_once 'Views/FilmPoosterEnInfoView.php'; 
include_once 'Views/BestellingOverzichtView.php';
include_once 'Views/BestellingOverzichtHeaderView.php';
include_once 'Helpers/ReferenceGenerator.php';

//include_once '/Views/FilmPoosterEnInfoView.php'; 
//include_once '/Views/BestellingOverzichtView.php';
//include_once '/Views/BestellingOverzichtHeaderView.php';
//include_once '/Helpers/ReferenceGenerator.php';

$voorstelling = intval($_POST['voorstellingid']);
$geselecteerdeStoelen = $_POST['GeselecteerdeStoelen'];
if ($voorstelling == 0 || strlen($geselecteerdeStoelen) == 0) {
    header('Location: index.php');
}
ob_start();
$bestellingOverzichtView = new BestellingOverzichtView();
$bestellingOverzichtView->Render($geselecteerdeStoelen);
$stoelenTabel = ob_get_contents();
ob_end_clean();
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="css/stylesheet.css">
<link href="css/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="css/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script src="javascript/SpryValidationTextField.js" type="text/javascript"></script>
<script src="javascript/SpryValidationSelect.js" type="text/javascript"></script>
</head>
<body>
	<header>
		<img src="image/header2.png">
	</header>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="#">Films</a></li>
			<li><a href="#">Info</a></li>
			<li><a href="#">Contact</a></li>
			<li id="lastLi"><a href="#">Specials</a></li>
		</ul>
	</nav>
	
	<div id="outerDiv">
        <div id="sideContent">
        <?php $filmPoosterEnInfoView = new FilmPoosterEnInfoView(); $filmPoosterEnInfoView ->Render($voorstelling); ?>
         </div>
        <div id="mainContent">
       <div id="ss">
       <p class="blockheader">STAP2 - Uw gegevens</p>
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
                <span class="textfieldRequiredMsg">Postcode is verplicht.</span></span></td>
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
                <span class="textfieldRequiredMsg">Email is verplicht.</span></span></td>
            </tr>
            <tr>
                <td><label>Telefoonnummer:</label></td>
                <td><span id="telefoonnummerText">
                  <input type="text" value="" name="telefoon">
                <span class="textfieldRequiredMsg">Telefoonnummer is verplicht.</span></span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
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
            <tr><td>
                    <input type="hidden" name="amount" value="<?php echo $bestellingOverzichtView -> totaalPrijs; ?>">
                    <input type="hidden" name="reference" value ="<?php echo ReferenceGenerator::Genereer(); ?>">
                    <input type="hidden" name="stoelen" value="<?php echo $geselecteerdeStoelen; ?>">
                    <input type="hidden" name="voorstelling" value="<?php echo $voorstelling; ?>">
                    <input type="hidden" name="description" value="Uw bestelling bij Filmpje.">
                    <input type="submit" value="Bestelling plaatsen"></td>
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
var voornaamText = new Spry.Widget.ValidationTextField("voornaamText");
var achternaamText = new Spry.Widget.ValidationTextField("achternaamText");
var adresText = new Spry.Widget.ValidationTextField("adresText");
var postcodeText = new Spry.Widget.ValidationTextField("postcodeText");
var emailText = new Spry.Widget.ValidationTextField("emailText", "email");
var telefoonnummerText = new Spry.Widget.ValidationTextField("telefoonnummerText");
var plaatsText = new Spry.Widget.ValidationTextField("plaatsText");
var bankSelect = new Spry.Widget.ValidationSelect("bankSelect", { invalidValue:"-1" });
</script>
</body>
</html>
