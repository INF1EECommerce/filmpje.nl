<!DOCTYPE html>
<html>
    <head>
   <title>Filmpje.nl - Facebook Event aanmaken</title>
   <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="css/stylesheet.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
    <p class="blockheader" style=" margin-top: 0;">Oeps.</p>
    <?php if (isset($_GET['melding']) && $_GET['melding'] == 'afgewezen') {
     ?>
    <div id="PopupHeader">U heeft Fimpje geen toestemming gegven om u aan te melden bij Facebook. Hierdoor kunnen we helaas geen event voor u aanmaken.<br><br> 
        <input type="button" value="Nogmaals proberen" onclick="window.location = 'http://chivan.com/filmpje.nl/CreateEvent.php?voorstelling=<?php echo $_GET['voorstelling']; ?>'">
    </div>
    <?php } else { ?>
      <div id="PopupHeader">Er is een probleem opgetreden bij het aanmaken van uw facebook event.<br>Onze excuses voor het ongemak.<br>Indien u de applicatie geen toestemming heeft gegeven
          om namens u events aan te maken kunt u dit venster sluiten en het hieronder nogmaals proberen.<br>In ieder ander geval neemt u a.u.b contact op met Filmpje.<br><br>
          <input type="button" value="Venster sluiten" onclick="window.close();">
    <?php } ?>    
    </body>
</html>
