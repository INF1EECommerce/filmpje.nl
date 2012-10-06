<?php

class Bestellingen {

    var $connection;

    public function Bestellingen() {
        require_once(dirname(__FILE__) . '/DBConnection.php');
        require_once 'Helpers/ReferenceGenerator.php';
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

    public function MaakBestellingAan(Bestelling $bestelling) {
        //TO DO: valideer object;
        $this->connection->dbConnect();

        mysql_select_db("my_db", $this->connection->connection);

        $sql = "INSERT INTO filmpje.bestellingen (VoorstellingID, TotaalPrijs, BestellingStatusID, Voornaam, Achternaam, Adres, Postcode, Email, Telefoonnummer, Bank, BankNummer, Kenmerk, Plaats)
        VALUES
        ('$bestelling->voorstellingID','$bestelling->totaalPrijs','$bestelling->BestellingStatus', '$bestelling->voornaam', '$bestelling->achternaam', '$bestelling->adres', '$bestelling->postcode', '$bestelling->email', '$bestelling->telefoonnummer', '$bestelling->bank', '$bestelling->banknummer', '$bestelling->kenmerk', '$bestelling->plaats')";

        if (!mysql_query($sql, $this->connection->connection)) {
            die('Error: ' . mysql_error());
        }


        $idQuery = mysql_query("SELECT MAX(BestellingID) AS BestellingID
          FROM filmpje.bestellingen 
          WHERE Kenmerk = '" . $bestelling->kenmerk . "'") or die(mysql_error());
        $result = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $result[] = $row;
        }
        
        $bestellingID = $result[0]['BestellingID'];
        $stoelen = explode(",", $bestelling->stoelen);

        foreach ($stoelen as $stoel) {

        $sql = "INSERT INTO filmpje.bestellingstoelen (BestellingID, StoelID)
        VALUES
        ('$bestellingID','$stoel')";

            if (!mysql_query($sql, $this->connection->connection)) {
                die('Error: ' . mysql_error());
            }
        }

        $this->connection->dbClose();
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
