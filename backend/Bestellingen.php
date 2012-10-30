<?php

class Bestellingen {

    var $connection;

    public function Bestellingen() {
        require_once(dirname(__FILE__) . '/DBConnection.php');
        require_once '/var/www/filmpje.nl/Helpers/ReferenceGenerator.php';
        $this->connection = new DBConnection();
    }
    
    public function HaalBestellingOp($kenmerk, $closeConnection)
    {
      if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk kan niet leeg zijn");
      }
        
      $this->connection->dbConnect();   
      
      $query = mysql_query("
      SELECT bestellingen.Voornaam, bestellingen.Adres, bestellingen.Postcode, bestellingen.Plaats, bestellingen.Telefoonnummer, bestellingen.Achternaam, bestellingen.Email, bestellingen.Kenmerk, stoelen.Nummer AS StoelNummer, stoelen.StoelID, films.Naam AS FilmNaam, stoeltypes.Naam AS StoelType, stoeltypes.Prijs AS StoelPrijs, rijen.Nummer AS RijNummer, voorstellingen.Datum AS VoorstellingDatum, voorstellingen.Tijd AS VoorstellingTijd, zalen.Naam AS ZaalNaam
          FROM filmpje.bestellingen 
		  INNER JOIN voorstellingen on voorstellingen.VoorstellingID = bestellingen.VoorstellingID
			INNER JOIN zalen on zalen.ZaalID = voorstellingen.ZaalID
			INNER JOIN films on films.FilmID = voorstellingen.FilmID
          INNER JOIN bestellingstoelen on bestellingstoelen.BestellingID = bestellingen.BestellingID
		  INNER JOIN stoelen on stoelen.StoelID = bestellingstoelen.StoelID 
		  INNER JOIN rijen on rijen.RijID = stoelen.RijID
		   INNER JOIN stoeltypes on stoeltypes.StoelTypeID = stoelen.StoelTypeID
          WHERE bestellingen.Kenmerk = '" . $kenmerk . "'");
      
      if (!$query) {
          throw new Exception("Er is een fout opgetreden bij het ophalen van de bestelling. ".$kenmerk);
      }
       
       $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }
        
        if($closeConnection){
        $this->connection->dbClose();
        }
        return $result;
    }
    public function BestaatKenmerk($kenmerk, $closeConnection)
    {
        if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk kan niet leeg zijn");
        }
        
       $this->connection->dbConnect();
     
        $query = mysql_query("SELECT BestellingID
          FROM filmpje.bestellingen 
          WHERE Kenmerk = '" . $kenmerk . "'");
        
        if (!$query) {
            throw new Exception("Er is een fout opgetreden bij het ophalen van het kenmerk. ".$kenmerk);
        }
        
       $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }
        
        if($closeConnection){
        $this->connection->dbClose();
        }
        
        if (count($result) > 0) {
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function BestellingStatusIDForStatus($status, $closeConnection) {

        if (strlen($status) == 0) {
            throw new Exception("Status kan niet leeg zijn.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT  BestellingStatusID
          FROM bestellingstatussen 
          WHERE Naam = '" . $status . "'");
        
        if (!$query) {
            throw new Exception("Er is iets misgegaan bij het ophalen van de statusid. ".$status);
        }

        $result = mysql_fetch_array($query); 
        
        if ($closeConnection)
        {
        $this->connection->dbClose();
        }
        
        return $result['BestellingStatusID'];
    }
    
    public function UpdateBeschikbareStoelenBetaalProbleem($kenmerk, $closeConnection)
    {
        if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk is niet gezet.");
        }
        
        $this->connection->dbConnect();
        
        $query = mysql_query("SELECT VoorstellingID,  COUNT(*) AS AantalStoelen
          FROM bestellingen
          INNER JOIN bestellingstoelen on bestellingstoelen.BestellingID = bestellingen.BestellingID
          WHERE bestellingen.Kenmerk = '" . $kenmerk . "'");
        
        if (!$query) {
            throw new Exception("Er is iets mis gegeaan bij het updaten van de beschikbare stoelen. ".$kenmerk);
        }

        $result = mysql_fetch_array($query);

        $this->UpdateBeschikbareStoelen($result['VoorstellingID'],$result['AantalStoelen'] , '+', FALSE);
        
        if ($closeConnection)
        {
        $this->connection->dbClose();
        }
    } 
    public function UpdateBeschikbareStoelen($voorstelling, $aantalstoelen, $plusmin, $closeConnection)
    {
       
        if (!is_numeric($voorstelling) || !is_numeric($aantalstoelen) || strlen($plusmin) != 1) {
            throw new Exception("Parameters zijn niet juist gezet om de beschikbare stoelen te updaten.");
        }
        
        $this -> connection -> dbConnect();
              
        $query = mysql_query("UPDATE voorstellingen
          SET voorstellingen.BeschikbareStoelen = voorstellingen.BeschikbareStoelen ". $plusmin . " " . $aantalstoelen ."
          WHERE voorstellingen.VoorstellingID = '" . $voorstelling . "'");
        
        if (!$query) {
            throw new Exception("Er is is mis gegaan bij het uodaten van de beschikbare stoelebn.");
        }
       
        if ($closeConnection) {
            $this->connection->dbClose();
        }
    }
    public function MaakBestellingAan(Bestelling $bestelling, $closeConnection) {
        
        //kijk of we een bestelling binnen hebben gekregen.
        if (!isset($bestelling)) {
            throw new Exception("Bestelling is niet gezet.");
        }
        
        if ($this->BestaatKenmerk($bestelling->kenmerk, TRUE)) {
            return;
        }
       
        //Connectie openen.
        $this->connection->dbConnect();
        
        //bestelling record wegschrijven in de database.
        $this->SlaBestellingOp($bestelling, FALSE);
        
        //gegenereerd bestelling id ophalen voor deze bestelling
        $bestellingID = $this->BestellingIDVoorkenmerk($bestelling->kenmerk, FALSE);
        
        //sla de stoelen bij de bestelling op en geef het aantal terug.
        $stoelenCount = $this->SlaBestellingStoelenOp($bestelling->stoelen, $bestellingID, FALSE);
        
        //update de beschikbare stoelen in de voorstellingen tabel.
        $this->UpdateBeschikbareStoelen($bestelling->voorstellingID, $stoelenCount, '-', FALSE);
        
        if ($closeConnection)
        {
        $this->connection->dbClose();
        }
    }
    
    private function SlaBestellingStoelenOp($stoelen, $bestellingID, $closeConnection)
    {
        if (strlen($stoelen) == 0 || !is_numeric($bestellingID)) {
            throw new Exception("Parameters zijn niet goed gezet voor het opslaan van bestelling stoelen.");
        }
        
        $this->connection->dbConnect();
        
        $stoelen = explode(",", $stoelen);

        foreach ($stoelen as $stoel) {

        $sql = "INSERT INTO filmpje.bestellingstoelen (BestellingID, StoelID)
        VALUES
        ('$bestellingID','$stoel')";

            if (!mysql_query($sql, $this->connection->connection)) {
                throw new Exception("Er gig iets mis met het opslaan van de bestlling stoelen.");
            }
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return count($stoelen);
    } 
    private function SlaBestellingOp(Bestelling $bestelling, $closeConnection)
    {
        if (!isset($bestelling)) {
            throw new Exception("Bestelling is niet gezet.");
        }
        
        $this->connection->dbConnect();
        
        mysql_select_db("my_db", $this->connection->connection);

        $sql = "INSERT INTO filmpje.bestellingen (VoorstellingID, TotaalPrijs, BestellingStatusID, Voornaam, Achternaam, Adres, Postcode, Email, Telefoonnummer, Bank, BankNummer, Kenmerk, Plaats)
        VALUES
        ('$bestelling->voorstellingID','$bestelling->totaalPrijs','$bestelling->BestellingStatus', '$bestelling->voornaam', '$bestelling->achternaam', '$bestelling->adres', '$bestelling->postcode', '$bestelling->email', '$bestelling->telefoonnummer', '$bestelling->bank', '$bestelling->banknummer', '$bestelling->kenmerk', '$bestelling->plaats')";

        if (!mysql_query($sql, $this->connection->connection)) {
            throw new Exception("Er ging iets mis bij het opslaan van de bestelling in de database.");
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
    }    
    private function BestellingIDVoorkenmerk($kenmerk, $closeConnection)
    {
        if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk is niet gezet.");
        }
        
        $this->connection->dbConnect();
        
        $query = mysql_query("SELECT MAX(BestellingID) AS BestellingID
          FROM filmpje.bestellingen 
          WHERE Kenmerk = '" .$kenmerk. "'");

        if (!$query) {
            throw new Exception("Er is iets mis gegaan bij het ophalen van het bestellingid. ".$kenmerk);  
        } 
        
       $result = mysql_fetch_array($query);

        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return  $result['BestellingID'];
        
    }
    public function BestellingStatusVoorID($kenmerk, $closeConnection)
    {
     
        if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk kan niet leeg zijn.");
        } 
        
     $this->connection->dbConnect();
     
        $query = mysql_query("SELECT bestellingstatussen.Naam AS BestellingStatus
          FROM filmpje.bestellingen 
          INNER JOIN bestellingstatussen on bestellingstatussen.BestellingStatusID = bestellingen.BestellingStatusID
          WHERE Kenmerk = '" . $id . "'");
        
        if (!$query) {
            throw new Exception("Er is iets mis gegaan bij ophalen van de status voor id. ".$id);
        } 

       $result = mysql_fetch_array($query);

       if ($closeConnection) {
       $this->connection->dbClose(); 
       }
       
        return $result['BestellingStatus'];
    }    
    public function SlaStatusOp($status, $kenmerk, $closeConnection)
    {
        if (strlen($status) == 0 || strlen($kenmerk) == 0) {
            throw new Exception("Parameters voor het opslaan van de status niet juist gezet.");
        }
       
       $statusid = 0;

       switch ($status) {
           case "OPEN":
               $statusid = $this->BestellingStatusIDForStatus("Open");
               
               break;
           case "ERR":
               $statusid = $this->BestellingStatusIDForStatus("Mislukt");
               
               break;
           
           case "OK":
               $statusid = $this->BestellingStatusIDForStatus("Betaald");
               break;
               
       }
        
        
       $this->connection->dbConnect();
     
        $query = mysql_query("UPDATE bestellingen
          SET bestellingen.BestellingStatusID = ". $statusid ."
          WHERE Kenmerk = '" . $kenmerk . "'");
        
        if (!$query) {
            throw new Exception ("Er is iets mis gegaan bij het opslaan van de nieuwe bestellingstatus.");
        }
        
        if ($closeConnection) {
        $this->connection->dbClose();
        }
    }

}

?>
