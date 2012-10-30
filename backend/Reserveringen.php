<?php
class Reserveringen {

    var $connection;

    public function Reserveringen() {
        require_once(dirname(__FILE__) . '/DBConnection.php');
        require_once '/var/www/filmpje.nl/Helpers/ReferenceGenerator.php';
        require_once '/var/www/filmpje.nl/backend/Mail/SendEmail.php';
        require_once '/var/www/filmpje.nl/backend/validatie/ReserveringAnnulerenValidatie.php';
        require_once '/var/www/filmpje.nl/backend/validatie/ReserveringOphalenValidatie.php';
        $this->connection = new DBConnection();
    }
    
    public function ReserveringAnnuleren($kenmerk, $closeConnection)
    {
        if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk is niet gezet.");
        }

        //maak connectie met de database
        $this->connection->dbConnect();
        
        //haal reservering op uit de database
        $reservering = $this->HaalReserveringOpVoorKlantActie($kenmerk, FALSE);
        
        //valideer annuleren actie
        $validatie = new ReserveringAnnulerenValidatie();
        $ok = $validatie->Valideer($reservering);
        
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
        if ($closeConnection)
        {
        $this->connection->dbClose();
        }
    }
    
    private function ZetReserveringStatusID($reservering, $status, $closeConnection)
    {
        if (!is_numeric($reservering) || !is_numeric($status)) {
            throw new Exception(" 1 of meer parameters voor het zetten van de reservering status zijn niet gezet.");
        }
        
        $this->connection->dbConnect();
        
        $sql = "UPDATE filmpje.reserveringen SET ReserveringStatusID = ".$status."
           WHERE ReserveringID = ".$reservering;
        
        if (!mysql_query($sql, $this->connection->connection)) {
            throw new Exception("Er ging iets mis bij het zetten van de reserveringstatusid voor reservering. ".$reservering);
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
    }
    
    private function StoelenCountVoorReservering($reservering, $closeConnection)
    {
        if (!isset($reservering)) {
            throw new Exception("Reservering is niet gezet.");
        }
        
        $this->connection->dbConnect();
        
        $query = mysql_query("SELECT COUNT(*) AS StoelenCount 
        FROM filmpje.reserveringstoelen
        WHERE ReserveringID = '" . $reservering['reserveringID'] ."'") or die(mysql_error());
        
        if (!$query) {
            throw new Exception("Er was een probleem tijdens het bepalen van het aantal stoelen voor reservering. ".$reservering);
        }
        
        $result = mysql_fetch_array($query);

        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return intval($result['StoelenCount']);
        
    }
    
    private function HaalReserveringOpVoorKlantActie($kenmerk, $closeConnection) {
        
        if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk is niet gezet.");
        }
        
        $this->connection->dbConnect();
        
        $query = mysql_query("SELECT MAX(ReserveringID) AS ReserveringID, voorstellingen.Datum, voorstellingen.Tijd, voorstellingen.VoorstellingID, reserveringen.ReserveringStatusID 
        FROM filmpje.reserveringen 
        INNER JOIN voorstellingen on voorstellingen.VoorstellingID = reserveringen.VoorstellingID
        WHERE Kenmerk = '" . $kenmerk . "'");
        
        if (!$query) {
            throw new Exception("Er ging iets mis tijdens het ophalen van de reservering voor klantactie. ".$kenmerk);
        }
        
        $result = mysql_fetch_array($query);
        
        $finalResult = array(
            "reserveringID" => $result['ReserveringID'],
            "datum" => $result['Datum'],
            "tijd" => $result['Tijd'],
            "ReserveringStatusID" => $result['ReserveringStatusID'],
            "VoorstellingID" => $result['VoorstellingID']
        );
        
        return $finalResult;
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
    }
    
    public function ReserveringOphalen($kenmerk, $closeConnection)
    {
        if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk is niet gezet.");
        }
        
        //databse connectie aanmaken
        $this->connection->dbConnect();
        
        //haal reserving op
        $reservering = $this->HaalReserveringOpVoorKlantActie($kenmerk, FALSE);
        
        //valideer ophalen reservering door klant
        $validatie =  new ReserveringOphalenValidatie();
        $ok = $validatie->Valideer($reservering, FALSE);
            
        // gooi exceptie als ophalen niet gevalideerd is.
        if (!$ok["ok"]) {
            throw new Exception($ok["reden"]);
        }
        
        //zet de reservering status naar opgehaald.        
        $this->ZetReserveringStatusID($reservering['reserveringID'], 2, FALSE);
        
         //sluit de verbinding.
         if ($closeConnection)
         {
         $this->connection->dbClose();
         }
    }
    
    
    public function ZendBevestigingsMail($kenmerk)
    {
        if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk is niet gezet.");
        }
        
        $sendMail = new SendEmail();
        $sendMail->ZendEmailForSuccesReservering($this->HaalReserveringOpVoorEmail($kenmerk, TRUE));
    }
    
     private function HaalReserveringOpVoorEmail($kenmerk, $closeConnection)
    {
         if (strlen($kenmerk) == 0) {
             throw new Exception("Kenmerk is niet gezet.");
         }
         
        $this->connection->dbConnect();   
        $query = mysql_query("
        SELECT reserveringen.Voornaam, reserveringen.Adres, reserveringen.Postcode, reserveringen.Plaats, reserveringen.Telefoonnummer, reserveringen.Achternaam, reserveringen.Email, reserveringen.Kenmerk, stoelen.Nummer AS StoelNummer, stoelen.StoelID, films.Naam AS FilmNaam, stoeltypes.Naam AS StoelType, stoeltypes.Prijs AS StoelPrijs, rijen.Nummer AS RijNummer, voorstellingen.Datum AS VoorstellingDatum, voorstellingen.Tijd AS VoorstellingTijd, zalen.Naam AS ZaalNaam
        FROM filmpje.reserveringen 
		  INNER JOIN voorstellingen on voorstellingen.VoorstellingID = reserveringen.VoorstellingID
			INNER JOIN zalen on zalen.ZaalID = voorstellingen.ZaalID
			INNER JOIN films on films.FilmID = voorstellingen.FilmID
          INNER JOIN reserveringstoelen on reserveringstoelen.ReserveringID = reserveringen.ReserveringID
		  INNER JOIN stoelen on stoelen.StoelID = reserveringstoelen.StoelID 
		  INNER JOIN rijen on rijen.RijID = stoelen.RijID
		   INNER JOIN stoeltypes on stoeltypes.StoelTypeID = stoelen.StoelTypeID
          WHERE reserveringen.Kenmerk = '" . $kenmerk . "'");
        
        
        if (!$query) {
            throw new Exception("Er ging is mis bij het ophalen van de reservering om te mailen. ".$kenmerk);
        }
        
       
       $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }
        
        if($closeConnection) {
        $this->connection->dbClose();
        }
        
        return $result;
    }
    
    public function BestaatReservering($kenmerk, $closeConnection)
    {
        if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk is niet gezet.");
        }
        
        $this->connection->dbConnect();
     
        $query = mysql_query("SELECT ReserveringID
          FROM filmpje.reserveringen 
          WHERE Kenmerk = '" . $kenmerk . "'");
        
       
        if (!$query) {
            throw new Exception("Er ging iets mis bij het bepalen of de reservering bestaat. ".$kenmerk);
        }
        
       $result = array();

        while ($row = mysql_fetch_array($query)) {

            $result[] = $row;
        }
        
        if ($closeConnection)
        {
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
    
    public function BesteldeStoelenCountVoorReserveringStoelen($reserveringStoelen, $voorstelling, $closeConnection)
    {
        if (strlen($reserveringStoelen) == 0 || !is_numeric($voorstelling)) {
            throw new Exception("Een van de parameters voor BesteldeStoelenCountVoorReservering is niet gezet.");
        }
        
        //databse connectie aanmaken
        $this->connection->dbConnect();
        
        $query = mysql_query("SELECT COUNT(bestellingstoelen.StoelID) AS StoelenCount 
        FROM filmpje.bestellingstoelen 
        INNER JOIN filmpje.bestellingen on bestellingen.BestellingID = bestellingstoelen.BestellingID AND bestellingen.BestellingStatusID = 3
        WHERE bestellingstoelen.StoelID IN ( " .$reserveringStoelen . ")  AND bestellingen.VoorstellingID = ".$voorstelling);
        
        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de bestelde stoelen count voor reservering. ");
        }
        
        $result = mysql_fetch_array($query);
          
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return $result['StoelenCount'];
    }
    
    public function HaalReserveringStoelenOp($reservering, $closeConnection)
    {        
        if (!is_numeric($reservering)) {
            throw new Exception("Reservering is geen nummer.");
        }
        
        //databse connectie aanmaken
        $this->connection->dbConnect();
        
        $query = mysql_query("SELECT StoelID 
        FROM filmpje.reserveringstoelen 
        WHERE ReserveringID = '" . $reservering . "'");
        
        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de reservering stoelen. ".$reservering);
        }
        
        $result = array();
        
          while ($row = mysql_fetch_array($query)) {

            $result[] = $row['StoelID'];
        }
        
        $stoelenstring = implode(",", $result);
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return $stoelenstring;
    }
    
    
     public function MaakReserveringAan(Reservering $reservering, $closeConnection) {
         
        //controleren of we een reservering hebben binnen gekregen
         if (!isset($reservering)) {
             throw new Exception("Het reservering object is NULL, error");
         } 
        
        //controleren of de reservering niet al bestaat.
        if ($this->BestaatReservering($reservering->kenmerk, TRUE)) {
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
        if($closeConnection)
        {
        $this->connection->dbClose();
        }
        
        $this->ZendBevestigingsMail($reservering->kenmerk);
        
    }
    
    private function SlaReserveringStoelenOp($stoelenString, $reservering, $closeConnection) {
        
        if (strlen($stoelenString) == 0 || !is_numeric($reservering)) {
            throw new Exception("Een van de parameters voor het opslaan van de reserveringstoelen is niet gezet.");
        }
        
        $stoelen = explode(",", $stoelenString);

        foreach ($stoelen as $stoel) {

        $sql = "INSERT INTO filmpje.reserveringstoelen (ReserveringID, StoelID)
        VALUES
        ('$reservering','$stoel')";

            if (!mysql_query($sql, $this->connection->connection)) {
                throw new Exception("Er ging iets mis bij het opslaan van de reserveringstoelen.");
            }
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return count($stoelen);
    }
    
    private function ReserveringIDvoorKenmerk($kenmerk, $closeConnection) {
        
        if (strlen($kenmerk) == 0) {
            throw new Exception("Kenmerk is niet gezet.");
        }
        
        $this->connection->dbConnect();
        
        $query = mysql_query("SELECT MAX(ReserveringID) AS ReserveringID
          FROM filmpje.reserveringen 
          WHERE Kenmerk = '" . $kenmerk . "'");
        
        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de reservering voor kenmerk. ".$kenmerk);
        }

        $result = mysql_fetch_array($query);
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
        return intval($result['ReserveringID']);
    }
    
    
    private function SlaReservingOp($reservering, $closeConnection) {
        
        if (!isset($reservering)) {
            throw new Exception("Resevering kan niet NULL zijn.");
        }
        
        $this->connection->dbConnect();
        
        $sql = "INSERT INTO filmpje.reserveringen (VoorstellingID, TotaalPrijs, ReserveringStatusID, Voornaam, Achternaam, Adres, Postcode, Email, Telefoonnummer, Kenmerk, Plaats)
        VALUES
        ('$reservering->voorstellingID','$reservering->totaalPrijs','$reservering->ReserveringStatus', '$reservering->voornaam', '$reservering->achternaam', '$reservering->adres', '$reservering->postcode', '$reservering->email', '$reservering->telefoonnummer', '$reservering->kenmerk', '$reservering->plaats')";

        if (!mysql_query($sql, $this->connection->connection)) {
            throw new Exception("Er ging iets mis bij het opslaan van de reservering.");
        }
        
        if ($closeConnection) {
            $this->connection->dbClose();
        }
        
    }

    public function UpdateBeschikbareStoelen($voorstelling, $aantalstoelen, $plusmin, $closeConnection)
    {
        if (!is_numeric($voorstelling) || !is_numeric($aantalstoelen) || strlen($plusmin) > 1) {
            throw new Exception("Een van de parameters voor het updaten van de beschikbare stoelen is niet gezet.");
        }
        
        $this -> connection -> dbConnect();
              
        $query = mysql_query("UPDATE voorstellingen
          SET voorstellingen.BeschikbareStoelen = voorstellingen.BeschikbareStoelen ". $plusmin . " " . $aantalstoelen ."
          WHERE voorstellingen.VoorstellingID = '" . $voorstelling . "'");
       
        if (!$query) {
            throw new Exception("Er ging iets mis bij het updaten van de beschikbare stoelen.");
        }
        
        if ($closeConnection) {
            $this -> connection -> dbClose();
        }
       
    }
    
    public function ReserveringStatusIDForStatus($status, $closeConnection)
    {
       if (strlen($status) == 0) {
            throw new Exception("Status is niet gezet.");
        }

        $this->connection->dbConnect();
        $query = mysql_query("SELECT  ReserveringStatusID
          FROM reserveringstatussen 
          WHERE Naam = '" . $status . "'");
        
        if (!$query) {
            throw new Exception("Er ging iets mis bij het ophalen van de reserveringstatusid voor status. ".$status);
        }
        
        $result =  mysql_fetch_array($query);

        if($closeConnection)
        {
        $this->connection->dbClose();
        }
        
        return $result[0]['ReserveringStatusID'];
    }
    
}
?>
