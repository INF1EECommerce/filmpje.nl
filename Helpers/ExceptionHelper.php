<?php
class ExceptionHelper {
static function exception_handler($exception) {
    if (headers_sent()) {
       echo "Er is een fout opgetreden tijden het verwerken van uw verzoek.
           Onze excuses voor het ongemak. Bericht: ".$exception->GetMessage(); 
    }
    else
    {
    header("HTTP/1.1 500 Internal Server Error");
    require_once '500.php';
    }
}

static function exception_handler_icepayframe($exception) {
    if (headers_sent()) {
       echo "Er is een fout opgetreden tijden het verwerken van uw verzoek.
           Onze excuses voor het ongemak. Bericht: ".$exception->GetMessage(); 
    }
    else
    {
    header("HTTP/1.1 500 Internal Server Error");
    require_once 'betaalerror.php';
    }
}
}
?>
