<?php

class BedanktGetValidatie {
   
    public function BedanktGetValidatie()
    {
        include_once 'backend/Bestellingen.php';
        include_once 'backend/Reserveringen.php';
        include_once 'backend/DBFunctions.php';
    }   
         
    
    public function Valideer($getWaardes)
    {   
        if (!isset($getWaardes['modus'])) {
            throw new Exception("Modus is niet gezet.");
        }
        
        if (!isset($getWaardes['referentie'])) {
            throw new Exception("Referentie is niet gezet.");
        }
        
        if (!isset($getWaardes['voorstelling'])) {
            throw new Exception("Voorstelling is niet gezet");
        }
        
        $this->ValideerModus($getWaardes['modus']);
        
        switch ($getWaardes['modus']) {
            case "bestellen":
                $bestellingen = new Bestellingen();
                if(!$bestellingen->BestaatKenmerk($getWaardes['referentie']))
                {
                    throw new Exception ("Dit is geen bestaande bestelling.");
                }
                break;

            case "reserveren":
                $reserveringen = new Reserveringen();
                if(!$reserveringen->BestaatReservering($getWaardes['referentie']))
                {
                    throw new Exception("Dit is geen bestaande reservering.");
                }
                break;
        }
        
        $result= array();
        $result['Modus'] = $getWaardes['modus'];
        
        $result['Referentie']= $getWaardes['referentie'];
         
        $dbFunctions = new DBFunctions();
        $result['VoorstellingData'] = $dbFunctions->FilmInfoVanVoorstelling(intval($getWaardes['voorstelling']));
        
        return $result;
    }
    
    private function ValideerModus($modus)
    {
        //is het een bestaande modus
        if ($modus != "reserveren" && $modus != "bestellen") {
            throw new Exception("Modus is niet een van de toegestane waardes");
            
        }
    }
    
}

?>
