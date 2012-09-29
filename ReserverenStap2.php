<?php require_once(dirname(__FILE__).'/backend/DBFunctions.php'); ?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="css/stylesheet.css">
</head>
<body>
	<div id="header">
		<div id="banner">
			<ul>
				<li><a href="#">Home</a></li>
				<li><a href="#">Films</a></li>
				<li><a href="#">Agenda</a></li>
				<li><a href="#">Contact</a></li>
				<li><a href="#">Specials</a></li>
			</ul>
		
		</div>
	</div>
	
	<div id="outerDiv">
        <div id="sideContent">
            <div id="filmPoosterEnInfo">
                <img src="image/apooster.jpg">
                <div id="filmInfo">
                    <h2>The Avengers</h2>
                    <div id="tijdEnZaal">15:00 uur <br>
                    Zaal 1
                    </div>
                </div>
            </div>               
         </div>
        <div id="mainContent">
       <div id="ss">
        <div id="ReserverenHeader">
        <h2>Reservering afronden</h2>
        The Avengers - 20-9-2010 - 15:00 UUR
        </div>
        <div id="StoelPrijzen">
            <h3>Ticketoverzicht</h3>    
            <table>
                <thead>
                <th>Rij</th><th>Stoel</th><th>Type</th><th>Prijs</th>
                </thead>
                <tbody>
                    <?php
                    $totaalPrijs = 0;
                     $geselecteerdeStoelen = $_POST['GeselecteerdeStoelen'];
                     
                     $dbfunctions = new DBFunctions();
                     
                     $stoelInfo = $dbfunctions -> StoelInfo($geselecteerdeStoelen);
                     
                     foreach ($stoelInfo as $stoel) { 
                     $totaalPrijs = $totaalPrijs + $stoel['StoelPrijs'];
                     ?>
                         
                    <tr><td><?php echo $stoel['RijNummer'] ?></td><td><?php echo $stoel['StoelNummer'] ?></td><td><?php echo $stoel['StoelType'] ?></td><td><?php echo $stoel['StoelPrijs'] ?></td></tr>      
                         
                    <?php } ?>
                </tbody>
                <tfoot>

                    <tr style="background-color: #999999; color: #FFFFFF;"><td>Totaal:</td><td></td><td></td><td><?php echo $totaalPrijs ?></td></tr>
                </tfoot>
            </table>
            
        </div>
        <div id="formulier">
        <h3>Uw contactinformatie</h3>
        <form method="POST" id="ReserverenForm" action="ReserverenStap3.php">
            <table>
                <tr>
                    <td><label>Voornaam:</label></td>
                    <td><input type="text" value="" name="voornaam"><td>
            </tr>
            <tr>
                <td><label>Achternaam:</label></td>
                <td><input type="text" value="" name="achternaam"></td>
            </tr>
            <tr>
                <td><label>Adres:</label></td>
                <td><input type="text" value="" name="adres"></td>
            </tr>
            <tr>
                <td><label>Postcode:</label></td>
                <td><input type="text" value="" name="postcode"></td>
            </tr>
            <tr>
                <td><label>Email:</label></td>
                <td><input type="text" value="" name="email"></td>
            </tr>
            <tr>
                <td><label>Telefoon:</label></td>
                <td><input type="text" value="" name="telefoon"></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
            
                <td><label>Uw bank:</label></td>
                <td><select name="issuer">
                <option value="0">ABN-Amro</option>
                <option value="1">ASN Bank</option>
                <option value="2">Friesland Bank</option>
                <option value="3">ING</option>
                <option value="4">Rabobank</option>
                <option value="5">SNS Bank</option>
                <option value="5">SNS Regiobank</option>
                <option value="6">Tridios Bank</option>
                <option value="7">Van Lanschot Bankiers</option>
            </select>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>
                    <input type="hidden" name="amount" value="<?php echo $totaalPrijs ?>">
                    <input type="hidden" name="reference" value ="Dit is een test referemce">
                    <input type="hidden" name="description" value="Dit is een test description">
                    <input type="hidden" name="orderId"> 
                    <input type="submit" value="Bestelling plaatsen"></td>
        </table>
        </form>
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
