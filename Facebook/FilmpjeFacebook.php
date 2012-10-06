 <?php 
 // Get these from http://developers.facebook.com 
include_once('/var/www/filmpje.nl/Facebook/src/facebook.php');

$facebook = new Facebook(array(
  'appId'  => '411293302259375',
  'secret' => '563594a56abb54799cb6914fd67808ff',
));

 $user = $facebook->getUser(); 

 if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}
 
 
 ?> 
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>php-sdk</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

      <h3>Test</h3>
    <?php 
 $token = $facebook->getAccessToken();   
    
$data = array("name"=>"Filmpje Test", 


           "access_token"=>$token, 


            "start_time"=>"2012-10-07 11:00:00", 


             "end_time"=>"2012-10-07 12:00:00", 


              "location"=>"Filmpje", 

             "description"=>"Met z'n allen naar de bioscoop." 
    );
 ?>  
          
          
    <?php $result = $facebook->api("/me/events","post",$data); 
    $facebookEventId = $result['id'];
    echo $facebookEventId;
    ?>
      
      
    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

    <h3>Public profile of Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
  </body>
</html>

 