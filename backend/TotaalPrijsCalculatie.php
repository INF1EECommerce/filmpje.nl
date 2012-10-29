<?php


class TotaalPrijsCalculatie {
   
    public static function Calculeer($stoelen)
    {
        require_once 'backend/DBFunctions.php';
        
        $dbFunctions = new DBFunctions();
        $stoelenInfo = $dbFunctions->StoelInfo($stoelen);
        
        $result = 0;
        
        foreach ($stoelenInfo as $stoel) {
            $result += $stoel['StoelPrijs'];
        }
        
        return $result;
        
    }
    
}

?>
