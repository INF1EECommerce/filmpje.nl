<?php


class TotaalPrijsCalculatie {
   
    public static function Calculeer($stoelen)
    {
        //moet volledig pad zijn.
        require_once '/var/www/filmpje.nl/backend/Stoelen.php';
        
        $stoelenDB = new Stoelen();
        $stoelenInfo = $stoelenDB->StoelInfo($stoelen, TRUE);
        
        $result = 0;
        
        foreach ($stoelenInfo as $stoel) {
            $result += floatval($stoel['StoelPrijs']);
        }
        
        return floatval($result);
        
    }
    
}

?>
