<?php

class ReserverenPostValidatie {
    
    public function  ReserverenPostValidatie()
    {
        include_once 'backend/DTO/Bestelling.php';
        include_once 'backend/DTO/BestellingFactory.php';
        include_once 'backend/DTO/Reservering.php';
        include_once 'backend/DTO/ReserveringFactory.php';
    }

    public function ValideerStap1($postValues)
    {   
        //hebben we een voorstelling en is dat een nummer
        if (!isset($postValues['voorstelling']) || !is_numeric($postValues['voorstelling'])) {
            throw new Exception("Voorstelling is niet gezet, of het is geen nummer.");
        }
        
        //hebben we een modus
        if (!isset($postValues['modus'])) {
            throw new Exception("Modus is niet gezet.");
        }
        
        //valideer de modus waarde
        $this->ValideerModus($postValues['modus']);
        
        //kan deze modus voor deze voorstelling?
        if ($postValues['modus'] == "reserveren") $this->ValideerReserveringModus($postValues['voorstelling']);
        else $this->ValideerBestellingModus($postValues['voorstelling']);
        
        //geeft gevalideerde data terug
        $result = array();
        $result['Modus'] = $postValues['modus'];
        $result['Voorstelling'] = intval($postValues['voorstelling']);        
        return $result;
    }
    
    
    public function ValideerStap2($postWaardes)
    {
        //hebben we een voorstelling en is dat een nummer
        if (!isset($postWaardes['voorstelling']) || !is_numeric($postWaardes['voorstelling'])) {
            throw new Exception("Voorstelling is niet gezet, of het is geen nummer.");
        }
        
        //hebben we een modus
        if (!isset($postWaardes['modus'])) {
            throw new Exception("Modus is niet gezet.");
        }
        
        //hebben we geselecteerde stoelen?
        if (!isset($postWaardes['geselecteerdestoelen']) || strlen($postWaardes['geselecteerdestoelen'] == 0))
        {
            throw new Exception("Stoelen is niet gezet of heeft een lengte van 0.");
        }
        
        //valideer de modus waarde
        $this->ValideerModus($postWaardes['modus']);
        
        //kan deze modus voor deze voorstelling?
        if ($postWaardes['modus'] == "reserveren") $this->ValideerReserveringModus ($postWaardes['voorstelling']);
        else $this->ValideerBestellingModus($postWaardes['voorstelling']);
        
        //geef gevalideerde data terug
        $result = array();
        $result['Modus'] = $postWaardes['modus'];
        $result['Voorstelling'] = intval($postWaardes['voorstelling']);
        $result['GeslecteerdeStoelen'] = $postWaardes['geselecteerdestoelen'];
        return $result;
    }
    
    public function ValideerStap3($postWaardes)
    {
        //hebben we een voorstelling en is dat een nummer
        if (!isset($postWaardes['voorstelling']) || !is_numeric($postWaardes['voorstelling'])) {
            throw new Exception("Voorstelling is niet gezet, of het is geen nummer.");
        }
        
        //hebben we een modus
        if (!isset($postWaardes['modus'])) {
            throw new Exception("Modus is niet gezet.");
        }
        
        if (!isset($postWaardes['reference']) || strlen($postWaardes['reference']) == 0)
        {
            throw new Exception("Referentie is niet gezet.");
        }
        
        //valideer de modus waarde
        $this->ValideerModus($postWaardes['modus']);
        
        //kan deze modus voor deze voorstelling?
        if ($postWaardes['modus'] == "reserveren") $this->ValideerReserveringModus ($postWaardes['voorstelling']);
        else $this->ValideerBestellingModus($postWaardes['voorstelling']);
        
        //hebben we geselecteerde stoelen?
        if (!isset($postWaardes['geselecteerdestoelen']) || strlen($postWaardes['geselecteerdestoelen'] == 0))
        {
            throw new Exception("Stoelen is niet gezet of heeft een lengte van 0.");
        }
        
        //geef gevalideerde data terug
        $result = array();
        
        switch ($postWaardes['modus'])
        {
            case "reserveren":
                $this->ValideerReserveringModus($postWaardes['voorstelling']);
                $reserverenFactory = new ReserveringFactory();
                $result['Reservering'] = $reserverenFactory->BuildReserveringWithNewStatus($postWaardes);
                break;
            case "bestellen":
                $bestellingFactory = new BestellingFactory();
                $result['Bestelling'] = $bestellingFactory->BuildBestellingWithNewStatus($postWaardes);
                break;
        }
        
        $result['Modus'] = $postWaardes['modus'];
        $result['Voorstelling'] = intval($postWaardes['voorstelling']);
        $result['Referentie'] = $postWaardes['reference'];
        
        return $result;
    }


    private function ValideerReserveringModus($voorstelling)
    {
            //database en helpers erbij halen
            include_once 'backend/DBFunctions.php';
            include_once 'Helpers/DateHelper.php';
            
            $dbFunctions = new DBFunctions();
            
            //voorstelling info uit DB
            $voorstellingInfo = $dbFunctions->HaalVoorstellingOp($voorstelling, TRUE);

            //morgen en voorstelling tijd bepalen
            $filmTijd = strtotime($voorstellingInfo['Datum'] . " ". $voorstellingInfo['Tijd']);
            $morgen = DateHelper::Plus24uur();

            //valideren of de reservering is toegestaan voor deze voorstelling.
            if ($filmTijd < $morgen) {
               throw new Exception("Voor deze voorstelling kan niet meer worden gereserveerd. ". $voorstellingInfo["VoorstellingID"]);
            }
    }
    
    private function ValideerModus($modus)
    {
        //is het een bestaande modus
        if ($modus != "reserveren" && $modus != "bestellen") {
            throw new Exception("Modus is niet een van de toegestane waardes");
            
        }
    }

    private function ValideerBestellingModus($voorstelling) {
           //database en helpers erbij halen
            include_once 'backend/DBFunctions.php';
            include_once 'Helpers/DateHelper.php';
            
            $dbFunctions = new DBFunctions();
            
            //voorstelling info uit DB
            $voorstellingInfo = $dbFunctions->HaalVoorstellingOp($voorstelling, TRUE);

            //morgen en voorstelling tijd bepalen
            $filmTijd = strtotime($voorstellingInfo['Datum'] . " ". $voorstellingInfo['Tijd']);

            //valideren of de reservering is toegestaan voor deze voorstelling.
            if ($filmTijd < time()) {
               throw new Exception("Voor deze voorstelling kan niet meer worden besteld. ". $voorstellingInfo["VoorstellingID"]);
            }
        
    }
}

?>
