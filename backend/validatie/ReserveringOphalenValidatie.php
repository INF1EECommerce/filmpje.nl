<?php

class ReserveringOphalenValidatie {
    
    var $connection;
    
    public function ReserveringOphalenValidatie()
    {
        require_once('/var/www/filmpje.nl/backend/DBConnection.php');
        require_once('/var/www/filmpje.nl/backend/Reserveringen.php');
        
        $this->connection = new DBConnection();
    }
    
    public function Valideer($reservering, $closeConnection)
    {
        if (!isset($reservering)) {
            throw new Exception("Reservering is niet gezet.");
        }

        //databse connectie aanmaken
        $this->connection->dbConnect();
        
        //reserveringen erbij halen
        $reserveringen = new Reserveringen();
        
       //standaard waarde voor het validatie object.
        $result = array(
            "ok" => TRUE,
            "reden" => ""
        );
        
        //kijk of er stoelen voor deze reservering verkocht zijn
        // haal reservering stoelen op.
        $stoelenstring = $reserveringen->HaalReserveringStoelenOp($reservering['reserveringID'], $closeConnection);
        
        //kijk of er bestelde stoelen zijn voor de stoelenstring hierboven
        $besteldeStoelenCount = $reserveringen->BesteldeStoelenCountVoorReserveringStoelen($stoelenstring, $reservering['VoorstellingID'], $closeConnection);
        
        //geen verkochte stoelen voor reservering (kan alleen binnen 30 minuten voor de voorstellin)
        if ($besteldeStoelenCount > 0) {
            $result["ok"] = FALSE;
            $result["reden"] = "Reservering kan niet worden opgehaald. Er zijn reeds stoelen voor deze reserving verkocht. ";
        }
        
        //niet reeds opgehaald
        if ($reservering['ReserveringStatusID'] == 2) {
            $result["ok"] = FALSE;
            $result["reden"] = "Reservering kan niet worden opgehaald. Reservering is reeds opgehaald door de klant. ";
        }
        
        //niet geannuleerd door de klant
       if ($reservering['ReserveringStatusID'] == 3) {
            $result["ok"] = FALSE;
            $result["reden"] = "Reservering kan niet worden opgehaald. Reservering is geannuleerd door de klant.";
        }

        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return $result;
    }
    
}

?>
