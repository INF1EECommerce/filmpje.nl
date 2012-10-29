<?php

class SpecialGetValidatie {

    public function SpecialGetValidatie()
    {
        include_once 'backend/DBFunctions.php';
    }
    
    public function Valideer($getWaardes)
    {
        if (!isset($getWaardes['SpecialID']) || !is_numeric($getWaardes['SpecialID'])) {
            throw new Exception("SpecialID is niet gezet of is geen nummer.");
        }
        
        $dbFunctions = new DBFunctions();
        
        if (!$dbFunctions->BestaatSpecial(intval($getWaardes['SpecialID']), TRUE)) {
            throw new Exception("Deze special komt niet voor in de database.");
        }
        
        $result = array();
        $result['SpecialID'] = intval($getWaardes['SpecialID']);
        $result['SpecialInfo'] = $dbFunctions->HaalSpecialOp(intval($getWaardes['SpecialID']));
        
        
        return $result;
    }
    
}

?>
