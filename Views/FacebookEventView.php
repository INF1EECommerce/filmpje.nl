<?php

class FacebookEventView {

    var $facebook;

    public function FacebookEventView() {
        include_once 'Facebook/FilmpjeFacebook.php';

        $this->facebook = new FilmpjeFacebook();
    }

    public function Render($voorstelling) {
        $url = "";
        if ($this->facebook->IsUserLoggingIn()) {
            $url = "CreateEvent.php?voorstelling=" . $voorstelling;
        } else {
            $url = $this->facebook->GetLoginUrl("http://chivan.com/filmpje.nl/CreateEvent.php?voorstelling=" . $voorstelling);
        }

        echo("<div id=\"FacebookEventAanmaken\"><a href=\"" . $url . "\" id=\"EventAanmakenLink\"><img src=\"image/Facebook/EventAanmakenKlein.png\" alt=\"eventAanmaken\"></a></div>");
    }

}

?>
