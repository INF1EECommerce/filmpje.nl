<?php

class FilmpjeFacebook {

    var $facebook;
    var $user;

    public function FilmpjeFacebook() {

        // Get these from http://developers.facebook.com 
        include_once('src/facebook.php');

        $this->facebook = new Facebook(array(
                    'appId' => '411293302259375',
                    'secret' => '563594a56abb54799cb6914fd67808ff',
                    'fileUpload' => true,
                    'cookie' => true
                ));
    }

    public function IsUserLoggingIn() {

        $this->user = $this->facebook->getUser();

        try {
            // Proceed knowing you have a logged in user who's authenticated.
            $user_profile = $this->facebook->api('/me');
            return true;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function GetLoginURL($reditectURL) {

        // Login or logout url will be needed depending on current user state.
        $loginUrl = $this->facebook->getLoginUrl(
                array(
                    "scope" => "create_event",
                    "display" => "popup",
                    "redirect_uri" => $reditectURL
                ));

        return $loginUrl;
    }

    public function GetLogoutUrl() {
        if ($this->user) {
            $logoutUrl = $this->facebook->getLogoutUrl();
            return $logoutUrl;
        } else {
            throw new Exception("The user is not set");
        }
    }

    public function CreateEvent($eventData) {
        if ($this->user) {
            $ret_obj = $this->facebook->api("/" . $this->user . "/events", 'POST', $eventData);
            return ($ret_obj);

//    array(
//                                    
//   'name' => "FilpjeTest",
//    'start_time' => '2012-10-07T19:00:00-0700',
//    'description' => "Test Desc",
//    'privacy_type' => "SECRET"
//    )        
        } else {
            throw new Exception("The user is not set");
        }
    }

    public function ParsePostDataPopup($postData) {
            $eventData = array(
                'name' => $postData['Naam'],
                'start_time' => $postData['Datum'] . "T" . $postData['Tijd'] . "+02:00",
                'description' => "Ik ga naar de voorstelling van " . $postData['Naam'] . " bij Filmpje. Wie gaat er mee? ",
                'privacy_type' => "SECRET",
                'location' => "West-Kruiskade 26, 3014 Rotterdam, Nederland",
            );
            $file = '/var/www/filmpje.nl/image/Covers/' . $postData['cover'];
            $eventData[basename($file)] = '@' . realpath($file);

            return $eventData;
    }

    public function AddAttendees($event, $users) {
        if ($this->user) {
            $ret_obj = $this->facebook->api("/" . $event . "/invited?users=" . $users, "POST");
            return $ret_obj;
        } else {
            throw new Exception("The user is not set");
        }
    }

    public function GetFriendList($user) {
        if ($this->user) {
            //$ret_obj = $this->facebook->api("/".$user."/friends");

            $query = "SELECT uid, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = " . $user . ") ORDER BY name";

            $params = array(
                'method' => 'fql.query',
                'query' => $query,
            );


            $ret_obj = $this->facebook->api($params);
            return $ret_obj;
        } else {
            throw new Exception("The user is not set");
        }
    }

}
?>  


