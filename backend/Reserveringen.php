<?php
class Reserveringen {

    var $connection;

    public function Reserveringen() {
        require_once(dirname(__FILE__) . '/DBConnection.php');
        require_once '/var/www/filmpje.nl/Helpers/ReferenceGenerator.php';
        require_once '/var/www/filmpje.nl/backend/Mail/SendEmail.php';
        $this->connection = new DBConnection();
    }
    
    public function ReserveringAnnuleren($kenmerk)
    {
        $this->connection->dbConnect();
        
        $idQuery = mysql_query("SELECT MAX(ReserveringID) AS ReserveringID, voorstellingen.Datum, voorstellingen.Tijd, voorstellingen.VoorstellingID, reserveringen.ReserveringStatusID 
        FROM filmpje.reserveringen 
        INNER JOIN voorstellingen on voorstellingen.VoorstellingID = reserveringen.VoorstellingID
        WHERE Kenmerk = '" . $kenmerk . "'") or die(mysql_error());
        $result = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $result[] = $row;
        }
        
        $reserveringID = $result[0]['ReserveringID'];
        $datum = $result[0]['Datum'];
        $tijd = $result[0]['Tijd'];
        
        // niet minder dan 2 uur in de toekomst een reeds geannuleerde status
        if (strtotime($datum." ".$tijd) > time()+(120*60) && $result[0]['ReserveringStatusID'] != 3) {
        
        
         $stoelen = mysql_query("SELECT COUNT(*) AS StoelenCount 
        FROM filmpje.reserveringstoelen
        WHERE ReserveringID = '" . $reserveringID ."'") or die(mysql_error());
        $resultstoelen = array();

        while ($row = mysql_fetch_array($stoelen)) {

            $resultstoelen[] = $row;
        }
        
       $sql = "UPDATE filmpje.reserveringen SET ReserveringStatusID = 3
           WHERE ReserveringID = ".$reserveringID;
        
        if (!mysql_query($sql, $this->connection->connection)) {
            die('Error: ' . mysql_error());
        }
        
        $this->UpdateBeschikbareStoelen($result[0]['VoorstellingID'], $resultstoelen[0]['StoelenCount'], "+");
        $this->connection->dbClose();
        }
        else
        {
            $this->connection->dbClose();
            throw new Exception("Reservering kan niet meer geannuleerd worden.");
        }

    }
    
    public function ReserveringOphalen($kenmerk)
    {
        $this->connection->dbConnect();
        
        $idQuery = mysql_query("SELECT MAX(ReserveringID) AS ReserveringID, voorstellingen.Datum, voorstellingen.Tijd, voorstellingen.VoorstellingID, reserveringen.ReserveringStatusID 
        FROM filmpje.reserveringen 
        INNER JOIN voorstellingen on voorstellingen.VoorstellingID = reserveringen.VoorstellingID
        WHERE Kenmerk = '" . $kenmerk . "'") or die(mysql_error());
        $result = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $result[] = $row;
        }
        
        $reserveringID = $result[0]['ReserveringID'];
        $voorstellingID = $result[0]['VoorstellingID'];
        $reserveringStatus = $result[0]['ReserveringStatusID'];

        $gstoelenq = mysql_query("SELECT StoelID 
        FROM filmpje.reserveringstoelen 
        WHERE ReserveringID = '" . $reserveringID . "'") or die(mysql_error());
        $result2 = array();
        
          while ($row = mysql_fetch_array($gstoelenq)) {

            $result2[] = $row['StoelID'];
        }
        $stoelenstring = implode(",", $result2);
        
        $vsquery = mysql_query("SELECT COUNT(bestellingstoelen.StoelID) AS StoelenCount 
        FROM filmpje.bestellingstoelen 
        INNER JOIN filmpje.bestellingen on bestellingen.BestellingID = bestellingstoelen.BestellingID AND bestellingen.BestellingStatusID = 3
        WHERE bestellingstoelen.StoelID IN ( " .$stoelenstring . ")  AND bestellingen.VoorstellingID = ".$voorstellingID) or die(mysql_error());
        $result3 = array();
        
          while ($row = mysql_fetch_array($vsquery)) {

            $result3[] = $row;
        }
        
        if ($result3[0]['StoelenCount'] == 0 && $reserveringStatus != 2 && $reserveringStatus != 3 ) {
            
                  
       $sql = "UPDATE filmpje.reserveringen SET ReserveringStatusID = 2
           WHERE ReserveringID = ".$reserveringID;
        
        if (!mysql_query($sql, $this->connection->connection)) {
            die('Error: ' . mysql_error());
         }
            $this->connection->dbClose();
         }
         else 
         {
             $this->connection->dbClose();
             throw new Exception("Reservering kan niet meer worden afgehaald. Er zijn reeds gereserveerde stoelen verkocht. Of reservering is geannulleerd.");
         }
        
    }
    
    
    public function ZendBevestigingsMail($kenmerk)
    {
        $sendMail = new SendEmail();
        $sendMail->ZendEmailForSuccesReservering($this->HaalReserveringOp($kenmerk));
    }
    
     public function HaalReserveringOp($kenmerk)
    {
         $this->connection->dbConnect();   
        $idQuery = mysql_query("
      SELECT reserveringen.Voornaam, reserveringen.Adres, reserveringen.Postcode, reserveringen.Plaats, reserveringen.Telefoonnummer, reserveringen.Achternaam, reserveringen.Email, reserveringen.Kenmerk, stoelen.Nummer AS StoelNummer, stoelen.StoelID, films.Naam AS FilmNaam, stoeltypes.Naam AS StoelType, stoeltypes.Prijs AS StoelPrijs, rijen.Nummer AS RijNummer, voorstellingen.Datum AS VoorstellingDatum, voorstellingen.Tijd AS VoorstellingTijd, zalen.Naam AS ZaalNaam
          FROM filmpje.reserveringen 
		  INNER JOIN voorstellingen on voorstellingen.VoorstellingID = reserveringen.VoorstellingID
			INNER JOIN zalen on zalen.ZaalID = voorstellingen.ZaalID
			INNER JOIN films on films.FilmID = voorstellingen.FilmID
          INNER JOIN reserveringstoelen on reserveringstoelen.ReserveringID = reserveringen.ReserveringID
		  INNER JOIN stoelen on stoelen.StoelID = reserveringstoelen.StoelID 
		  INNER JOIN rijen on rijen.RijID = stoelen.RijID
		   INNER JOIN stoeltypes on stoeltypes.StoelTypeID = stoelen.StoelTypeID
          WHERE reserveringen.Kenmerk = '" . $kenmerk . "'") or die(mysql_error());
        
       
       $result = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $result[] = $row;
        }
        $this->connection->dbClose();
        
        return $result;
    }
    
    public function BestaatReservering($kenmerk)
    {
                 $this->connection->dbConnect();
     
        $idQuery = mysql_query("SELECT ReserveringID
          FROM filmpje.reserveringen 
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
    
    
     public function MaakReserveringAan(Reservering $reservering) {
        //TO DO: valideer object;
       
        if ($this->BestaatReservering($reservering->kenmerk)) {
            return;
        }
        $this->connection->dbConnect();
        
        $sql = "INSERT INTO filmpje.reserveringen (VoorstellingID, TotaalPrijs, ReserveringStatusID, Voornaam, Achternaam, Adres, Postcode, Email, Telefoonnummer, Kenmerk, Plaats)
        VALUES
        ('$reservering->voorstellingID','$reservering->totaalPrijs','$reservering->ReserveringStatus', '$reservering->voornaam', '$reservering->achternaam', '$reservering->adres', '$reservering->postcode', '$reservering->email', '$reservering->telefoonnummer', '$reservering->kenmerk', '$reservering->plaats')";

        if (!mysql_query($sql, $this->connection->connection)) {
            die('Error: ' . mysql_error());
        }


        $idQuery = mysql_query("SELECT MAX(ReserveringID) AS ReserveringID
          FROM filmpje.reserveringen 
          WHERE Kenmerk = '" . $reservering->kenmerk . "'") or die(mysql_error());
        $result = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $result[] = $row;
        }
        
        $reserveringID = $result[0]['ReserveringID'];
        $stoelen = explode(",", $reservering->stoelen);

        foreach ($stoelen as $stoel) {

        $sql = "INSERT INTO filmpje.reserveringstoelen (ReserveringID, StoelID)
        VALUES
        ('$reserveringID','$stoel')";

            if (!mysql_query($sql, $this->connection->connection)) {
                die('Error: ' . mysql_error());
            }
        }
        
        $this->UpdateBeschikbareStoelen($reservering->voorstellingID, count($stoelen), '-');

        $this->connection->dbClose();
        
        $this->ZendBevestigingsMail($reservering->kenmerk);
        
    }
    
        
    public function UpdateBeschikbareStoelen($voorstelling, $aantalstoelen, $plusmin)
    {
       $this -> connection -> dbConnect();
              
        mysql_query("UPDATE voorstellingen
          SET voorstellingen.BeschikbareStoelen = voorstellingen.BeschikbareStoelen ". $plusmin . " " . $aantalstoelen ."
          WHERE voorstellingen.VoorstellingID = '" . $voorstelling . "'") or die(mysql_error());
       
       $this -> connection -> dbClose();
    }
    
    public function ReserveringStatusIDForStatus($status)
    {

       if (!isset($status)) {
            throw new Exception("status kan niet leeg zijn.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT  ReserveringStatusID
          FROM reserveringstatussen 
          WHERE Naam = '" . $status . "'") or die(mysql_error());
        $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }
        $this->connection->dbClose();
        return $result[0]['ReserveringStatusID'];
    }
    
}
?>
