<?php
include_once 'Facebook/FilmpjeFacebook.php';
$ff = new FilmpjeFacebook();

try
{
$eventid = $_GET['eid'];
$user = $_GET['fbuser'];
$voorstelling = $_GET['voorstelling'];
} catch (Exception $ex) { header("Location: http://chivan.com/filmpje.nl/FacebookError.php"); } 

if (isset($_GET['error_reason']) && $_GET['error_reason'] == "user_denied") {
    header("Location: http://chivan.com/filmpje.nl/FacebookError.php?melding=afgewezen&voorstelling=" . $voorstelling);
    die;
}

if ($ff->IsUserLoggingIn()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
        if (isset($_POST['vrienden'])) {    
        $vrienden = $_POST['vrienden'];
        if (count($vrienden) > 0) {
        $ff->AddAttendees($eventid, implode(",", $vrienden));
        }
        }
        header("Location: FacebookBedankt.php");
        }
        catch (Exception $ex)
        { header("Location: http://chivan.com/filmpje.nl/FacebookError.php"); }
    }
    else
    {
        try {
        $friends = $ff->GetFriendList($user);
        } catch (Exception $ex)
        { header("Location: http://chivan.com/filmpje.nl/FacebookError.php"); }
    }
}
 else {
    header("Location: ".$ff->GetLoginURL("http://chivan.com/filmpje.nl/InviteFriends.php?eid=".$eventid."&fbuser=".$user));    
}
?>
<html>
    <head><title>Filmpje.nl - Facebook Event aanmaken</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="javascript/jquery.js" type="text/javascript"></script>
    <script src="javascript/Loading.js" type="text/javascript"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <p class="blockheader">Vrienden uitnodigen</p>
        <div id="PopupHeader">Selecteer a.u.b uw vrienden die u voor deze voorstelling uit wilt nodigen. </div>
        <div id="PopupFriendList">
        <form id="PopUpForm" action="" method="POST">
        <table>
            <thead>
            <th>Uitnodigen</th><th>Naam</th>
            </thead>    
        <?php 
        foreach ($friends as $friend) {
        ?>
            <tr><td><input type="checkbox" name="vrienden[]" value="<?php echo $friend['uid']; ?>"></td><td><?php echo $friend['name'] ?></td></tr>   
        <?php    
        }
        ?>    
        </table>   
        <input style="margin-left: 0px;" type="submit" name="submit" value="Uitnodigen">
         <div id="loadinggif" style="display: none; margin-top: 0px;"><img src="image/loading.gif">&nbsp;Uitnodigingen worden aangemaakt een ogenblik geduld a.u.b.</div>
        </form>
        </div>
    </body>
</html>