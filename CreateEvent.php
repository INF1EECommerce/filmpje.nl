<?php
include_once 'Facebook/FilmpjeFacebook.php';
include_once 'Views/FilmPoosterEnInfoView.php';

try {
$voorstelling = intval($_GET['voorstelling']);
} catch (Exception $ex) { header("Location: http://chivan.com/filmpje.nl/FacebookError.php"); } 

if (isset($_GET['error_reason']) && $_GET['error_reason'] == "user_denied") {
    header("Location: http://chivan.com/filmpje.nl/FacebookError.php?melding=afgewezen&voorstelling=" . $voorstelling);
    die;
}
$ff = new FilmpjeFacebook();

if ($ff->IsUserLoggingIn()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $eventData = $ff->ParsePostDataPopup($_POST);
            $eid = $ff->CreateEvent($eventData);
            header("Location: http://chivan.com/filmpje.nl/InviteFriends.php?eid=" . $eid['id'] . "&fbuser=" . $ff->user . "&voorstelling=".$voorstelling);
        } catch (Exception $ex) {
            header("Location: http://chivan.com/filmpje.nl/FacebookError.php");
        }
    }
} else {
    header("Location: " . $ff->GetLoginURL("http://chivan.com/filmpje.nl/CreateEvent.php?voorstelling=" . $voorstelling));
}
?>
<html>
    <head><title>Filmpje.nl - Facebook Event aanmaken</title>
        <link rel="stylesheet" href="css/stylesheet.css">
        <script src="javascript/jquery.js" type="text/javascript"></script>
        <script src="javascript/Loading.js" type="text/javascript"></script>
        <script src="javascript/resizepopup.js" type="text/javascript"></script>
    </head>
    <body>
        <p class="blockheader">STAP 1 - Facebook event aanmaken</p>
        <div id="PopupHeader">U gaat een facebook event aanmaken voor de volgende voorstelling:<br> Bij de volgende stap kunt u vrienden selecteren om uit te nodigen. </div>    
        <?php $view = new FilmPoosterEnInfoView(); $view->RenderVoorPopup($voorstelling); ?>
        <div id="loadinggif" style="display: none;"><img src="image/loading.gif">&nbsp;Uw event wordt aangemaakt een ogenblik geduld a.u.b.</div>
    </body>
</html>