<?php
class ReserveringAnnulerenValidatie {
 
    public function Valideer($reservering)
    {
        if (!isset($reservering)) {
            throw new Exception("Reservering is niet gezet.");
        }
        
        $result = array(
          "ok" => TRUE,
          "reden" => ""
        );

        //niet meer dan twee uur in de toekomst.
        
        $voorstellingTijd = strtotime($reservering['datum']." ".$reservering['tijd']);
        
        if ($voorstellingTijd < time()+(120*60))
        {
            $result["ok"] = FALSE;
            $result["reden"] = "Uw reservering kan niet meer geannuleerd worden omdat de voorstelling binnen twee uur begint.";
        }
        
        //niet al opgehaald en niet reeds geannuleerd
        if ($reservering['ReserveringStatusID'] == 2) {
            $result["ok"] = FALSE;
            $result["reden"] = "Uw reservering kan niet meer geannuleerd worden omdat deze reeds is opgehaald.";
        }
        
        if ($reservering['ReserveringStatusID'] == 3) {
            $result["ok"] = FALSE;
            $result["reden"] = "Uw reservering kan niet meer geannuleerd worden omdat deze reeds is geannuleerd.";
        }
        
        return $result;
    }
    
}

?>
