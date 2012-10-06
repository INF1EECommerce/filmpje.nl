 <?php 
 // Get these from http://developers.facebook.com 
include_once('Facebook/src/facebook.php');

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
    if($user)
    {
        $
        
        $token = $facebook->getAccessToken();   
    
        $data = array("name"=>"Filmpje Test", 


           "access_token"=>$token, 


            "start_time"=>"2012-10-07 11:00:00", 


             "end_time"=>"2012-10-07 12:00:00", 


              "location"=>"Filmpje", 

             "description"=>"Met z'n allen naar de bioscoop." 
    );
        
       $result = $facebook->api("/me/events","post",$data); 
    $facebookEventId = $result['id'];
    echo $facebookEventId;
    }
 ?>  
          
  </body>
</html>

 