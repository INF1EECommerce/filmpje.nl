<?php

class SpecialGetValidatie {

    public function SpecialGetValidatie()
    {
        include_once 'backend/Specials.php';
    }
    
    public function Valideer($getWaardes)
    {
        if (!isset($getWaardes['SpecialID']) || !is_numeric($getWaardes['SpecialID'])) {
            throw new Exception("SpecialID is niet gezet of is geen nummer.");
        }
        
        $specials = new Specials();
        
        if (!$specials->BestaatSpecial(intval($getWaardes['SpecialID']), TRUE)) {
            throw new Exception("Deze special komt niet voor in de database.");
        }
        
        $result = array();
        $result['SpecialID'] = intval($getWaardes['SpecialID']);
        $result['SpecialInfo'] = $specials->HaalSpecialOp(intval($getWaardes['SpecialID']), TRUE);
        
        
        return $result;
    }
    
}

?>
