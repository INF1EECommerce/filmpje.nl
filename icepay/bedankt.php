<?php 

if (!isset($_GET['vs'])) {
    die;
}
$voorstelling = intval($_GET['vs']);
include_once '/var/www/filmpje.nl/backend/DBFunctions.php';

$db = new DBFunctions();

$data = $db->FilmInfoVanVoorstelling($voorstelling);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../css/stylesheet.css"></link>
<title>Bedankt</title>
</head>

<body style="background-color: #550000; border: 0; padding: 0px; margin: 0px;">
       <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '411293302259375', // App ID
            channelUrl : 'http://chivan.com/filmpje.nl/Facebook/channel.php', // Channel File
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
          });
        };
        // Load the SDK Asynchronously
        (function(d){
           var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           ref.parentNode.insertBefore(js, ref);
         }(document));
         
         function openFBPopup()
         {
             FB.ui({ method: 'feed', 
                link: 'http://chivan.com/filmpje.nl',
                picture: 'http://chivan.com/filmpje.nl/image/Covers/<?php echo $data['Cover']; ?>',
                name: 'Filmpje',
                caption: 'Ik ga naar <?php echo $data['Naam']; ?> bij Filmpje.',
                description: 'Op <?php echo $data['Datum'] ?> om <?php echo substr($data['Tijd'], 0, 5); ?> uur.'

                        });
         }
      </script>
    <div id="bedankt">
        <h2> Bedankt</h2>
        <img src="../image/dofb.png" onclick="openFBPopup();">
<p>
    Hartelijk bedankt voor uw bestelling bij Filmpje.</br>
U ontvangt binnenkort een email ter bevestiging. Hierin vindt u ook uw bestellingnummer. </br> Bewaart u deze goed, dit is uw bewijs van betaling.
</p>
    <h2>Hoe komt u bij Filmpje?</h2>
    <p>Hier helpen wij u graag mee. U kunt uw adres opgeven bij "van" en klikt u dan op "ga".</br> Wij vertellen u hoe u moet rijden!</p>
<script src="//www.gmodules.com/ig/ifr?url=http://hosting.gmodules.com/ig/gadgets/file/114281111391296844949/driving-directions.xml&amp;up_fromLocation=&amp;up_myLocations=West-Kruiskade%2026%2C%203014%20AS%20in%20Rotterdam&amp;up_defaultDirectionsType=&amp;up_autoExpand=&amp;synd=open&amp;w=595&amp;h=500&amp;title=&amp;brand=light&amp;lang=nl&amp;country=ALL&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;output=js"></script>
    </div>
</body>
</html>

