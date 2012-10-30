<?php

class ContactPostValidatie {

    public function Valideer($postWaardes)
    {
        session_start();
        
        if (!isset($_SESSION['captcha']) || !isset($postWaardes['captcha'])) {
            throw new Exception("De captcha is niet gezet.");
        }
    
        $result = array();
        $result['Formulier'] = $postWaardes;
        
        if ($_SESSION['captcha'] != $postWaardes['captcha']) {
            $result['Captcha'] = FALSE;
        }
        else 
        {
            $result['Captcha'] = TRUE;
        }

        return $result;
        
    }
    
}

?>
