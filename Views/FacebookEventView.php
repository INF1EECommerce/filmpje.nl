<?php
class FacebookEventView
{
    var $faceBook;
    
    public function FacebookEventView()
    {
        include_once 'Facebook/FilmpjeFacebook.php';
        
        $this->faceBook = new FilmpjeFacebook();
    }
    
    public function Render($voorstelling)
    {
        $url="";
        if ($this->faceBook->IsUserLoggingIn()) {
          $url = "CreateEvent.php?voorstelling=".$voorstelling;
           
        }
        else
        { 
            $url = $this->faceBook->GetLoginUrl("http://chivan.com/filmpje.nl/CreateEvent.php?voorstelling=".$voorstelling);
        }
        
        echo("<div id=\"FacebookEventAanmaken\"><a href=\"".$url."\" id=\"EventAanmakenLink\"><img src=\"image/EventAanmaken.png\" alt=\"eventAanmaken\"></a></div>");
        
    }
    
}
?>
