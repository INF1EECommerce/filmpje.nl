<?php

class Bestellingen {

    var $connection;

    public function Bestellingen() {
        require_once(dirname(__FILE__) . '/DBConnection.php');
        require_once '/var/www/filmpje.nl/Helpers/ReferenceGenerator.php';
        $this->connection = new DBConnection();
    }
    
    public function HaalBestellingOp($kenmerk)
    {
         $this->connection->dbConnect();   
        $idQuery = mysql_query("
      SELECT bestellingen.Voornaam, bestellingen.Adres, bestellingen.Postcode, bestellingen.Plaats, bestellingen.Telefoonnummer, bestellingen.Achternaam, bestellingen.Email, bestellingen.Kenmerk, stoelen.Nummer AS StoelNummer, stoelen.StoelID, films.Naam AS FilmNaam, stoeltypes.Naam AS StoelType, stoeltypes.Prijs AS StoelPrijs, rijen.Nummer AS RijNummer, voorstellingen.Datum AS VoorstellingDatum, voorstellingen.Tijd AS VoorstellingTijd, zalen.Naam AS ZaalNaam
          FROM filmpje.bestellingen 
		  INNER JOIN voorstellingen on voorstellingen.VoorstellingID = bestellingen.VoorstellingID
			INNER JOIN zalen on zalen.ZaalID = voorstellingen.ZaalID
			INNER JOIN films on films.FilmID = voorstellingen.FilmID
          INNER JOIN bestellingstoelen on bestellingstoelen.BestellingID = bestellingen.BestellingID
		  INNER JOIN stoelen on stoelen.StoelID = bestellingstoelen.StoelID 
		  INNER JOIN rijen on rijen.RijID = stoelen.RijID
		   INNER JOIN stoeltypes on stoeltypes.StoelTypeID = stoelen.StoelTypeID
          WHERE bestellingen.Kenmerk = '" . $kenmerk . "'") or die(mysql_error());
        
       
       $result = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $result[] = $row;
        }
        $this->connection->dbClose();
        
        return $result;
    }
    
    public function BestaatKenmerk($kenmerk)
    {
         $this->connection->dbConnect();
     
        $idQuery = mysql_query("SELECT BestellingID
          FROM filmpje.bestellingen 
          WHERE Kenmerk = '" . $kenmerk . "'") or die(mysql_error());
        
       
       $result = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $result[] = $row;
        }
        $this->connection->dbClose();
        
        if (count($result) > 0) {
            return true;
        }
        else 
        {
            return false;
        }
    }
    
    public function UpdateKenmerk($kenmerk)
    {
        $referenceGenerator = new ReferenceGenerator();
        $newKenmerk = $referenceGenerator ->Genereer();
        
       $this->connection->dbConnect();
     
       
        mysql_query("UPDATE bestellingen
          SET bestellingen.Kenmerk = ". $newKenmerk ."
          WHERE Kenmerk = '" . $kenmerk . "'") or die(mysql_error());
        
        $this->connection->dbClose();      
        
        return $newKenmerk;
    }

    public function BestellingStatusIDForStatus($status) {

        if (!isset($status)) {
            throw new Exception("status kan niet leeg zijn.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT  BestellingStatusID
          FROM bestellingstatussen 
          WHERE Naam = '" . $status . "'") or die(mysql_error());
        $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }
        $this->connection->dbClose();
        return $result[0]['BestellingStatusID'];
    }
    
    public function UpdateBeschikbareStoelenBetaalProbleem($kenmerk)
    {
        $this->connection->dbConnect();
        
        $query = mysql_query("SELECT VoorstellingID,  COUNT(*) AS AantalStoelen
          FROM bestellingen
          INNER JOIN bestellingstoelen on bestellingstoelen.BestellingID = bestellingen.BestellingID
          WHERE bestellingen.Kenmerk = '" . $kenmerk . "'") or die(mysql_error());
        $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }
        
        $this->UpdateBeschikbareStoelen($result[0]['VoorstellingID'],$result[0]['AantalStoelen'] , '+', FALSE);
        
        $this->connection->dbClose();
    }
    
    public function UpdateBeschikbareStoelen($voorstelling, $aantalstoelen, $plusmin, $closeConnection)
    {
       $this -> connection -> dbConnect();
              
        mysql_query("UPDATE voorstellingen
          SET voorstellingen.BeschikbareStoelen = voorstellingen.BeschikbareStoelen ". $plusmin . " " . $aantalstoelen ."
          WHERE voorstellingen.VoorstellingID = '" . $voorstelling . "'") or die(mysql_error());
       
        if ($closeConnection) {
            $this->connection->dbClose();
        }
    }
    public function MaakBestellingAan(Bestelling $bestelling) {
        
        //kijk of we een bestelling binnen hebben gekregen.
        if (!isset($bestelling)) {
            throw new Exception("Bestelling is NULL, error.");
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

        $this->connection->dbClose();
    }
    
    
    private function SlaBestellingStoelenOp($stoelen, $bestellingID, $closeConnection)
    {
        $this->connection->dbConnect();
        
        $stoelen = explode(",", $stoelen);

        foreach ($stoelen as $stoel) {

        $sql = "INSERT INTO filmpje.bestellingstoelen (BestellingID, StoelID)
        VALUES
        ('$bestellingID','$stoel')";

            if (!mysql_query($sql, $this->connection->connection)) {
                die('Error: ' . mysql_error());
            }
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return count($stoelen);
    }
    
    
    private function SlaBestellingOp(Bestelling $bestelling, $closeConnection)
    {
        $this->connection->dbConnect();
        
        mysql_select_db("my_db", $this->connection->connection);

        $sql = "INSERT INTO filmpje.bestellingen (VoorstellingID, TotaalPrijs, BestellingStatusID, Voornaam, Achternaam, Adres, Postcode, Email, Telefoonnummer, Bank, BankNummer, Kenmerk, Plaats)
        VALUES
        ('$bestelling->voorstellingID','$bestelling->totaalPrijs','$bestelling->BestellingStatus', '$bestelling->voornaam', '$bestelling->achternaam', '$bestelling->adres', '$bestelling->postcode', '$bestelling->email', '$bestelling->telefoonnummer', '$bestelling->bank', '$bestelling->banknummer', '$bestelling->kenmerk', '$bestelling->plaats')";

        if (!mysql_query($sql, $this->connection->connection)) {
            die('Error: ' . mysql_error());
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
    }
    
    
    private function BestellingIDVoorkenmerk($kenmerk, $closeConnection)
    {
        $this->connection->dbConnect();
        
        $idQuery = mysql_query("SELECT MAX(BestellingID) AS BestellingID
          FROM filmpje.bestellingen 
          WHERE Kenmerk = '" .$kenmerk. "'") or die(mysql_error());
        $result = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $result[] = $row;
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return  $result[0]['BestellingID'];
        
    }




    public function BestellingStatusVoorID($id)
    {
     $this->connection->dbConnect();
     
        $idQuery = mysql_query("SELECT bestellingstatussen.Naam AS BestellingStatus
          FROM filmpje.bestellingen 
          INNER JOIN bestellingstatussen on bestellingstatussen.BestellingStatusID = bestellingen.BestellingStatusID
          WHERE Kenmerk = '" . $id . "'") or die(mysql_error());
        
       
       $result = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $result[] = $row;
        }
        $this->connection->dbClose();
        return $result[0]['BestellingStatus'];
    }
    
    public function SlaStatusOp($status, $kenmerk)
    {
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
     
        mysql_query("UPDATE bestellingen
          SET bestellingen.BestellingStatusID = ". $statusid ."
          WHERE Kenmerk = '" . $kenmerk . "'") or die(mysql_error());
        
        $this->connection->dbClose();      
    }

}

?>
