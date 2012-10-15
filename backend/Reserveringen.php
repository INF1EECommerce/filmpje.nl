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
        //maak connectie met de database
        $this->connection->dbConnect();
        
        //haal reservering op uit de database
        $reservering = $this->HaalReserveringOpVoorKlantActie($kenmerk, FALSE);
        
        //valideer annuleren actie
        $ok = $this->ValideerReserveringAnnuleren($reservering);
        
        //stoppen als de reservering niet meer geannuleerd kan worden.
        if (!$ok["ok"]) {
            throw new Exception($ok["reden"]);
        }
        
        //zet de reservering status naar geannleerd
        $this->ZetReserveringStatusID($reservering['reserveringID'], 3, FALSE);
        
        //haal het aantal stoelen voor de reservering op
        $stoelencount = $this->StoelenCountVoorReservering($reservering, FALSE);

        //update de beschikbare stoelen voor de voorstelling
        $this->UpdateBeschikbareStoelen($reservering['VoorstellingID'], $stoelencount, "+", FALSE);
        
        //sluit de connectie naar de database.
        $this->connection->dbClose();

    }
    
    private function ZetReserveringStatusID($reserveringID, $statusID, $closeConnection)
    {
        $this->connection->dbConnect();
        
        $sql = "UPDATE filmpje.reserveringen SET ReserveringStatusID = ".$statusID."
           WHERE ReserveringID = ".$reserveringID;
        
        if (!mysql_query($sql, $this->connection->connection)) {
            die('Error: ' . mysql_error());
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
    }
    
    private function StoelenCountVoorReservering($reservering, $closeConnection)
    {
        $this->connection->dbConnect();
        
        $stoelen = mysql_query("SELECT COUNT(*) AS StoelenCount 
        FROM filmpje.reserveringstoelen
        WHERE ReserveringID = '" . $reservering['reserveringID'] ."'") or die(mysql_error());
        $resultstoelen = array();

        while ($row = mysql_fetch_array($stoelen)) {

            $resultstoelen[] = $row;
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return intval($resultstoelen[0]['StoelenCount']);
        
    }
    
    private function ValideerReserveringAnnuleren($reservering) {
        
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
    
    
    private function HaalReserveringOpVoorKlantActie($kenmerk, $closeConnection) {
        
        $this->connection->dbConnect();
        
        $idQuery = mysql_query("SELECT MAX(ReserveringID) AS ReserveringID, voorstellingen.Datum, voorstellingen.Tijd, voorstellingen.VoorstellingID, reserveringen.ReserveringStatusID 
        FROM filmpje.reserveringen 
        INNER JOIN voorstellingen on voorstellingen.VoorstellingID = reserveringen.VoorstellingID
        WHERE Kenmerk = '" . $kenmerk . "'") or die(mysql_error());
        $resultQuery = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $resultQuery[] = $row;
        }
        
        $result = array(
            "reserveringID" => $resultQuery[0]['ReserveringID'],
            "datum" => $resultQuery[0]['Datum'],
            "tijd" => $resultQuery[0]['Tijd'],
            "ReserveringStatusID" => $resultQuery[0]['ReserveringStatusID'],
            "VoorstellingID" => $resultQuery[0]['VoorstellingID']
        );
        
        return $result;
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
    }
    
    public function ReserveringOphalen($kenmerk)
    {
        //databse connectie aanmaken
        $this->connection->dbConnect();
        
        //haal reserving op
        $reservering = $this->HaalReserveringOpVoorKlantActie($kenmerk, FALSE);
        
        //valideer ophalen reservering door klant
        $ok = $this->ValideerOphalenReserveringKlant($reservering, FALSE);
            
        // gooi exceptie als ophalen niet gevalideerd is.
        if (!$ok["ok"]) {
            throw new Exception($ok["reden"]);
        }
        
        //zet de reservering status naar opgehaald.        
        $this->ZetReserveringStatusID($reservering['reserveringID'], 2, FALSE);
        
         //sluit de verbinding.
         $this->connection->dbClose();
        
    }
    
    
    public function ZendBevestigingsMail($kenmerk)
    {
        $sendMail = new SendEmail();
        $sendMail->ZendEmailForSuccesReservering($this->HaalReserveringOpVoorEmail($kenmerk));
    }
    
     private function HaalReserveringOpVoorEmail($kenmerk)
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
    
    
    private function ValideerOphalenReserveringKlant($reservering, $closeConnection)
    {
        //databse connectie aanmaken
        $this->connection->dbConnect();
        
       //standaard waarde voor het validatie object.
        $result = array(
            "ok" => TRUE,
            "reden" => ""
        );
        
        //kijk of er stoelen voor deze reservering verkocht zijn
        // haal reservering stoelen op.
        $stoelenstring = $this->HaalReserveringStoelenOp($reservering['reserveringID'], $closeConnection);
        
        //kijk of er bestelde stoelen zijn voor de stoelenstring hierboven
        $besteldeStoelenCount = $this->BesteldeStoelenCountVoorReserveringStoelen($stoelenstring, $reservering['VoorstellingID'], FALSE);
        
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
    
    private function BesteldeStoelenCountVoorReserveringStoelen($reserveringStoelen, $voorstellingID, $closeConnection)
    {
        //databse connectie aanmaken
        $this->connection->dbConnect();
        
        $vsquery = mysql_query("SELECT COUNT(bestellingstoelen.StoelID) AS StoelenCount 
        FROM filmpje.bestellingstoelen 
        INNER JOIN filmpje.bestellingen on bestellingen.BestellingID = bestellingstoelen.BestellingID AND bestellingen.BestellingStatusID = 3
        WHERE bestellingstoelen.StoelID IN ( " .$reserveringStoelen . ")  AND bestellingen.VoorstellingID = ".$voorstellingID) or die(mysql_error());
        
        $result = array();
        
          while ($row = mysql_fetch_array($vsquery)) {

            $result[] = $row;
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return $result[0]['StoelenCount'];
    }
    
    private function HaalReserveringStoelenOp($reserveringID, $closeConnection)
    {        
        //databse connectie aanmaken
        $this->connection->dbConnect();
        
        $gstoelenq = mysql_query("SELECT StoelID 
        FROM filmpje.reserveringstoelen 
        WHERE ReserveringID = '" . $reserveringID . "'") or die(mysql_error());
        
        $result2 = array();
        
          while ($row = mysql_fetch_array($gstoelenq)) {

            $result2[] = $row['StoelID'];
        }
        
        $stoelenstring = implode(",", $result2);
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return $stoelenstring;
    }
    
    
     public function MaakReserveringAan(Reservering $reservering) {
         
        //controleren of we een reservering hebben binnen gekregen
         if (!isset($reservering)) {
             throw new Exception("Het reservering object is NULL, error");
         } 
        
        //controleren of de reservering niet al bestaat.
        if ($this->BestaatReservering($reservering->kenmerk)) {
            return;
        }
        
        //connectie naar de database openen.
        $this->connection->dbConnect();
        
        //reservering record opslaan
        $this->SlaReservingOp($reservering, FALSE);

        //haal reserveringID op
        $reserveringID = $this->ReserveringIDvoorKenmerk($reservering->kenmerk, FALSE);
      
        //sla reservering stoelen op een krijg het aantal terug
        $stoelenCount = $this->SlaReserveringStoelenOp($reservering->stoelen, $reserveringID, FALSE);
        
        //update de beschikbare stoelen
        $this->UpdateBeschikbareStoelen($reservering->voorstellingID, $stoelenCount, '-', FALSE);

        //sluit de connectie
        $this->connection->dbClose();
        
        $this->ZendBevestigingsMail($reservering->kenmerk);
        
    }
    
    private function SlaReserveringStoelenOp($stoelenString, $reserveringID, $closeConnection) {
        
        $stoelen = explode(",", $stoelenString);

        foreach ($stoelen as $stoel) {

        $sql = "INSERT INTO filmpje.reserveringstoelen (ReserveringID, StoelID)
        VALUES
        ('$reserveringID','$stoel')";

            if (!mysql_query($sql, $this->connection->connection)) {
                die('Error: ' . mysql_error());
            }
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return count($stoelen);
    }
    
    private function ReserveringIDvoorKenmerk($kenmerk, $closeConnection) {
        
        $this->connection->dbConnect();
        
        $idQuery = mysql_query("SELECT MAX(ReserveringID) AS ReserveringID
          FROM filmpje.reserveringen 
          WHERE Kenmerk = '" . $kenmerk . "'") or die(mysql_error());
        $result = array();

        while ($row = mysql_fetch_array($idQuery)) {

            $result[] = $row;
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return $result[0]['ReserveringID'];
    }
    
    
    private function SlaReservingOp($reservering, $closeConnection) {
        
        $this->connection->dbConnect();
        
        $sql = "INSERT INTO filmpje.reserveringen (VoorstellingID, TotaalPrijs, ReserveringStatusID, Voornaam, Achternaam, Adres, Postcode, Email, Telefoonnummer, Kenmerk, Plaats)
        VALUES
        ('$reservering->voorstellingID','$reservering->totaalPrijs','$reservering->ReserveringStatus', '$reservering->voornaam', '$reservering->achternaam', '$reservering->adres', '$reservering->postcode', '$reservering->email', '$reservering->telefoonnummer', '$reservering->kenmerk', '$reservering->plaats')";

        if (!mysql_query($sql, $this->connection->connection)) {
            die('Error: ' . mysql_error());
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
    }




    public function UpdateBeschikbareStoelen($voorstelling, $aantalstoelen, $plusmin, $closeConnection)
    {
       $this -> connection -> dbConnect();
              
        mysql_query("UPDATE voorstellingen
          SET voorstellingen.BeschikbareStoelen = voorstellingen.BeschikbareStoelen ". $plusmin . " " . $aantalstoelen ."
          WHERE voorstellingen.VoorstellingID = '" . $voorstelling . "'") or die(mysql_error());
       
        if ($closeConnection) {
            $this -> connection -> dbClose();
        }
       
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
